<?php

use Illuminate\Http\Request;


/**
 * Class CategoriesApiController
 */
class CategoriesApiController extends Dot\ApiController
{

    /**
     * CategoriesApiController constructor.
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware("permission:categories.manage");
    }

    /**
     * List categories
     * @param string $api_token (required) The access token.
     * @param int $id (optional) The object identifier.
     * @param string $q (optional) The search query string.
     * @param int $limit (default: 10) The number of retrieved records.
     * @param int $page (default: 1) The page number.
     * @param string $order_by (default: id) The column you wish to sort by.
     * @param string $order_direction (default: DESC) The sort direction ASC or DESC.
     * @return \Illuminate\Http\JsonResponse
     */
    function show(Request $request)
    {

        $id = $request->get("id");

        $limit = $request->get("limit", 10);
        $sort_by = $request->get("sort_by", "id");
        $sort_direction = $request->get("sort_direction", "DESC");

        $query = Category::orderBy($sort_by, $sort_direction);

        if ($request->has("q")) {
            $query->search($request->get("q"));
        }

        if ($id) {
            $categories = $query->where("id", $id)->first();
        } else {
            $categories = $query->paginate($limit)->appends($request->all());
        }


        return $this->response($categories);

    }


    /**
     * Create a new category
     * @param string $api_token (required) The access token.
     * @param string $name (required) The category name.
     * @param string $slug (optional) The category slug.
     * @return \Illuminate\Http\JsonResponse
     */
    function create(Request $request)
    {

        $category = new Category();

        $category->name = $request->name;
     //   $category->slug = $request->slug;
        $category->lang = $this->user->lang;
      //  $category->user_id = $this->user->id;

        // Validate and save requested user
        if (!$category->validate()) {

            // return validation error
            return $this->response($category->errors(), "validation error");

        }

        if ($category->save()) {
            return $this->response($category);
        }

    }

    /**
     * Update category by id
     * @param string $api_token (required) The access token.
     * @param int $id (required) The category id.
     * @param string $name (required) The category name.
     * @param string $slug (optional) The category slug.
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing tag id");
        }

        $category = Category::find($request->id);

        if (!$category) {
            return $this->error("Post #" . $request->id . " is not exists");
        }

        $category->name = $request->get('name', $category->name);
        $category->slug = $request->get('slug', $category->slug);

        if ($category->save()) {
            return $this->response($category);
        }

    }

    /**
     * Delete category by id
     * @param string $api_token (required) The access token.
     * @param int $id (required) The category id.
     * @return \Illuminate\Http\JsonResponse
     */
    function destroy(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing tag id");
        }

        $category = Category::find($request->id);

        if (!$category) {
            return $this->error("Category #" . $request->id . " is not exists");
        }

        // Destroy requested post
        $category->delete();

        return $this->response($category);

    }


}