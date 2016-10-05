<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>API DOCS</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/normalize.min.css">
    <link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/prettify.css">
    <link rel="stylesheet" href="<?php echo assets("admin::docs"); ?>/css/f2m2-grid.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="//code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="<?php echo assets("admin::docs"); ?>/js/prettify.js"></script>
    <script src="<?php echo assets("admin::docs"); ?>/js/waypoints.min.js"></script>
    <script src="<?php echo assets("admin::docs"); ?>/js/highlight.js"></script>
    <script src="<?php echo assets("admin::docs"); ?>/js/main.js"></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-3" id="sidebar">
            <div class="column-content">
                <div class="search-header">
                    <img src="/admin/images/dot.png" class="logo" alt="Logo" />

                    <input id="search" type="text" placeholder="Search">
                </div>
                <ul id="navigation">

                    <li><a href="#introduction">Introduction</a></li>



                    <li>
                        <a href="#Closure">Closure</a>
                        <ul></ul>
                    </li>


                    <li>
                        <a href="#AuthApi">AuthApi</a>
                        <ul>
                            <li><a href="#AuthApi_access">access</a></li>

                            <li><a href="#AuthApi_revoke">revoke</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#CategoriesApi">CategoriesApi</a>
                        <ul>
                            <li><a href="#CategoriesApi_show">show</a></li>

                            <li><a href="#CategoriesApi_create">create</a></li>

                            <li><a href="#CategoriesApi_update">update</a></li>

                            <li><a href="#CategoriesApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#GalleriesApi">GalleriesApi</a>
                        <ul>
                            <li><a href="#GalleriesApi_show">show</a></li>

                            <li><a href="#GalleriesApi_create">create</a></li>

                            <li><a href="#GalleriesApi_update">update</a></li>

                            <li><a href="#GalleriesApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#MediaApi">MediaApi</a>
                        <ul>
                            <li><a href="#MediaApi_show">show</a></li>

                            <li><a href="#MediaApi_create">create</a></li>

                            <li><a href="#MediaApi_update">update</a></li>

                            <li><a href="#MediaApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#OptionsApi">OptionsApi</a>
                        <ul>
                            <li><a href="#OptionsApi_show">show</a></li>

                            <li><a href="#OptionsApi_create">create</a></li>

                            <li><a href="#OptionsApi_update">update</a></li>

                            <li><a href="#OptionsApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#PagesApi">PagesApi</a>
                        <ul>
                            <li><a href="#PagesApi_show">show</a></li>

                            <li><a href="#PagesApi_create">create</a></li>

                            <li><a href="#PagesApi_update">update</a></li>

                            <li><a href="#PagesApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#PostsApi">PostsApi</a>
                        <ul>
                            <li><a href="#PostsApi_show">show</a></li>

                            <li><a href="#PostsApi_create">create</a></li>

                            <li><a href="#PostsApi_update">update</a></li>

                            <li><a href="#PostsApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#TagsApi">TagsApi</a>
                        <ul>
                            <li><a href="#TagsApi_show">show</a></li>

                            <li><a href="#TagsApi_create">create</a></li>

                            <li><a href="#TagsApi_update">update</a></li>

                            <li><a href="#TagsApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#UsersApi">UsersApi</a>
                        <ul>
                            <li><a href="#UsersApi_show">show</a></li>

                            <li><a href="#UsersApi_create">create</a></li>

                            <li><a href="#UsersApi_update">update</a></li>

                            <li><a href="#UsersApi_destroy">destroy</a></li>
                        </ul>
                    </li>


                </ul>
            </div>
        </div>
        <div class="col-9" id="main-content">

            <div class="column-content">

                @include('includes.docs.api.introduction')

                <hr />



                <a href="#" class="waypoint" name="Closure"></a>
                <h2>Closure</h2>
                <p></p>



                <a href="#" class="waypoint" name="AuthApi"></a>
                <h2>AuthApi</h2>
                <p>Class AuthApiController</p>


                <a href="#" class="waypoint" name="AuthApi_access"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>access</h3></li>
                        <li>api/auth/access</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new API access token</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/auth/access" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">username</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The username.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="username">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="AuthApi_revoke"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>revoke</h3></li>
                        <li>api/auth/revoke</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Revoke an API access token</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/auth/revoke" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="CategoriesApi"></a>
                <h2>CategoriesApi</h2>
                <p>Class CategoriesApiController</p>


                <a href="#" class="waypoint" name="CategoriesApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/categories/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List categories</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/categories/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="CategoriesApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/categories/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new category</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/categories/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The category name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The category slug.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="CategoriesApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/categories/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update category by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/categories/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The category id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The category name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The category slug.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="CategoriesApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/categories/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete category by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/categories/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The category id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="GalleriesApi"></a>
                <h2>GalleriesApi</h2>
                <p>Class GalleriesApiController</p>


                <a href="#" class="waypoint" name="GalleriesApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/galleries/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List galleries</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/galleries/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The lang code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">with[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) extra related gallery components [user, files].</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="with[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="GalleriesApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/galleries/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new gallery</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/galleries/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The gallery name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The gallery slug.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">author</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The gallery author name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="author">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The gallery lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">file_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of files ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file_ids[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="GalleriesApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/galleries/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update gallery by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/galleries/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The gallery id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The gallery name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The gallery slug.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">author</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The gallery author name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="author">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">file_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of files ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file_ids[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="GalleriesApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/galleries/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete gallery by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/galleries/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The gallery id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="MediaApi"></a>
                <h2>MediaApi</h2>
                <p>Class MediaApiController</p>


                <a href="#" class="waypoint" name="MediaApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/media/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List media resources</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/media/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="MediaApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/media/create/{type}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new media resource</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/media/create/{type}" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">source</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The media source [data, url, youtube, soundcloud].</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="source">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The media title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The media description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">data</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required if source=data) The Raw/base64 file content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="data">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">url</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required if source=url) The external file url.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="url">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">youtube_url</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required if source=youtube) The youtube video url.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="youtube_url">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">soundcloud_url</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required if source=soundcloud) The soundcloud video url.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="soundcloud_url">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="MediaApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/media/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update media resource by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/media/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The media resource id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The media title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The media description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="MediaApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/media/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete media resource by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/media/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The media resource id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="OptionsApi"></a>
                <h2>OptionsApi</h2>
                <p>Class OptionsApiController</p>


                <a href="#" class="waypoint" name="OptionsApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/options/show/{name?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List posts</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/options/show/{name?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="OptionsApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/options/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new option</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/options/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The option name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">value</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The post value.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="OptionsApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/options/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update an option</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/options/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The option name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">value</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The option value.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="value">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="OptionsApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/options/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete post by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/options/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The option name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="PagesApi"></a>
                <h2>PagesApi</h2>
                <p>Class PagesApiController</p>


                <a href="#" class="waypoint" name="PagesApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/pages/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List pages</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/pages/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The lang code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">with[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) extra related page components [user, image, media, tags].</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="with[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PagesApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/pages/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new page</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/pages/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The page title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The page content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">excerpt</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The page excerpt.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="excerpt">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">format</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: 'page') The page format.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="format">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The page lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">image_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The page image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="image_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">media_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The page media id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="media_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_names[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags names.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_names[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PagesApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/pages/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update page by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/pages/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The user id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The page title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The page content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">excerpt</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The page excerpt.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="excerpt">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">format</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: 'page') The page format.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="format">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">image_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The page image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="image_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">media_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The page media id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="media_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_names[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags names.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_names[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PagesApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/pages/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete page by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/pages/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The page id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="PostsApi"></a>
                <h2>PostsApi</h2>
                <p>Class PostsApiController</p>


                <a href="#" class="waypoint" name="PostsApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/posts/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List posts</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/posts/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The lang code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">with[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) extra related post components [user, image, media, tags, categories].</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="with[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">category_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of categories ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="category_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">block_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of blocks ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="block_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PostsApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/posts/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new post</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/posts/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The post title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The post content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">excerpt</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The post excerpt.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="excerpt">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">format</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: 'post') The post format.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="format">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: user locale) The post lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">image_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The post image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="image_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">media_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The post media id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="media_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The post image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">category_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of categories ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="category_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_names[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags names.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_names[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PostsApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/posts/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update post by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/posts/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The user id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The post title.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">content</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The post content.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="content">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">excerpt</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The post excerpt.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="excerpt">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">format</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: 'post') The post format.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="format">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">image_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The post image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="image_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">media_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 0) The post media id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="media_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The post image id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">category_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of categories ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="category_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_ids[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags ids.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_ids[]">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">tag_names[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">(optional) The list of tags names.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="tag_names[]">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="PostsApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/posts/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete post by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/posts/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The post id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="TagsApi"></a>
                <h2>TagsApi</h2>
                <p>Class TagsApiController</p>


                <a href="#" class="waypoint" name="TagsApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/tags/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List tags</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/tags/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="TagsApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/tags/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new tag</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/tags/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The tag name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="TagsApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/tags/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update tag by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/tags/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The user id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The tag name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="TagsApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/tags/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete tag by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/tags/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The tag id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


                <a href="#" class="waypoint" name="UsersApi"></a>
                <h2>UsersApi</h2>
                <p>Class UsersApiController</p>


                <a href="#" class="waypoint" name="UsersApi_show"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>GET</h2></li>
                        <li><h3>show</h3></li>
                        <li>api/users/show/{id?}</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">List users</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/users/show/{id?}" type="GET">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">q</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The search query string.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="q">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 10) The number of retrieved records.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default: 1) The page number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_by</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: id) The column you wish to sort by.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_by">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">order_direction</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default: DESC) The sort direction ASC or DESC.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_direction">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="GET"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="UsersApi_create"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>create</h3></li>
                        <li>api/users/create</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Create a new user</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/users/create" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">username</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The user name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="username">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The user password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The user email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The user first name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">role_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default:0) The user role id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="role_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">photo_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default:0) The user photo id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="photo_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">bool</div>
                                <div class="parameter-desc">(default:0) The user status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">backend</div>
                                <div class="parameter-type">bool</div>
                                <div class="parameter-desc">(default:0) The user backend access status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="backend">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default:'en') The user default lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">color</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default:'blue') The user backend color theme.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="color">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">about</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user bio.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="about">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">facebook</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user facebook page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="facebook">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">twitter</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user twitter page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="twitter">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">linked_in</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user linked_in page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="linked_in">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">google_plus</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user google+ page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="google_plus">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="UsersApi_update"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>update</h3></li>
                        <li>api/users/update</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Update user by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/users/update" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The user id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">username</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="username">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user first name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">role_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default:0) The user role id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="role_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">photo_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(default:0) The user photo id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="photo_id">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">bool</div>
                                <div class="parameter-desc">(default:0) The user status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">backend</div>
                                <div class="parameter-type">bool</div>
                                <div class="parameter-desc">(default:0) The user backend access status.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="backend">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default:'en') The user default lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">color</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(default:'blue') The user backend color theme.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="color">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">about</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user bio.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="about">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">facebook</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user facebook page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="facebook">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">twitter</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user twitter page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="twitter">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">linked_in</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user linked_in page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="linked_in">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">google_plus</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optional) The user google+ page.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="google_plus">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>

                <a href="#" class="waypoint" name="UsersApi_destroy"></a>
                <div class="endpoint-header">
                    <ul>
                        <li><h2>POST</h2></li>
                        <li><h3>destroy</h3></li>
                        <li>api/users/destroy</li>
                    </ul>
                </div>

                <div>
                    <p class="endpoint-short-desc">Delete user by id</p>
                </div>
                <!--  <div class="parameter-header">
                      <p class="endpoint-long-desc"></p>
                 </div> -->
                <form class="api-explorer-form" uri="api/users/destroy" type="POST">
                    <div class="endpoint-paramenters">
                        <h4>Parameters</h4>
                        <ul>
                            <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                            </li>
                            <li>
                                <div class="parameter-name">api_token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) The access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="api_token">
                                </div>
                            </li>
                            <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) The user id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="generate-response" >
                        <!-- <input type="hidden" name="_method" value="POST"> -->
                        <input type="submit" class="generate-response-btn" value="Generate Example Response">
                    </div>
                </form>
                <hr>


            </div>
        </div>
    </div>
</div>


</body>
</html>
