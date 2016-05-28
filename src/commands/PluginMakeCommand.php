<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Schema;

/**
 * Class ModuleCommand
 */
class PluginMakeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $module;
    /**
     * @var string
     */
    protected $description = 'make a module';
    /**
     * @var array
     */
    protected $key = [];
    protected $keys = [];
    /**
     * @var int
     */
    protected $permission = 0777;
    /**
     * @var array
     */
    protected $langs = [];
    /**
     * @var array
     */

    protected $json_file = "module.json";

    protected $sluggable = [];
    /**
     * @var array
     */
    protected $options = [];
    /**
     * @var array
     */
    protected $html = [];
    /**
     * @var array
     */
    protected $stylesheets = [];
    /**
     * @var array
     */
    protected $javascripts = [];
    /**
     * @var array
     */
    protected $codes = [];
    /**
     * @var array
     */
    protected $model_attributes = [];
    /**
     * @var array
     */
    protected $model_tables = [];
    /**
     * @var array
     */
    protected $relationships = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $fields
     * @return array
     */
    function getTextFields($fields)
    {
        $textFields = [];

        foreach ($fields as $field => $rules) {
            if (strstr($rules, "text") or strstr($rules, "string")) {
                $textFields[] = $field;
            }
        }

        return $textFields;
    }

    /**
     * @param $path
     * @param $content
     * @return mixed
     */
    protected function write($path, $content)
    {

        if ($this->option("crud")) {
            // Remove spaces
            $content = preg_replace('/\n\n/s', "\n", $content);
        }

        return File::put($path, $content);
    }


    protected function refresh()
    {

        $this->call("dot:autoload");
        $this->call("vendor:publish");
        $this->call("clear-compiled");
        $this->call("optimize", ['--force' => true]);

    }


    protected function createPlainPlugin()
    {

        if (File::makeDirectory($this->path, $this->permission, true, true)) {

            // start
            $start_content = file_get_contents(templates_path("plain/start.tpl"));
            $this->write($this->path . "/start.php", $start_content);

        }

        $this->info("Module '" . $this->module . "' has been created successfully");
        $this->refresh();
    }


    protected function createResourcesPlugin()
    {

        if (File::makeDirectory($this->path, $this->permission, true, true)) {

            // start
            $start_content = file_get_contents(templates_path("resources/start.tpl"));
            $start_content = $this->replace($start_content);
            $this->write($this->path . "/start.php", $start_content);

            // routes
            $routes_content = file_get_contents(templates_path("resources/routes.tpl"));
            $routes_content = $this->replace($routes_content);
            $this->write($this->path . "/routes.php", $routes_content);

            // config
            File::makeDirectory($this->path . "/config", $this->permission, true, true);
            $config_content = file_get_contents(templates_path("resources/config.tpl"));
            $this->write($this->path . "/config/".$this->module.".php", $config_content);

            // controller
            File::makeDirectory($this->path . "/controllers", $this->permission, true, true);
            $controller_content = file_get_contents(templates_path("resources/controller.tpl"));
            $controller_content = $this->replace($controller_content);
            $this->write($this->path . "/controllers/" . ucfirst($this->module) . "Controller.php", $controller_content);


            if ($this->model) {
                // model
                File::makeDirectory($this->path . "/models", $this->permission, true, true);
                $model_content = file_get_contents(templates_path("resources/model.tpl"));
                $model_content = $this->replace($model_content);
                $this->write($this->path . "/models/" . ucfirst($this->module) . ".php", $model_content);
            }

            // lang
            $lang_content = file_get_contents(templates_path("resources/lang.tpl"));
            foreach (Config::get("admin.locales") as $code => $lang) {
                File::makeDirectory($this->path . "/lang/" . $code, $this->permission, true, true);
                $lang_content = $this->replace($lang_content);
                $this->write($this->path . "/lang/" . $code . "/" . $this->module . ".php", $lang_content);
            }

            // view
            File::makeDirectory($this->path . "/views", $this->permission, true, true);
            $view_content = file_get_contents(templates_path("resources/view.tpl"));
            $view_content = $this->replace($view_content);
            $this->write($this->path . "/views/" . $this->module . ".blade.php", $view_content);
        }


        if ($this->table) {
            $this->call("plugin:migration", ['name' => "create_" . $this->table . "_table", 'plugin' => $this->module, '--create' => $this->table]);
            if ($this->confirm("Are you want to migrate " . $this->table . "?", false)) {
                $this->call("plugin:migrate", ['plugin' => $this->module]);
            }
        }

        $this->info("Module '" . $this->module . "' has been created successfully");
        $this->refresh();

    }


    function askTableName()
    {
        $this->table = $model = $this->ask("Table name *", $this->module);

        if ($this->table == "") {
            $this->error("Table name is requird");
        }

        if (Schema::hasTable($this->table)) {
            $this->error("Table is already exists");
            $this->askTableName();
        }

        return $this->table;
    }

    function askModelName()
    {
        $this->model = $model = $this->ask("Model name *", ucfirst(Str::singular($this->module)));

        if ($this->model == "") {
            $this->error("Model name is requird");
            $this->askModelName();
        }

        return $this->model;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {


        if ($this->argument("module") == "") {
            $this->module = $name = strtolower($this->ask("Module name *"));
        } else {
            $this->module = $name = strtolower($this->argument("module"));
        }

        if ($this->module == "") {
            return $this->error("Module name is requird");
        }

        $this->path = $path = plugins_path($this->module);

        if (file_exists($path)) {
            //  return $this->error("Module " . $this->path . " is already exists");
        }


        if ($this->option("plain")) {
            return $this->createPlainPlugin();
        }


        $this->keys = array(
            "module" => $name,

        );

        $this->model = false;
        $this->table = false;

        if ($this->confirm("Are you want to create a model for this plugin?", false)) {

            $this->model = $this->askModelName();
            $this->table = $this->askTableName();

            $this->keys["model"] = $this->model;
            $this->keys["table"] = $this->table;

        }

        if ($this->option("resources")) {
            return $this->createResourcesPlugin();
        }


        /*
         * Crud mode
         */

        $folder_exists = file_exists($path);
        $json_exists = file_exists($path . "/" . $this->json_file);

        if ($json_exists) {
            $default_json = (file_get_contents(templates_path("advanced/module.tpl")) == file_get_contents($path . "/" . $this->json_file)) ? true : false;
        } else {
            $default_json = false;
        }

        if (!$folder_exists) {
            File::makeDirectory($path, $this->permission, true, true);
        }

        if (!$json_exists) {
            $json_content = file_get_contents(templates_path("advanced/module.tpl"));
            $this->write($path . "/" . $this->json_file, $json_content);
            return $this->info($name . "/$this->json_file created\nConfigure your module and install");
        }

        if ($default_json) {
            return $this->error("Module '" . $name . "' is not configured");
        }


        // Reading module json file
        $this->json = $json = json_decode(file_get_contents($path . "/" . $this->json_file));


        // getting primary key

        $default_primary_key = null;
        if (isset($this->json->fields) and count($this->json->fields)) {
            $fields = array_keys((array)$this->json->fields);
            $default_primary_key = $fields[0];
        }

        if ($this->argument("key") == "") {
            $this->key = $key = $this->ask("Primary key field *", $default_primary_key);
        } else {
            $this->key = $key = $this->argument("key");
        }

        if ($this->key == "") {
            return $this->error("Primary key is requird");
        }

        $this->keys["key"] = $this->key;


        // getting module options if exists
        $this->options = new stdClass();
        $this->options->icon = "fa-th-large";
        $this->options->timestamps = false;
        $this->options->status = false;
        $this->options->per_page = 15;
        if (isset($this->json->options)) {
            foreach ($this->json->options as $option => $value) {
                $this->options->$option = $value;
            }
        }

        // reading relations
        $this->relations();

        // migrate base module table
        $this->migrate();

        // start
        $start_content = file_get_contents(templates_path("advanced/start.tpl"));
        $start_content = $this->replace($start_content);
        $this->write($path . "/start.php", $start_content);

        // routes
        $routes_content = file_get_contents(templates_path("advanced/routes.tpl"));
        $routes_content = $this->replace($routes_content);
        $this->write($path . "/routes.php", $routes_content);

        // view
        File::makeDirectory($path . "/views", $this->permission, true, true);
        $view_content = file_get_contents(templates_path("advanced/show.view.tpl"));


        $sortable_fields = array();
        $gridable_fields = array();
        foreach ($json->grid as $field) {
            if ($field != $key) {

                if (strstr($field, ".")) {
                    if ($parts = @explode(".", $field)) {

                        $field = str_replace(".", "_", $field);
                        $this->model_attributes[$field] = $field;

                        $relation_key = $parts[0];
                        $relation_field = $parts[1];

                        foreach ($this->relations as $relation) {
                            foreach ($relation as $type => $parameters) {
                                if ($relation = $relation_key) {
                                    if ($type == "hasOne") {
                                        $gridable_fields[$field] = "<?php echo @\$$model->$relation->$relation_field; ?>";
                                    }
                                    if ($type == "hasMany") {
                                        $gridable_fields[$field] = "<?php echo join(', ', \$$model->$relation" . "->lists" . "('$relation_field')->toArray()); ?>";
                                    }

                                    if ($type == "belongsToMany") {
                                        $gridable_fields[$field] = "<?php echo join(', ', \$$model->$relation" . "->lists" . "('$relation_field')->toArray()); ?>";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $sortable_fields[$field] = "<?php echo \$$model->$field; ?>";
                    $gridable_fields[$field] = "<?php echo \$$model->$field; ?>";
                }
            }
        }

        if ($this->options->timestamps) {

        }

        $view_content = $this->replace($view_content, array("fields" => $gridable_fields, "sortable_fields" => $sortable_fields));
        $this->write($path . "/views/show.blade.php", $view_content);

        $view_content = file_get_contents(templates_path("advanced/edit.view.tpl"));


        // generating inputs for fields

        $form_fields = array();

        foreach ($json->form as $field => $type) {

            if (strstr($type, ":")) {
                if ($type_parts = @explode(":", $type)) {
                    $form_fields[$field] = array($type_parts[0] => explode(",", $type_parts[1]));
                }
            } else {
                $form_fields[$field] = array($type => 1);
            }
        }

        $html_form_output = $this->get_form_fields($form_fields);


        $this->keys["form_fields"] = $html_form_output;
        $view_content = $this->replace($view_content);

        $this->write($path . "/views/edit.blade.php", $view_content);

        // model
        $this->info("Generating $this->module models");

        File::makeDirectory($path . "/models", $this->permission, true, true);

        if ($this->required("categories")) {
            $cat_model_content = file_get_contents(templates_path("advanced/plain.model.tpl"));
            $cat_model_content = $this->replace($cat_model_content, array("related_model" => ucfirst($model) . "Category", "table" => $this->module . "_categories"));
            $this->write($path . "/models/" . ucfirst($model) . "Category.php", $cat_model_content);
        }

        if ($this->required("tags")) {
            $tag_model_content = file_get_contents(templates_path("advanced/plain.model.tpl"));
            $tag_model_content = $this->replace($tag_model_content, array("related_model" => ucfirst($model) . "Tag", "table" => $this->module . "_tags"));
            $this->write($path . "/models/" . ucfirst($model) . "Tag.php", $tag_model_content);
        }


        // model relations
        $relation_fuctions = "";
        foreach ($this->relations as $func_name => $relation) {
            foreach ($relation as $type => $parameters) {

                $table = $this->model_tables[$parameters[0]];

                if ($type == "belongsToMany") {
                    // ask to get model name for table
                    $rmodel = $this->ask("Model name for $parameters[1] table");
                } else {
                    $rmodel = $parameters[0];
                }
                // generation related models
                if ($this->confirm("Create $rmodel model for $func_name $type relationship ?", false)) {
                    $tag_model_content = file_get_contents(templates_path("advanced/plain.model.tpl"));
                    $tag_model_content = $this->replace($tag_model_content, array("related_model" => $rmodel, "table" => $table));
                    $this->write($path . "/models/" . $rmodel . ".php", $tag_model_content);
                    $this->info("$rmodel model created for $type relationship");
                }

                $relation_fuctions .= "
    public function $func_name(){
        return \$this->$type('" . join("', '", $parameters) . "');
    }
                        ";
            }
        }

        $this->keys["relation_functions"] = $relation_fuctions;

        $model_content = file_get_contents(templates_path("advanced/model.tpl"));
        $this->keys["searchable"] = "'" . join("', '", $this->getTextFields($json->fields)) . "'";

        $this->keys["sluggable"] = "";
        foreach ($this->sluggable as $from => $to) {
            $this->keys["sluggable"] .= "'" . $from . "' => '" . $to . "',";
        }


        $model_content = $this->replace($model_content);

        $this->write($path . "/models/" . ucfirst($model) . ".php", $model_content);


        // Controller
        File::makeDirectory($path . "/controllers", $this->permission, true, true);
        $controller_content = file_get_contents(templates_path("advanced/controller.tpl"));


        $controller_attributes = [];
        foreach ($json->fields as $field => $rules) {

            if (count($this->sluggable)) {
                if (array_key_exists($field, $this->sluggable)) {
                    continue;
                }
            }

            if ($field != $key) {
                $this->model_attributes[] = $field;
                $controller_attributes[] = $field;
            }
        }


        if ($this->required("image")) {
            $this->load("image");
            $this->langs["add_image"] = "Add image";
            $this->langs["change_image"] = "change image";
            $this->langs["not_allowed_file"] = "File is not allowed";
        }

        if ($this->required("user")) {
            $this->load("user");
            $this->langs["user"] = "user";
        }

        if ($this->required("categories")) {
            $this->load("categories");
            $this->langs["categories"] = "categories";
            $this->langs["add_category"] = "Add to category";
        }

        if ($this->required("tags")) {
            $this->load("tags");
            $this->langs["tags"] = "tags";
            $this->langs["add_tag"] = "Add tags";
        }

        $loaded_models = "";
        if (count($this->relationships)) {
            $loaded_models = "with('" . join("', '", $this->relationships) . "')->";
        }

        $controller_content = $this->replace($controller_content, array("attributes" => $controller_attributes, "loaded_models" => $loaded_models));
        $this->write($path . "/controllers/" . ucfirst($name) . "Controller.php", $controller_content);

        $this->info("Generating $this->module lang files");

        // lang
        $lang_content = file_get_contents(templates_path("advanced/lang.tpl"));
        $lang_content = $this->replace($lang_content, array("attributes" => $this->model_attributes, "additional" => $this->langs));
        foreach (Config::get("admin.locales") as $code => $lang) {
            File::makeDirectory($path . "/lang/" . $code, $this->permission, true, true);
            $this->write($path . "/lang/" . $code . "/" . $name . ".php", $lang_content);
        }

        $this->info("Module '" . $name . "' has been created successfully");

        $this->info("Registering $name module");

        $modules = Option::where("name", "modules")->pluck("value");
        $modules = (array)json_decode($modules);

        if (!is_array($modules)) {
            $modules = array();
        }

        $modules[$this->module] = 1;
        Option::where("name", "modules")->update(array("value" => json_encode($modules)));

        $this->call("vendor:publish");
        $this->call("clear-compiled");
        $this->call("optimize", ['--force' => true]);

        return true;
    }

    /**
     * @param $code
     */
    function html($code)
    {
        if (!in_array($code, $this->html)) {
            $this->html[] = $code;
        }
    }

    /**
     * @param $file
     */
    function css($file)
    {
        if (!in_array($file, $this->stylesheets)) {
            $this->stylesheets[] = $file;
        }
    }

    /**
     * @param $file
     */
    function js($file)
    {
        if (!in_array($file, $this->javascripts)) {
            $this->javascripts[] = $file;
        }
    }

    /**
     * @param $code
     */
    function code($code)
    {
        if (!in_array($code, $this->codes)) {
            $this->codes[] = $code;
        }
    }

    /**
     * @param $fields
     */
    protected function get_form_fields($fields)
    {

        $this->info("Rendering $this->module form fields");

        foreach ($fields as $field => $type) {
            foreach ($type as $name => $value) {

                if ($name == "slug") {
                    $this->sluggable[$field] = $value[0];
                    continue;
                }

                if (in_array($name, array("text", "email", "number", "range", "tel", "url"))) {
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        <input name="' . $field . '" type="' . $name . '" value="<?php echo @Request::old("' . $field . '", $' . $this->model . '->' . $field . '); ?>" class="form-control" id="input-' . $field . '" placeholder="<?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?>">
                    </div>');
                }

                if ($name == "textarea") {
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        <textarea name="' . $field . '" class="form-control" id="input-' . $field . '" placeholder="<?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?>"><?php echo @Request::old("' . $field . '", $' . $this->model . '->' . $field . '); ?></textarea>
                    </div>');
                }

                if ($name == "date") {
                    $this->css("css/plugins/datetimepicker/bootstrap-datetimepicker.min.css");
                    $this->js("js/plugins/moment/moment.min.js");
                    $this->js("js/plugins/datetimepicker/bootstrap-datetimepicker.min.js");
                    $this->code("$('.datepick').datetimepicker({
                        format: 'YYYY-MM-DD',
                    });");
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        <div class="input-group date datepick">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="' . $field . '" type="text" value="<?php echo @Request::old("' . $field . '", $' . $this->model . '->' . $field . '); ?>" class="form-control" id="input-' . $field . '" placeholder="<?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?>">
                        </div>
                    </div>');
                }

                if ($name == "time") {
                    $this->css("css/plugins/datetimepicker/bootstrap-datetimepicker.min.css");
                    $this->js("js/plugins/moment/moment.min.js");
                    $this->js("js/plugins/datetimepicker/bootstrap-datetimepicker.min.js");
                    $this->code("$('.timepick').datetimepicker({
                        format: 'HH:mm:ss',
                    });");
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        <div class="input-group date timepick">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                            <input name="' . $field . '" type="text" value="<?php echo @Request::old("' . $field . '", $' . $this->model . '->' . $field . '); ?>" class="form-control" id="input-' . $field . '" placeholder="<?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?>">
                        </div>
                    </div>');
                }

                if ($name == "datetime") {
                    $this->css("css/plugins/datetimepicker/bootstrap-datetimepicker.min.css");
                    $this->js("js/plugins/moment/moment.min.js");
                    $this->js("js/plugins/datetimepicker/bootstrap-datetimepicker.min.js");
                    $this->code("$('.datetimepick').datetimepicker({
                        format: 'YYYY-MM-DD HH:mm:ss',
                    });");
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        <div class="input-group date datetimepick">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="' . $field . '" type="text" value="<?php echo @Request::old("' . $field . '", $' . $this->model . '->' . $field . '); ?>" class="form-control" id="input-' . $field . '" placeholder="<?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?>">
                        </div>
                    </div>');
                }

                if ($name == "html") {
                    $this->js("ckeditor/ckeditor.js");
                    $this->html('
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                        @include("admin::partials.editor", ["name" => "' . $field . '", "id" => "' . $field . '", "value" => @$' . $this->model . '->' . $field . '])
                    </div>');
                }

                if ($name == "select") {
                    $this->code("$('.chosen-select').chosen();");

                    $html_output = '
                    <div class="form-group">
                        <label for="input-' . $field . '"><?php echo trans("' . $this->module . '::' . $this->module . '.attributes.' . $field . '") ?></label>
                            <select class="form-control chosen-select chosen-rtl" name="' . $field . '">';
                    foreach ($value as $item) {
                        $this->langs[$field . "_" . $item] = $field . "_" . $item;
                        $html_output .= PHP_EOL . '<option value="' . $item . '" <?php if ($' . $this->model . ' and $' . $this->model . '->' . $field . ' == "' . $item . '") { ?> selected="selected" <?php } ?>><?php echo trans("' . $this->module . '::' . $this->module . '.' . $field . '_' . $item . '") ?></option>';
                    }
                    $html_output .= PHP_EOL . '</select></div>';
                    $this->html($html_output);
                }
            }
        }
    }

    /*
     * replace tags from template to PHP code
     */

    /**
     * @param $content
     * @param array $vars
     * @return mixed|string
     */
    protected function replace($content, $vars = array())
    {

        $vars["html"] = $this->html;
        $vars["javascripts"] = $this->javascripts;
        $vars["stylesheets"] = $this->stylesheets;
        $vars["codes"] = $this->codes;


        foreach ($vars as $name => $value) {
            $this->keys[$name] = $value;
        }


        if ($this->option("crud")) { // replacement tags from crud options only


            foreach ($this->options as $name => $value) {
                if (is_bool($value)) {
                    $value = ($value) ? 'true' : 'false';
                }
                $this->keys["options." . $name] = $value;
            }


            $this->options->categories_or_status = false;
            if ($this->required("categories") or $this->options->status) {
                $this->options->categories_or_status = true;
                $this->keys["options.categories_or_status"] = true;
            }


            preg_match_all("/\{if\s+options\.([^\}]+)\}(.*?)\{\/if\}/s", $content, $m);

            $y = 0;
            foreach ($m[0] as $iftag) {
                $condition_string = $m[0][$y];
                $condition_component = $m[1][$y];
                $condition_content = trim($m[2][$y]);

                $order = 1;
                if ($this->options->$condition_component) {
                    $content = str_replace($condition_string, $condition_content, $content, $order);
                } else {
                    $content = str_replace($condition_string, "", $content, $order);
                }

                $y++;
            }

            preg_match_all("/\{if\s+module\.([^\}]+)\}(.*?)\{\/if\}/s", $content, $m);

            $y = 0;
            foreach ($m[0] as $iftag) {
                $condition_string = $m[0][$y];
                $condition_component = $m[1][$y];
                $condition_content = trim($m[2][$y]);

                $order = 1;
                if ($this->required($condition_component)) {

                    $content = str_replace($condition_string, $condition_content, $content, $order);
                } else {
                    $content = str_replace($condition_string, "", $content, $order);
                }

                $y++;
            }

            //$content = preg_replace("/\{if\s+module\.([^\}]+)\}([^\{]*)\{\/if\}/s", "", $content);
            // replacing loops

            preg_match_all("/\[loop\s+([^\s]*)\s+as\s+([^]]*)\]([^\[]*)\[\/loop\]/s", $content, $matches);
            $i = 0;

            foreach ($matches[0] as $tag) {

                $all = $matches[0][$i];
                $array = $vars[$matches[1][$i]];
                $item = $matches[2][$i];
                $loop_content = trim($matches[3][$i], "");

                $item_key = "";
                if (strstr($item, "=>")) {
                    if ($pairs = @explode("=>", $item)) {
                        $item_key = trim($pairs[0]);
                        $item = trim($pairs[1]);
                    }
                }

                $new_content = "";

                $c = 1;
                foreach ($array as $k => $value) {

                    $current_loop_content = $loop_content;

                    if ($c == 1) {  // FIRST
                        preg_match_all("/\{if\s+loop\.(first)\}([^\{]*)\{\/if\}/s", $current_loop_content, $m);
                        $y = 0;
                        foreach ($m[0] as $iftag) {
                            $condition_string = $m[0][$y];
                            $condition_seq = $m[1][$y];
                            $condition_content = trim($m[2][$y]);
                            if ($condition_seq == "first") {
                                $current_loop_content = str_replace($condition_string, $condition_content, $current_loop_content);
                            }
                            $y++;
                        }
                    }

                    if ($c != 1) {    // NOT FIRST
                        preg_match_all("/\{if\s+not\s+loop\.(first|last)\}([^\{]*)\{\/if\}/s", $current_loop_content, $w);
                        $y = 0;
                        foreach ($w[0] as $iftag) {
                            $condition_string = $w[0][$y];
                            $condition_seq = $w[1][$y];
                            $condition_content = trim($w[2][$y]);
                            if ($condition_seq == "first") {
                                $current_loop_content = str_replace($condition_string, $condition_content, $current_loop_content);
                            }
                            $y++;
                        }
                    }

                    if ($c == count($array)) {  // LAST
                        preg_match_all("/\{if\s+loop\.(last)\}([^\{]*)\{\/if\}/s", $current_loop_content, $n);
                        $y = 0;
                        foreach ($n[0] as $iftag) {
                            $condition_string = $n[0][$y];
                            $condition_seq = $n[1][$y];
                            $condition_content = trim($n[2][$y]);
                            if ($condition_seq == "last") {
                                $current_loop_content = str_replace($condition_string, $condition_content, $current_loop_content);
                            }
                            $y++;
                        }
                    }

                    if ($c != count($array)) {    // NOT LAST
                        preg_match_all("/\{if\s+not\s+loop\.(first|last)\}([^\{]*)\{\/if\}/s", $current_loop_content, $v);
                        $y = 0;
                        foreach ($v[0] as $iftag) {
                            $condition_string = $v[0][$y];
                            $condition_seq = $v[1][$y];
                            $condition_content = trim($v[2][$y]);
                            if ($condition_seq == "last") {
                                $current_loop_content = str_replace($condition_string, $condition_content, $current_loop_content);
                            }
                            $y++;
                        }
                    }

                    $current_loop_content = preg_replace("/\{if\s+loop\.(first|last)\}([^\{]*)\{\/if\}/s", "", $current_loop_content);
                    $current_loop_content = preg_replace("/\{if\s+not\s+loop\.(first|last)\}([^\{]*)\{\/if\}/s", "", $current_loop_content);

                    $new_content .= trim(str_replace("#" . $item . "#", $value, $current_loop_content), " ");
                    $new_content = str_replace("#" . $item_key . "#", $k, $new_content);

                    $c++;
                }

                $content = trim(str_replace($all, $new_content, $content), " ");
                $i++;
            }


        }


        // replacing variables

        preg_match_all('/\#([^\#\h]*)\#/', $content, $matches);
        $tags = $matches[1];

        foreach ($tags as $tag) {

            $string = "#" . $tag . "#";

            if (strstr($string, "|")) {
                $string = trim($string, "#");
                $string_parts = explode("|", $string);

                $name = $this->keys[strtolower($string_parts[0])];

                $functions = $string_parts[1];

                if ($functions = @explode(",", $functions)) {
                    foreach ($functions as $function) {
                        $name = call_user_func_array($function, array($name));
                    }
                }

                $content = str_replace('#' . $tag . '#', $name, $content);
            } else {
                $content = str_replace('#' . $tag . '#', $this->keys[strtolower(trim($tag, "#"))], $content);
            }
        }


        return $content;
    }

    /**
     * @param $table
     * @param bool $default
     * @return bool
     */
    protected function confirm_table_build($table, $default = true)
    {

        if ($this->option("f")) {
            return true;
        }

        if (!Schema::hasTable($table)) {
            return true;
        }

        if ($this->confirm('Table "' . $table . '" is already exists, recreate it?', $default)) {
            return true;
        }

        return false;
    }

    /*
     * loading relationships
     */

    /**
     * @param $relationship
     */
    protected function load($relationship)
    {
        if (!in_array($relationship, $this->relationships)) {
            $this->relationships[] = $relationship;
        }
    }

    /**
     *
     */
    protected function migrate()
    {

        $this->info("Migrating $this->module schema");

        $fields = (array)$this->json->fields;

        foreach ($this->relations as $name => $relation) {

            $this->load($name);

            foreach ($relation as $type => $parameters) {

                if (in_array($type, array("hasOne", "hasMany"))) {
                    //$local_key = $parameters[2];
                    //if (!array_key_exists($local_key, $fields)) {
                    //    $fields[$local_key] = "integer|index";
                    //}
                    $table = $this->ask("Table name for $parameters[0] model");
                } else {
                    $table = $parameters[1];
                }

                $this->model_tables[$parameters[0]] = $table;

                if ($this->confirm_table_build($table, false)) {
                    Schema::dropIfExists($table);
                    Schema::create($table, function ($table) use ($parameters, $type) {
                        if ($type == "belongsToMany") {
                            $table->integer($parameters[2])->index();
                            $table->integer($parameters[3])->index();
                        } else {
                            $table->integer($parameters[1])->index();
                        }
                    });
                }
            }
        }

        if ($this->required("image")) {
            $fields["image_id"] = "integer|index";
        }

        if ($this->required("user")) {
            $fields["user_id"] = "integer|index";
        }

        // getting array of field rules
        $this->rules = $this->rules($fields);

        if ($this->confirm_table_build($this->module)) {
            // reset schema
            Schema::dropIfExists($this->module);
            Schema::create($this->module, function ($table) {

                $field_methods = array("nullable", "unsigned", "default");

                foreach ($this->rules as $field => $rules) {
                    foreach ($rules as $rule => $options) {

                        if (!in_array($rule, $field_methods)) {

                            if (is_array($options)) {

                                $args = [];
                                $args[0] = $field;

                                foreach ($options as $option) {
                                    $args[] = $option;
                                }

                                $ob = call_user_func_array(array($table, $rule), $args);
                            } else {
                                $ob = $table->$rule($field);
                            }
                        }

                        foreach ($field_methods as $field_method) {
                            if (array_key_exists($field_method, $rules)) {

                                $rule = $field_method;
                                $options = $rules[$field_method];
                                if (is_array($options)) {

                                    $args = [];
                                    foreach ($options as $option) {
                                        $args[] = $option;
                                    }

                                    call_user_func_array(array($ob, $rule), $args);
                                } else {
                                    $ob->$rule();
                                }

                                unset($rules[$rule]);
                            }
                        }
                    }
                }


                if ($this->options->timestamps) {
                    $table->timestamps();
                }

                if ($this->options->status) {
                    $table->tinyInteger("status")->index();
                }
            });
        }

        if ($this->required("categories")) {
            if ($this->confirm_table_build($this->module . "_categories")) {
                Schema::dropIfExists($this->module . "_categories");
                Schema::create($this->module . "_categories", function ($table) {
                    $table->integer($this->model . "_id")->index();
                    $table->integer("category_id")->index();
                });
            }
        }

        if ($this->required("tags")) {
            if ($this->confirm_table_build($this->module . "_tags")) {
                Schema::dropIfExists($this->module . "_tags");
                Schema::create($this->module . "_tags", function ($table) {
                    $table->integer($this->model . "_id")->index();
                    $table->integer("tag_id")->index();
                });
            }
        }

        // Creating migration files


        File::makeDirectory($this->path . "/migrations", $this->permission, true, true);

        $builder = new MigrationBuilder();

        $builder->convert($this->module);
        $builder->write($this->module);

        if ($this->required("categories")) {
            $builder->convert($this->module . "_categories");
            $builder->write($this->module);
        }

        if ($this->required("tags")) {
            //$builder = new MigrationBuilder();
            $builder->convert($this->module . "_tags");
            $builder->write($this->module);
        }
    }

    /*
     * check component is required
     */

    /**
     * @param $component
     * @return bool
     */
    protected function required($component)
    {

        if (!isset($this->json->require)) {
            return false;
        }

        return in_array($component, (array)$this->json->require);
    }

    /**
     *
     */
    protected function relations()
    {

        $this->info("Reading $this->module relations");

        $relations = (array)$this->json->relations;
        $this->relations = array();
        foreach ($relations as $name => $relation) {
            if (strstr($relation, ":")) {
                $parts = explode(":", $relation);
                $this->relations[$name][trim($parts[0])] = $this->trim_list(@explode(",", $parts[1]));
            }
        }
    }

    /**
     * @param $fields
     * @return array
     */
    protected function rules($fields)
    {

        $rules_array = array();

        foreach ($fields as $field => $rules) {

            if ($all_parts = @explode("|", $rules)) {

                foreach ($all_parts as $part) {

                    if (empty($part)) {
                        $this->error("No Type specified for '" . $field . "' field");
                        die();
                    }

                    if (strstr($part, ":")) {
                        $main_parts = explode(":", $part);
                        $rules_array[$field][trim($main_parts[0])] = $this->trim_list(@explode(",", $main_parts[1]));
                    } else {
                        $rules_array[$field][trim($part)] = 1;
                    }
                }
            }
        }

        return $rules_array;
    }

    /**
     * @param $array
     * @return array
     */
    function trim_list($array)
    {
        $new_array = array();

        foreach ($array as $item) {
            $new_array[] = trim($item);
        }

        return $new_array;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'Module name'],
            ['model', InputArgument::OPTIONAL, 'Model name'],
            ['key', InputArgument::OPTIONAL, 'key name'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', null, InputOption::VALUE_NONE, 'Create a simple plugin without any resources', null],
            ['resources', null, InputOption::VALUE_NONE, 'Create a plugin with resources', null],
            ['crud', null, InputOption::VALUE_NONE, 'Create a crud plugin', null],
        ];
    }

}
