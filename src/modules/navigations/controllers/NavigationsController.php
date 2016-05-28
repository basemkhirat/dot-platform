<?php

class NavsController extends BackendController {

    var $ipp = 10;
    var $loadedIpp = 20;
    var $data = [];
    public $conn = '';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
        //date_default_timezone_set("Etc/GMT-2");
        $this->beforeFilter('csrf', [
            'on' => [
                'post',
                'put'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {


        $navs = Nav::whereSite(LANG)->whereMenu('0');

        if (Request::has('search')) {

            $navs->where('name', 'LIKE', '%' . trim(Request::get('search')) . '%');
        }
        $this->data['Navs'] = $navs->take(20)->paginate();
        return View::make('Navs::index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return View::make('Navs::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = Request::except('conn');

        $validator = \Validator::make($data, Nav::$rules);
        if ($validator->fails()) {
            return Redirect::route(ADMIN . '.Navs.create')->withInput(\Request::all())->withErrors($validator);
        } else {
            $Nav = new Nav($data);
            $Nav->site = LANG;
            $Nav->save();
            return Redirect::to(route(ADMIN . '.Navs.edit', ['id' => $Nav->id]) . '?conn=' . LANG);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {


        $Nav = Nav::whereSite(LANG)->with('menuItems')->whereMenu('0')->find($id);
        if (!$Nav) {
            App::abort(404);
        }
        $this->data['Nav'] = $Nav;
        return View::make('Navs::edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $data = Request::all();
        $Nav = Nav::find($id);
        if (!$Nav) {
            App::abort(404);
        }
        $Nav->name = $data['menu_name'];
        $Nav->save();
        return Redirect::route(ADMIN . '.Navs.edit', array($Nav->id))->with('flash_message', array('text' => 'Updated', 'type' => 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function loadItems($type, $offset = 0) {
        $lang = Lang::getLocale();
        switch ($type) {
            case 'posts':
                $posts = DB::table('posts')->where('posts.status', '=', 1)->take($this->loadedIpp)->skip($offset)
                                ->whereSite(LANG)->get();
                return View::make('Navs::partials.loadedPosts', array('posts' => $posts));
            case 'categories':
                $categories = DB::table('categories')->take($this->loadedIpp)->skip($offset)
                                ->whereSite(LANG)->get();
                return View::make('Navs::partials.loadedCategories', ['categories' => $categories]);
            case'pages':
                $pages = DB::table('pages')->where('pages.status', '=', 1)->take($this->loadedIpp)->skip($offset)->get();
                return View::make('Navs::partials.loadedPages', ['pages' => $pages]);
        }
    }

    public function search($q) {
        $lang = Lang::getLocale();
        $searchFor = Request::get('searchFor');
        switch ($searchFor) {
            case 'categories':
                $categories = DB::table('categories')
                                ->whereSite(LANG)
                                ->where('categories.name', 'LIKE', '%' . $q . '%')->get();
                return View::make('Navs::partials.loadedCategories', ['categories' => $categories]);
            case 'posts':
                $posts = DB::table('posts')->where('posts.status', '=', 1)
                                ->whereSite(LANG)
                                ->where('posts.title', 'LIKE', '%' . $q . '%')->get();
                return View::make('Navs::partials.loadedPosts', array('posts' => $posts));
            case'pages':
                $pages = DB::table('pages')->where('pages.status', '=', 1)
                                ->where('pages.title', 'LIKE', '%' . $q . '%')->get();
                return View::make('Navs::partials.loadedPages', ['pages' => $pages]);
        }
    }

    public function reOrder() {
        $ordered = Request::get('order');
        $NavId = Request::get('NavId');
        $deletedItems = (Request::get('deletedItems')) ? Request::get('deletedItems') : FALSE;
        if ($deletedItems) {
            $idsArray = array();
            foreach ($deletedItems as $item) {
                $idsArray[] = $item['value'];
            }
            Nav::whereIn('id', $idsArray)->delete();
        }
        foreach ($ordered as $key => $order) {
            $item = Nav::find($order['itemId']);
            if ($item == NULL) {
                $item = new Nav();
                $item->site = LANG;
                $item->type = $order['type'];
                $item->name = $order['name'];
                if (isset($order['value'])) {
                    $item->link = $order['value'];
                } else {
                    $item->link = '#';
                }
            }
            $item->menu = $NavId;
            $item->order = $key;
            $item->parent = $order['parent'];
            if (isset($order['name'])) {
                $item->name = $order['name'];
            }
            $item->save();
        }
    }

    private function indexOrdered($order) {
        $returnData = [];
        foreach ($order as $key => $item) {
            dd($item);
            $item['order'] = $key + 1;
            $returnData[$item['itemId']] = $item;
        }
        return $returnData;
    }

}
