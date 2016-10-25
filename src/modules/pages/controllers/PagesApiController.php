<?php

use Illuminate\Http\Request;


/**
 * Class PagesApiController
 */
class PagesApiController extends Dot\ApiController
{

    /**
     * PagesApiController constructor.
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware("permission:pages.manage");
    }

    /**
     * List pages
     * @param int $id (optional) The object identifier.
     * @param string $lang (default: user locale) The lang code.
     * @param string $q (optional) The search query string.
     * @param array $with (optional) extra related page components [user, image, media, tags].
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
        $sort_by = $request->get("order_by", "id");
        $sort_direction = $request->get("order_direction", "DESC");

        $components = $request->get("with", []);

        $query = Page::with($components)->orderBy($sort_by, $sort_direction);

        if ($request->has("q")) {
            $query->search($request->get("q"));
        }

        if ($id) {
            $pages = $query->where("id", $id)->first();
        } else {
            $pages = $query->paginate($limit)->appends($request->all());
        }

        return $this->response($pages);

    }


    /**
     * Create a new page
     * @param string $title (required) The page title.
     * @param string $content (optional) The page content.
     * @param string $excerpt (optional) The page excerpt.
     * @param string $format (default: 'page') The page format.
     * @param string $lang (default: user locale) The page lang.
     * @param int $image_id (default: 0) The page image id.
     * @param int $media_id (default: 0) The page media id.
     * @param int $status (default: 1) The page image id.
     * @param array $tag_ids (optional) The list of tags ids.
     * @param array $tag_names (optional) The list of tags names.
     * @return \Illuminate\Http\JsonResponse
     */
    function create(Request $request)
    {

        $page = new Page();

        $page->lang = $request->get('lang', app()->getLocale());
        $page->title = $request->get('title');
        $page->excerpt = $request->get('excerpt');
        $page->content = $request->get('content');
        $page->image_id = $request->get('image_id', 0);
        $page->media_id = $request->get('media_id', 0);
        $page->lang = $this->user->lang;
        $page->user_id = $this->user->id;
        $page->status = $request->get("status", 1);
        $page->format = $request->get("format", "page");

        // Validate and save requested user
        if (!$page->validate()) {

            // return validation error
            return $this->response($page->errors(), "validation error");
        }

        if ($page->save()) {

            // Saving tags
            if ($request->has("tag_ids")) {
                $tags = $request->get("tag_ids", []);
                $page->tags()->sync($tags);
            } elseif ($request->has("tag_names")) {
                $tags = Tag::saveNames($request->get("tag_names"));
                $page->tags()->sync($tags);
            }

            return $this->response($page);
        }

    }

    /**
     * Update page by id
     * @param int $id (required) The user id.
     * @param string $title (optional) The page title.
     * @param string $content (optional) The page content.
     * @param string $excerpt (optional) The page excerpt.
     * @param string $format (default: 'page') The page format.
     * @param int $image_id (default: 0) The page image id.
     * @param int $media_id (default: 0) The page media id.
     * @param int $status (default: 1) The page image id.
     * @param array $tag_ids (optional) The list of tags ids.
     * @param array $tag_names (optional) The list of tags names.
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing page id");
        }

        $page = Page::find($request->id);

        if (!$page) {
            return $this->error("Page #" . $request->id . " is not exists");
        }

        $page->title = $request->get('title', $page->title);
        $page->excerpt = $request->get('excerpt', $page->excerpt);
        $page->content = $request->get('content', $page->content);
        $page->image_id = $request->get('image_id', $page->image_id);
        $page->media_id = $request->get('media_id', $page->media_id);
        $page->status = $request->get("status", $page->status);
        $page->format = $request->get("format", $page->format);

        if ($page->save()) {

            $tags = $request->get("tags", []);
            $page->tags()->sync($tags);

            return $this->response($page);
        }

    }

    /**
     * Delete page by id
     * @param int $id (required) The page id.
     * @return \Illuminate\Http\JsonResponse
     */
    function destroy(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing page id");
        }

        $page = Page::find($request->id);

        if (!$page) {
            return $this->error("Page #" . $request->id . " is not exists");
        }

        // Destroy requested page
        $page->delete();

        return $this->response($page);

    }


}