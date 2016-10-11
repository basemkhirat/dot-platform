<?php

use Illuminate\Http\Request;


/**
 * Class MediaApiController
 */
class MediaApiController extends Dot\ApiController
{

    /**
     * MediaApiController constructor.
     */
    function __construct(Request $request)
    {
        parent::__construct($request);
        // media are open permission
    }

    /**
     * List media resources
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

        $query = Media::orderBy($sort_by, $sort_direction);

        if ($request->has("q")) {
            $query->search($request->get("q"));
        }

        if ($id) {
            $media = $query->where("id", $id)->first();
        } else {
            $media = $query->paginate($limit)->appends($request->all());
        }

        return $this->response($media);

    }

    /**
     * Create a new media resource
     * @param string $source (required) The media source [data, url, youtube, soundcloud].
     * @param string $title (optional) The media title.
     * @param string $description (optional) The media description.
     * @param string $data (required if source=data) The base64 file content.
     * @param string $url (required if source=url) The external file url.
     * @param string $youtube_url (required if source=youtube) The youtube video url.
     * @param string $soundcloud_url (required if source=soundcloud) The soundcloud video url.
     * @return \Illuminate\Http\JsonResponse
     */
    function create(Request $request)
    {

        $source = $request->get("source");

        if (!$source || !in_array($source, ["data", "url", "youtube", "soundcloud"])) {
            return $this->error("Missing media source. select source within [data, url, youtube, soundcloud]");
        }

        $media = new Media();

        switch ($source) {
            case "data":

                if (!$request->has("data")) {
                    return $this->error("Missing media data");
                }

                $media = $media->saveContent($request->get("data"), NULL, "api");

                break;

            case "url":

                if (!$request->has("url")) {
                    return $this->error("Missing media url");
                }

                $media = $media->saveLink($request->get("url"), "api");

                break;

            case "youtube":

                if (!$request->has("youtube_url")) {
                    return $this->error("Missing youtube_url");
                }

                $media = $media->saveYoutube($request->get("youtube_url"), "api");

                break;

            case "soundcloud":

                if (!$request->has("soundcloud_url")) {
                    return $this->error("Missing soundcloud_url");
                }

                $media = $media->saveSoundcloud($request->get("soundcloud_url"), "api");

                break;

        }

        $media->title = $request->title;
        $media->description = $request->description;
        $media->save();

        return $this->response($media);


    }

    /**
     * Update media resource by id
     * @param int $id (required) The media resource id.
     * @param string $title (optional) The media title.
     * @param string $description (optional) The media description.
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing media resource id");
        }

        $media = Media::find($request->id);

        if (!$media) {
            return $this->error("Media resource #" . $request->id . " is not exists");
        }

        $media->title = $request->get("title", $media->title);
        $media->description = $request->get("description", $media->description);

        if ($media->save()) {
            return $this->response($media);
        }

    }

    /**
     * Delete media resource by id
     * @param int $id (required) The media resource id.
     * @return \Illuminate\Http\JsonResponse
     */
    function destroy(Request $request)
    {

        if (!$request->id) {
            return $this->error("Missing media resource id");
        }

        $media = Media::find($request->id);

        if (!$media) {
            return $this->error("Media resource #" . $request->id . " is not exists");
        }

        // Destroy requested post
        $media->delete();

        return $this->response($media);

    }


}