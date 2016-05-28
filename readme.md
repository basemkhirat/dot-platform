# Dotcms

#### 
> A modular multilingual CMS built with Laravel 5.2 introduce a full-featured modular multilingual CMS built on top of the Laravel framework.

### Minimum System Requirements:

To be able to run Dotcms you have to meet the following requirements:

- PHP 5.5.9 or higher and work perfectly with php7
- PDO PHP Extension
- Mcrypt PHP Extension
- GD PHP Library
- MySql 5.5


### Install Dotcms:

	composer create-project dot/cms --prefer-dist your-project-name

After you have a fresh installation, you will not be able to proceed beyond this point until the installation directory has been removed. This is a security feature.

Enjoy :)

You can now login on /backend/auth/login with your username and password asked during the install command. After you've logged in you'll be able to access the administration panel on the /backend URI.

Also you can change admin url prefix from admin config:

	'prefix' => 'backend'


### Plugin structure:

Plugins folder is located at root directory besides app folder.

Each plugin may contain these directories:

- `config`
- `controllers`
- `lang`
- `models`
- `migrations`
- `views`
- `routes.php`
- `start.php`

### Creating plugin
	
	php artisan plugin:make plugin-name --plain

you can also create a plugin with some extra resources.

	php artisan plugin:make plugin-name --resources
	
	
###Config directory:

After creating plugin using command line, a new file named with module name is placed in config folder may contain these default options

You can access plugin config item value using:

	config("module_name.config_key");

#####Plugin permissions:
    /**
     * | Plugin permissions
     * | A list of plugin permissions
     * | @var array
     */

    'permissions' => [
        // "create_item"
    ],

#####Plugin service providers:
    /**
     * | Plugin Service providers
     * |
     * | @var array
     */

    'providers' => [
        
    ],

#####Plugin aliases:
    /**
     * | Plugin aliases
     * |
     * | @var array
     */

    'aliases' => [

    ],
    
#####Plugin middlewares:
    /**
     * | Plugin HTTP middleware stack.
     * | Located in plugin middlewares folder
     * | These middleware are run during every request to your admin.
     * |
     * | @var array
     */

    "middlewares" => [
       // 'PluginMiddleware'
    ],

#####Plugin routed middlewares:

    /**
     * | Plugin routed middleware.
     * | Located in plugin middlewares folder
     * | These middleware may be assigned to groups or used individually.
     * |
     * | @var array
     */

    "routed_middlewares" => [
       // 'check' => 'PluginMiddleware',
    ],
    
#####Plugin commands:

    /**
     * | Admin commands
     * | Located in plugin commands folder
     * | @var array
     */

    "commands" => [
        // 'PluginCommand',
    ]
    
***

#### Plugin Controllers directory

-  Created contollers should be extended from `BackendController` class.


#### Plugin Models directory

-  Created models should be extended from `Model` class.

######  This is a sample model:

	<?php

	/**
	 * Class Product
 	 */
	class Product extends Model
	{

    /**
     * @var string
     */
    protected $module = 'products';

    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     * specify table fields to search using built-in scopeSearch()
     */
    protected $searchable = ['title', 'content'];
    
    /**
     * @var array
     * make slug from title and store it in slug field before creating a record
     */
    protected $sluggable = ['slug' => 'title'];

    /**
     * @var array
     */
    protected $creatingRules = [
		'title' => 'required'
    ];

    /**
     * @var array
     */
    protected $updatingRules = [
		'title' => 'required'
    ];
    
  
    ?>
    
  
###### Custom plugin model validation:
  
     /**
     * @param $v
     * @return mixed
     * run when creating or updating a model
     */
    function setValidation($v)
    {

        $v->sometimes("content", "required", function ($input) {
            return $input->type == "featured";
        });
        
        return $v;
    }  
    
    /**
     * @param $v
     * @return mixed
     * run when creating a model
     */
    function setCreateValidation($v)
    {

        $v->sometimes("content", "required", function ($input) {
            return $input->type == "featured";
        });
        
        return $v;
    }  
    
    /**
     * @param $v
     * @return mixed
     * run when updating a model
     */
    function setUpdateValidation($v)
    {

        $v->sometimes("content", "required", function ($input) {
            return $input->type == "featured";
        });
        
        return $v;
    }  
    
    
###### Saving a model:


     $product = new Product();

     $product->title = "A sample title";
     $product->content = "A sample content";
     
     if (!$product->validate()) {
        return $product->errors();	// return validation errors
     }
     
     $product->save();	
     // Return id
     // A unique slug will be created and stored without assigning it.
     
 
###Migrations directory:

You can create a new plugin migration file using

	php artisan plugin:migration {migration_file_name} {module_name}
	
And run plugin migration

	php artisan plugin:migrate {module_name}
	
	
###Views directory:

View are accessed from anywhere using 

	return view({module_name}::{view_file_name}); 

###Lang directory:

You can access plugin lang item using:

	trans("{module_name}::{lang_file}.{lang_key}");
	
Some extra keys are created to translate module name, permissions, attributes and custom validation messages

	<?php
	
	'module' => '{module_title}',
	
	'attributes' => [
	    'title' => 'Title',
	    // some other fields
	],

	'permissions' => [
	    'create_item' => 'Create an item',
	    // some other messages
	],
	
	'messages' => [
	    'required' => 'This field is required',
	    // some other messages
	]	
	
	?>
	

###Routes file:

	Route::group([
    	"prefix" => ADMIN,
    	"middleware" => ["web", "auth"],
	], function ($route) {
			// routes goes here
	});


###Start file:

This is plugin bootstrap file, you may want to:

- Make items in sidebar menu.
- Add some system model events.
- Add some urls to sitemap file.
- Make some schedule tasks.
- Add some widgets to dashboard.
- Add extra html inputs to admin forms.
- Add some plugin helper functions.

It's not good to write any thing in this file, You should create extra files and include them in start file to make a good coding style. 

___

### Creating items in sidebar menu:


	Navigation::menu("sidebar", function ($menu) {
    	$menu->item('products', trans("tweets::tweets.tweets"), URL::to(ADMIN . '/tweets'))
    	->icon("fa-twitter")	// optional
    	->order(1);				// optional
	});
	
	
- Method `item` accepts slug, title and url. 
- As the above example, you can make a sub item from by making child item slug to `products.{sub_item}` 
- Slug parameter must be unique.


### Creating some schedule tasks:


	Schedule::run(function($schedule){
   	 	$schedule->call(function(){
        	sleep(7);
    	})->cron('* * * * *')->name("task_name")->withoutOverlapping();
	});



### Creating a widget:


There area some widgets listeners in dashboard 

- `dashboard.featured`
- `dashboard.right`
- `dashboard.left`
- `dashboard.middle`

---

	Widget::sidebar("dashboard.featured", function ($widget) {
		$data = [];
	 	$data["users"] = User::all();
    	return view("products::widget_view", $data);
	});
	
	

### Creating Events on model:

	User::created(function($user){
		dd($user);
	});

	User::deleted(function($user){
		dd($user);
	});

	User::validating(function($v){
		// custom validation
	});




### Adding links to sitemap:

	Widget::set("sitemap", function($sitemap){
		$sitemap->url(url("/"))
		->date(time())
		->priority("0.9")
		->freq("hourly")
	});

This url will be appended in main sitemap `sitemap.xml` in `public/sitemaps` directory.


### And more..

`Dont forget to send a feedback..`