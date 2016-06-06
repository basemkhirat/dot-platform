# DotCms

#### 
> A modular multilingual CMS built with Laravel 5.2 introduce a full-featured modular multilingual CMS built on top of the Laravel framework.

### Minimum System Requirements:

To be able to run Dotcms you have to meet the following requirements:

- PHP 5.5.9 or higher and work perfectly with php7
- PDO PHP Extension
- Mcrypt PHP Extension
- GD PHP Library
- MySql 5.5


### Installing DotCms:

It's very easy, you can choose one of three installation methods:


#####1) Installation as a project (recommended):

	composer create-project dot/cms --prefer-dist your-project-name

After you have a fresh installation, you will not be able to proceed beyond this point until the installation directory has been removed. This is a security feature.

---

#####2) Installation as a laravel package:

First, you must have a laravel 5 project you can install dot/platform package

	composer require dot/platform

Then add service provider in app config

	Dot\Platform\CmsServiceProvider::class

Then Run this artisan command to install

	php artisan dot:install

---

#####3) Clone the repo:

	git clone https://bitbucket.org/basemkhirat/devcms.git folder-name

Then,
	
	composer install


Enjoy :)

---

You can now login /backend with your username and password asked during the install command. After you've logged in you'll be able to access the administration panel on the /backend URI.

Also you can change admin url prefix from admin config:

	<?php

	return [

    	/**
     	* | Admin prefix (the admin url segment)
     	* |
     	* | @var string
     	*/

    	'prefix' => env("ADMIN_PREFIX", "backend"),

    	/**
     	* | Default URI after user authentication
     	* | without admin prefix
     	* | @var string
     	*/

    	'default_path' => env("DEFAULT_PATH", "users"),


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

	<?php
	
    /**
     * | Plugin permissions
     * | A list of plugin permissions
     * | @var array
     */

    'permissions' => [
        // "create_item"
    ],

#####Plugin service providers:

	<?php
	
    /**
     * | Plugin Service providers
     * |
     * | @var array
     */

    'providers' => [
        
    ],

#####Plugin aliases:

	<?php
	
    /**
     * | Plugin aliases
     * |
     * | @var array
     */

    'aliases' => [

    ],
    
#####Plugin middlewares:

	<?php 
	
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

	<?php

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

	<?php

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

	<?php
	
	 /*
	 * Adding some custom messages to validator
     * @return array
     */
    protected function setValidationMessages()
    {
        return [
        	"name.required" => "The name is required",
        	// and more
        ];
    }

    /**
     * Adding attributes names to validator
     * @return array
     */
    protected function setValidationAttributes()
    {
        return [
        	"name" => "Client name",
        	// and more
        ]
    }
	
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

	 <?php

     $product = new Product();

     $product->title = "A sample title";
     $product->content = "A sample content";
     
     
     // overriding model validation "if wanted"
     $product->rules(["title" => "required"], ["title.required" => "Missing title"]);
     
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

	<?php
	
	Route::group([
    	"prefix" => ADMIN,
    	"middleware" => ["web", "auth"],
	], function ($route) {
			// routes goes here
	});


###Start file:

This is plugin bootstrap file, you may want to:

- Attaching tasks to system Actions.
- Creating items in sidebar menu.
- Add some urls to sitemap file.
- Creating some schedule tasks.
- Adding widgets to dashboard.
- Adding extra html inputs to admin forms.
- Add some plugin helper functions.

It's not good to write any thing in this file, You should create extra files and include them in start file to make a good coding style. 



### Actions:

- Actions are the hooks that the cms core launches at specific points during execution, or when specific events occur. Plugins can specify that one or more of its PHP functions are executed at these points, using the Action API.

- Actions are built on [laravel events](https://laravel.com/docs/5.2/events).

---

#####Example:
	
	<?php
	
	// Using callbacks
	Action::listen('auth.login', function($user){
		// do some tasks
	});
	
	// Or call `onLogin` method in `LoginHandler` class
	Action::listen('auth.login', 'LoginHandler@onLogin');
	
	// Or call `handle` method in `LoginHandler` class
	Action::listen('auth.login', 'LoginHandler');
	
	// Adding Action priority if there are more than one listener
	Action::listen('auth.login', 'LoginHandler', 1);


Developers may need to add some fields to admin forms.
Let's do an example with actions.

#####Example: Adding gender field to users:

We will add this code to plugin start file to add the the html view of field using `user.form.featured` action.

	<?php
	
	Action::listen("user.form.featured", function ($user) {
    	return view("users::custom")->with("user", $user);
	});

In `custom` view, we will add the required gender field.

	<div class="form-group">
    	<input name="gender"
           value="<?php echo @Request::old("gender", $user->gender); ?>"
           class="form-control input-lg" />
	</div>
	
Almost done, just save it using `user.saving` action.

	<?php
	
	Action::listen("user.saving", function ($user) {
        
        // Adding gender field to model attributes before saving it.
        $user->gender = Request::get("gender");
        
        // some validation rules if wanted
        $user->rules(
        	["gender" => "required"],
        	["gender.required" => "Gender field is required"], // optional
        	["gender" => "Gender"]	// optional
        );
        
    });

#### Actions API:

	<?php

	// Authentication
	Action::listen("auth.login", function($user){});
	Action::listen("auth.logout", function($user){});
	Action::listen("auth.forget", function($user){});
	Action::listen("auth.reset", function($user){});
	
	// Users
	Action::listen("user.saving", function($user){});
	Action::listen("user.saved", function($user){});
	Action::listen("user.deleting", function($user){});
	Action::listen("user.deleted", function($user){});
	Action::listen("user.form.featured", function($user){});
	Action::listen("user.form.sidebar", function($user){});
	
	// Roles
	Action::listen("role.saving", function($role){});
	Action::listen("role.saving", function($role){});
	Action::listen("role.deleting", function($role){});
	Action::listen("role.deleted", function($role){});
	Action::listen("role.form.featured", function($role){});
	Action::listen("role.form.sidebar", function($role){});
	
	// Pages
	Action::listen("page.saving", function($page){});
	Action::listen("page.saving", function($page){});
	Action::listen("page.deleting", function($page){});
	Action::listen("page.deleted", function($page){});
	Action::listen("page.form.featured", function($page){});
	Action::listen("page.form.sidebar", function($page){});
	
	// Tags
	Action::listen("tag.saving", function($tag){});
	Action::listen("tag.saving", function($tag){});
	Action::listen("tag.deleting", function($tag){});
	Action::listen("tag.deleted", function($tag){});
	Action::listen("tag.form.featured", function($tag){});
	Action::listen("tag.form.sidebar", function($tag){});
	
	// Categories
	Action::listen("category.saving", function($category){});
	Action::listen("category.saving", function($category){});
	Action::listen("category.deleting", function($category){});
	Action::listen("category.deleted", function($category){});
	Action::listen("category.form.featured", function($category){});
	Action::listen("category.form.sidebar", function($category){});
	
	// Dashboard
	Action::listen("dashboard.featured", function(){});
	Action::listen("dashboard.right", function(){});
	Action::listen("dashboard.middle", function(){});
	Action::listen("dashboard.left", function(){});
	
	

### Creating items in sidebar menu:


	<?php
	
	Navigation::menu("sidebar", function ($menu) {
    	$menu->item('products', trans("tweets::tweets.tweets"), URL::to(ADMIN . '/tweets'))
    	->icon("fa-twitter")	// optional
    	->order(1);				// optional
	});
	
	
- Method `item` accepts slug, title and url. 
- As the above example, you can make a sub item from by making child item slug to `products.{sub_item}` 
- Slug parameter must be unique.


### Creating schedule tasks:


	<?php
	
	Schedule::run(function($schedule){
   	 	$schedule->call(function(){
        	
        	// Executing some db queries
        	
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

	Action::listen("dashboard.featured", function ($widget) {
	    $user = User::all();
    	return view("products::widget_view", $data)->with("users", $users);
	});
	


### Adding links to sitemap:

	Sitemap::set("sitemap", function($sitemap){
		$sitemap->url(url("/"))
		->date(time())		// optional
		->priority("0.9")	// optional
		->freq("hourly")	// optional
	});

This url will be appended in main sitemap `sitemap.xml` in `public/sitemaps` directory.


### And more..

`Dont forget to send a feedback..`