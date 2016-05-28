<?php

/**
 * Class Media
 */
class Media extends Model
{

    /**
     * @var string
     */
    protected $table = 'media';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $searchable = ["title", "description"];

    /**
     * Validating file before upload
     * @param $file
     * @return mixed
     */
    public function validateFile($file)
    {

        $allowed_types = Config("media.allowed_file_types");

        if (is_array($allowed_types)) {
            $allowed_types = join(",", Config("media.allowed_file_types"));
        }

        $rules = array(
            'files.0' => "mimes:" . $allowed_types . "|max:" . Config("media.max_file_size"),
        );

        $validator = Validator::make(Request::all(), $rules);

        $validator->setAttributeNames(array(
            'files.0' => "file"
        ));

        return $validator;
    }

    /**
     * Upoading file and save it
     * @param $file
     * @return mixed
     */
    public function saveFile($file)
    {

        $media = Media::where("hash", sha1_file($file->getRealPath()))->first();

        if (count($media)) {
            $media->touch();
            return $media->id;
        }

        // uploading

        $size = $file->getSize();
        $parts = explode(".", $file->getClientOriginalName());
        $extension = end($parts);
        $filename = time() * rand() . "." . strtolower($extension);
        $mime_parts = explode("/", $file->getMimeType());
        $mime_type = $mime_parts[0];

        $file_directory = UPLOADS_PATH . date("/Y/m");

        File::makeDirectory($file_directory, 0777, true, true);

        try {

            $this->checkImageDimensions($filename);
            $file->move($file_directory, $filename);
            s3_save(date("Y/m/") . $filename);

        } catch (Exception $exception) {
            $error = array(
                'name' => $file->getClientOriginalName(),
                'size' => $size,
                'error' => $exception->getMessage(),
            );
            return \Response::json($error, 400);
        }

        if ($this->isImage($extension)) {
            $this->set_sizes($filename);
        }

        $media = new Media();

        $media->provider = "";
        $media->path = date("Y/m") . "/" . $filename;
        $media->type = $mime_type;
        $media->title = basename(strtolower($file->getClientOriginalName()), "." . $extension);
        $media->user_id = Auth::user()->id;
        $media->created_at = date("Y-m-d H:i:s");
        $media->updated_at = date("Y-m-d H:i:s");
        $media->hash = sha1_file($file_directory . "/" . $filename);

        $media->save();

        if (Config::get("media.s3.status")) {
            $this->deleteHard($filename);
        }

        return $media->id;

    }

    /**
     * check if an image
     * @param $extension
     * @return bool
     */
    function isImage($extension)
    {

        if (in_array(strtolower($extension), array("jpg", "jpeg", "gif", "png", "bmp"))) {
            return true;
        }

        return false;

    }


    /**
     * delete file from local disk
     * @param $filename
     */
    function deleteHard($filename)
    {

        $file_directory = UPLOADS_PATH . date("/Y/m");

        if (File::exists($file_directory . "/" . $filename)) {

            unlink($file_directory . "/" . $filename);

            $parts = explode(".", $filename);
            $extension = end($parts);

            if ($this->isImage($extension)) {
                $sizes = Config::get("media.sizes");
                foreach ($sizes as $size => $dimensions) {

                    if (File::exists($file_directory . "/" . $size . "-" . $filename)) {
                        @unlink(uploads_path($file_directory . "/" . $size . "-" . $filename));
                    }
                }
            }
        }
    }

    /**
     * reize if image exceeds max width
     * @param $filename
     * @return bool
     */
    function checkImageDimensions($filename)
    {

        $parts = explode(".", $filename);
        $extension = end($parts);

        if (!$this->isImage($extension)) {
            return false;
        }

        $file_directory = UPLOADS_PATH . date("/Y/m");

        if (file_exists($file_directory . "/" . $filename)) {

            $image_width = Image::make($file_directory . "/" . $filename)->width();

            if ($image_width > Config::get("media.max_width")) {
                Image::make($file_directory . "/" . $filename)
                    ->resize(Config::get("media.max_width"), null, function ($constraint) {
                        $constraint->aspectRatio();
                        //$constraint->upsize();
                    })
                    ->save($file_directory . "/" . $filename);
            }
        }
    }


    /**
     * create thumbnails
     * @param $filename
     * @param int $s3_save
     * @return bool
     */
    function set_sizes($filename, $s3_save = 1)
    {

        if (!Config::get("media.thumbnails")) {
            return false;
        }

        $file_directory = UPLOADS_PATH . date("/Y/m");

        if (file_exists($file_directory . "/" . $filename)) {

            $sizes = Config::get("media.sizes");

            $width = Image::make($file_directory . "/" . $filename)->width();
            $height = Image::make($file_directory . "/" . $filename)->height();

            foreach ($sizes as $size => $dimensions) {

                Image::make($file_directory . "/" . $filename)
                    ->fit($dimensions[0], $dimensions[1], function ($constraint) {
                        $constraint->upsize();
                    })
                    ->save($file_directory . "/" . $size . "-" . $filename);

                if ($s3_save) {
                    s3_save(date("Y/m/") . $size . "-" . $filename);
                }
            }
        }


    }

    /**
     * create response ajax request
     * @param $media
     * @return stdClass
     */
    function response($media)
    {

        if (is_int($media)) {
            $media = Media::find($media);
        }

        $row = new stdClass();

        $row->error = false;

        $row->id = $media->id;
        $row->path = $media->path;
        $row->type = $media->type;
        $row->title = $media->title;
        $row->description = $media->description;
        $row->created_at = $media->created_at;
        $row->updated_at = $media->updated_at;
        $row->user_id = $media->user_id;
        $row->provider = $media->provider;
        $row->provider_id = $media->provider_id;
        $row->provider_image = $media->provider_image;
        $row->name = $media->title;
        $row->duration = $media->length;

        if ($media->provider == NULL) {
            $row->thumbnail = thumbnail($media->path);
            $row->url = uploads_url($media->path);
        } else {
            $row->thumbnail = $media->provider_image;
            $row->url = $media->path;
        }

        $row->html = View::make("media::index", array(
            "files" => array(0 => (object)array(
                "id" => $media->id,
                "provider" => $media->provider,
                "provider_id" => $media->provider_id,
                "url" => $row->url,
                "thumbnail" => $row->thumbnail,
                "path" => $media->path,
                "duration" => format_duration($media->length),
                "type" => $media->type,
                "title" => $media->title,
                "description" => $media->description,
                "created_at" => $media->created_at,
                "updated_at" => $media->updated_at,
                "user_id" => Auth::user()->id
            ))
        ))->render();

        return $row;

    }

    /**
     * grabbing youtube links
     * @param string $link
     * @return stdClass
     */
    function saveYoutubeLink($link = "")
    {
        $id = get_youtube_video_id($link);
        $details = get_youtube_video_details($id);

        $media = new Media();

        $media->provider = "youtube";
        $media->provider_id = $id;
        $media->provider_image = $details->image;
        $media->type = "video";
        $media->path = $details->embed;
        $media->title = $details->title;
        $media->description = $details->description;
        $media->length = $details->length;
        $media->created_at = date("Y-m-d H:i:s");
        $media->updated_at = date("Y-m-d H:i:s");
        $media->user_id = Auth::user()->id;

        $media->save();

        return $this->response($media->id);
    }

    /**
     * grabbing soundcloud links
     * @param string $link
     * @return stdClass
     */
    function saveSoundcloudLink($link = "")
    {

        $details = get_soundcloud_track_details($link);

        $media = new Media();
        $media->provider = "soundcloud";
        $media->provider_id = $details->id;
        $media->provider_image = $details->image;
        $media->type = "audio";
        $media->path = $details->link;
        $media->title = $details->title;
        $media->description = $details->description;
        $media->length = $details->length;
        $media->created_at = date("Y-m-d H:i:s");
        $media->updated_at = date("Y-m-d H:i:s");
        $media->user_id = Auth::user()->id;

        $media->save();

        return $this->response($media->id);

    }

    /**
     * grabbing files using http request
     * @param $link
     * @return stdClass
     */
    function saveFileLink($link)
    {

        $name = md5($link);

        if (copy($link, storage_path("temp/" . $name))) {

            $file_hash = sha1_file(storage_path("temp/" . $name));

            $media = Media::where("hash", $file_hash)->first();

            if (count($media)) {

                $media->touch();

            } else {

                $mime = strtolower(mime_content_type(storage_path("temp/" . $name)));

                $extension = get_extension($mime);

                if (!$extension) {
                    $row = new stdClass();
                    $row->error = "Invalid link file type";
                    return Response::json($row, 200);
                }

                $mime_parts = explode("/", $mime);
                $type = $mime_parts[0];

                $remote_file_parts = explode("/", ($link));

                $title = $remote_file_name = urldecode(basename(end($remote_file_parts), "." . $extension));

                $filename = time() * rand() . "." . strtolower($extension);

                File::makeDirectory(UPLOADS_PATH . "/" . date("Y/m"), 0777, true, true);

                if (copy(storage_path("temp/" . $name), UPLOADS_PATH . date("/Y/m/") . $filename)) {

                    s3_save(date("Y/m/") . $filename);

                    $media = new Media();

                    $media->title = $title;
                    $media->type = $type;
                    $media->path = date("Y/m/") . $filename;
                    $media->user_id = Auth::user()->id;
                    $media->created_at = date("Y-m-d H:i:s");
                    $media->updated_at = date("Y-m-d H:i:s");
                    $media->hash = $file_hash;

                    if ($media->isImage($extension)) {
                        $media->set_sizes($filename);
                    }

                    $media->save();

                }

            }

            return $this->response($media->id);

        }


    }


}
