<?php

use Illuminate\Http\Request;


/**
 * Class PostsApiController
 */
class PostsApiController extends Dot\ApiController
{

    /**
     * PostsApiController constructor.
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware("permission:posts.manage");
    }

    /**
     * List posts
     * @param int $id (optional) The object identifier.
     * @param string $lang (default: user locale) The lang code.
     * @param string $q (optional) The search query string.
     * @param array $with (optional) extra related post components [user, image, media, tags, categories].
     * @param int $limit (default: 10) The number of retrieved records.
     * @param array $category_ids (optional) The list of categories ids.
     * @param array $tag_ids (optional) The list of tags ids.
     * @param array $block_ids (optional) The list of blocks ids.
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

        $components = $request->get("with", []);

        $query = Post::with($components)->orderBy($sort_by, $sort_direction);

        if ($request->has("q")) {
            $query->search($request->get("q"));
        }

        if ($request->has("category_ids") and count($request->get("category_ids"))) {
            $query->whereHas("categories", function ($query) use ($request) {
                $query->whereIn("categories.id", $request->get("category_ids"));
            });
        }

        if ($request->has("tag_ids") and count($request->get("tag_ids"))) {
            $query->whereHas("tags", function ($query) use ($request) {
                $query->whereIn("tags.id", $request->get("tag_ids"));
            });
        }

        if ($request->has("block_ids") and count($request->get("block_ids"))) {
            $query->whereHas("blocks", function ($query) use ($request) {
                $query->whereIn("blocks.id", $request->get("block_ids"));
            });
        }

        if ($id) {
            $posts = $query->where("id", $id)->first();
        } else {
            $posts = $query->paginate($limit)->appends($request->all());
        }

        return $this->response($posts);

    }


    /**
     * Create a new post
     * @param string $title (required) The post title.
     * @param string $content (optional) The post content.
     * @param string $excerpt (optional) The post excerpt.
     * @param string $format (default: 'post') The post format.
     * @param string $lang (default: user locale) The post lang.
     * @param int $image_id (default: 0) The post image id.
     * @param int $media_id (default: 0) The post media id.
     * @param int $status (default: 1) The post image id.
     * @param array $category_ids (optional) The list of categories ids.
     * @param array $tag_ids (optional) The list of tags ids.
     * @param array $tag_names (optional) The list of tags names.
     * @return \Illuminate\Http\JsonResponse
     */
    function create(Request $request)
    {

        $post = new Post();

        $post->lang = $request->get('lang', app()->getLocale());
        $post->title = $request->get('title');
        $post->excerpt = $request->get('excerpt');
        $post->content = $request->get('content');
        $post->image_id = $request->get('image_id', 0);
        $post->media_id = $request->get('media_id', 0);
        $post->lang = $this->user->lang;
        $post->user_id = $this->user->id;
        $post->status = $request->get("status", 1);
        $post->format = $request->get("format", "post");

        // Validate and save requested user
        if (!$post->validate()) {

            // return validation error
            return $this->response($post->errors(), "validation error");
        }

        if ($post->save()) {

            // Saving categories
            $categories = $request->get("category_ids", []);
            $post->categories()->sync($categories);

            // Saving tags
            if ($request->has("tag_ids")) {
                $tags = $request->get("tag_ids", []);
                $post->tags()->sync($tags);
            } elseif ($request->has("tag_names")) {
                $tags = Tag::saveNames($request->get("tag_names"));
                $post->tags()->sync($tags);
            }

            return $this->response($post);
        }

    }

    /**
     * Update post by id
     * @param int $id (required) The user id.
     * @param string $title (optional) The post title.
     * @param string $content (optional) The post content.
     * @param string $excerpt (optional) The post excerpt.
     * @param string $format (default: 'post') The post format.
     * @param int $image_id (default: 0) The post image id.
     * @param int $media_id (default: 0) The post media id.
     * @param int $status (default: 1) The post image id.
     * @param array $category_ids (optional) The list of categories ids.
     * @param array $tag_ids (optional) The list of tags ids.
     * @param array $tag_names (optional) The list of tags names.
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing post id");
        }

        $post = Post::find($request->id);

        if (!$post) {
            return $this->error("Post #" . $request->id . " is not exists");
        }

        $post->title = $request->get('title', $post->title);
        $post->excerpt = $request->get('excerpt', $post->excerpt);
        $post->content = $request->get('content', $post->content);
        $post->image_id = $request->get('image_id', $post->image_id);
        $post->media_id = $request->get('media_id', $post->media_id);
        $post->status = $request->get("status", $post->status);
        $post->format = $request->get("format", $post->format);

        if ($post->save()) {

            $categories = $request->get("categories", []);
            $post->categories()->sync($categories);

            // Saving tags
            if ($request->has("tag_ids")) {
                $tags = $request->get("tag_ids", []);
                $post->tags()->sync($tags);
            } elseif ($request->has("tag_names")) {
                $tags = Tag::saveNames($request->get("tag_names"));
                $post->tags()->sync($tags);
            }

            return $this->response($post);
        }

    }

    /**
     * Delete post by id
     * @param int $id (required) The post id.
     * @return \Illuminate\Http\JsonResponse
     */
    function destroy(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing post id");
        }

        $post = Post::find($request->id);

        if (!$post) {
            return $this->error("Post #" . $request->id . " is not exists");
        }

        // Destroy requested post
        $post->delete();

        return $this->response($post);

    }


}