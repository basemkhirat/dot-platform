<?php

class NavsController extends BackendController {

    var $ipp = 10;
    var $loadedIpp = 20;
    var $data = [];


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {


        $navs = Nav::whereMenu('0');

        if (Request::has('search')) {

            $navs->where('name', 'LIKE', '%' . trim(Request::get('search')) . '%');
        }
        $this->data['navigations'] = $navs->take(20)->paginate();
        return View::make('navs::index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return View::make('navs::create');
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
            return Redirect::route(ADMIN . '.navs.create')->withInput(\Request::all())->withErrors($validator);
        } else {
            $nav = new Nav($data);
            $nav->save();
            return Redirect::to(url(ADMIN . '/navigations/'. $nav->id."/edit"));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $nav = Nav::with('menuItems')->whereMenu('0')->find($id);
        if (!$nav) {
            App::abort(404);
        }

        $this->data['nav'] = $nav;
        return View::make('navs::edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $data = Request::all();
        $nav = Nav::find($id);
        if (!$nav) {
            App::abort(404);
        }
        $nav->name = $data['menu_name'];
        $nav->save();
        return Redirect::to(url(ADMIN . '/navigations/'. $nav->id."/edit"))->with('flash_message', array('text' => 'Updated', 'type' => 'success'));
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
                $posts = DB::table('posts')->where('posts.status', '=', 1)->take($this->loadedIpp)->skip($offset)->get();
                return View::make('navs::partials.loadedPosts', array('posts' => $posts));
            case 'categories':
                $categories = DB::table('categories')->take($this->loadedIpp)->skip($offset)->get();
                return View::make('navs::partials.loadedCategories', ['categories' => $categories]);
            case'pages':
                $pages = DB::table('pages')->where('pages.status', '=', 1)->take($this->loadedIpp)->skip($offset)->get();
                return View::make('navs::partials.loadedPages', ['pages' => $pages]);
        }
    }

    public function search($q) {
        $lang = Lang::getLocale();
        $searchFor = Request::get('searchFor');
        switch ($searchFor) {
            case 'categories':
                $categories = DB::table('categories')
                                ->where('categories.name', 'LIKE', '%' . $q . '%')->get();
                return View::make('navs::partials.loadedCategories', ['categories' => $categories]);
            case 'posts':
                $posts = DB::table('posts')->where('posts.status', '=', 1)
                                ->where('posts.title', 'LIKE', '%' . $q . '%')->get();
                return View::make('navs::partials.loadedPosts', array('posts' => $posts));
            case'pages':
                $pages = DB::table('pages')->where('pages.status', '=', 1)
                                ->where('pages.title', 'LIKE', '%' . $q . '%')->get();
                return View::make('navs::partials.loadedPages', ['pages' => $pages]);
        }
    }



    public function reOrder() {
        $ordered = Request::get('order');
        $navId = Request::get('navigationId');
        $deletedItems = (Request::get('deletedItems')) ? Request::get('deletedItems') : FALSE;
        if ($deletedItems) {
            $idsArray = array();
            foreach ($deletedItems as $item) {
                $idsArray[] = $item['value'];
            }
            Nav::whereIn('id', $idsArray)->delete();
        }
        foreach ($ordered as $key => $order) {
            //$item = Nav::find($order['itemId']);
           // if ($item == NULL) {
                $item = new Nav();
                $item->type = $order['type'];
                $item->type_id = $order['itemId'];
                $item->name = $order['name'];
                if (isset($order['value'])) {
                    $item->link = $order['value'];
                } else {
                    $item->link = '#';
                }
            //}
            $item->menu = $navId;
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
