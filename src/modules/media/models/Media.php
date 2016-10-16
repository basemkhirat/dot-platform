<?php

/**
 * Class Media
 */
class Media extends Dot\Model
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
     * delete file from storage
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

            $resize_mode = config("media.resize_mode", "resize_crop");

            foreach ($sizes as $size => $dimensions) {

                if ($width > $height) {
                    $new_width = $dimensions[0];
                    $new_height = null;
                } else {
                    $new_height = $dimensions[1];
                    $new_width = null;
                }

                if ($resize_mode == "resize") {

                    Image::make($file_directory . "/" . $filename)
                        ->resize($new_width, $new_height, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save($file_directory . "/" . $size . "-" . $filename);

                }

                if ($resize_mode == "resize_crop") {

                    Image::make($file_directory . "/" . $filename)
                        ->fit($dimensions[0], $dimensions[1])
                        ->save($file_directory . "/" . $size . "-" . $filename);

                }

                if ($resize_mode == "color_background") {

                    $background_color = config("media.resize_background_color", "#000000");

                    $background = Image::canvas($dimensions[0], $dimensions[1], $background_color);

                    $image = Image::make($file_directory . "/" . $filename)
                        ->resize($new_width, $new_height, function ($constraint) {
                            $constraint->aspectRatio();
                            //$constraint->upsize();
                        });

                    $background->insert($image, 'center');
                    $background->save($file_directory . "/" . $size . "-" . $filename);
                }

                if ($resize_mode == "gradient_background") {

                    $first_color = config("media.resize_gradient_first_color", "#000000");
                    $second_color = config("media.resize_gradient_second_color", "#ffffff");

                    $background = Image::make($this->gradient($dimensions[0], $dimensions[1], array($first_color, $first_color, $second_color, $second_color)));

                    $image = Image::make($file_directory . "/" . $filename)
                        ->resize($new_width, $new_height, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                    $background->insert($image, 'center');
                    $background->save($file_directory . "/" . $size . "-" . $filename);

                }

                if ($resize_mode == "blur_background") {

                    $background = Image::make($file_directory . "/" . $filename)
                        ->fit($dimensions[0], $dimensions[1])
                        ->blur(100);

                    $image = Image::make($file_directory . "/" . $filename)
                        ->resize($new_width, $new_height, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                    $background->insert($image, 'center');
                    $background->save($file_directory . "/" . $size . "-" . $filename);

                }

                if ($s3_save) {
                    s3_save(date("Y/m/") . $size . "-" . $filename);
                }
            }
        }


    }

    /**
     * create response ajax request
     * @return stdClass
     */
    function response()
    {

        $media = $this;

        /*
        if (is_int($media)) {
            $media = Media::find($media);
        }
*/
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
    function saveYoutube($link = "", $guard = "web")
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
        $media->user_id = Auth::guard($guard)->user()->id;

        $media->save();

        return $media;
    }

    /**
     * grabbing soundcloud links
     * @param string $link
     * @return stdClass
     */
    function saveSoundcloud($link = "", $guard = "web")
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
        $media->user_id = Auth::guard($guard)->user()->id;

        $media->save();

        return $media;

    }


    /**
     * grabbing files using http request
     * @param $link
     * @param string $guard
     * @return Media
     */
    function saveLink($link, $guard = "web")
    {

        if ($content = @file_get_contents($link)) {
            return $this->saveData($content, NULL, $guard);
        }

    }

    /**
     * Saving base64 data filesystem
     * @param $content
     * @param null $extension
     * @param string $guard
     * @return Media
     */
    function saveContent($content, $extension = NULL, $guard = "web")
    {
        $content = base64_decode($content);
        return $this->saveData($content, $extension, $guard);
    }

    /**
     * check if file encoded with base64
     * @param $data
     * @return bool
     */
    function isBase64($data)
    {

        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     * @param $data
     * @param null $extension
     * @param string $guard
     * @return Media
     */
    function saveData($data, $extension = NULL, $guard = "web")
    {

        $path = storage_path("temp/" . str_random(20));

        File::put($path, $data);
        $file_hash = sha1_file($path);

        $media = Media::where("hash", $file_hash)->first();

        if (count($media)) {

            $media->touch();

        } else {

            $mime = strtolower(mime_content_type($path));

            if (!$extension) {
                $extension = get_extension($mime);
            }

            if (!$extension) {
                $row = new stdClass();
                $row->error = "Invalid link file type";
                return Response::json($row, 200);
            }

            $mime_parts = explode("/", $mime);
            $type = $mime_parts[0];

            $filename = time() * rand() . "." . strtolower($extension);

            File::makeDirectory(UPLOADS_PATH . "/" . date("Y/m"), 0777, true, true);

            if (@copy($path, UPLOADS_PATH . date("/Y/m/") . $filename)) {

                s3_save(date("Y/m/") . $filename);

                $media = new Media();

                $media->type = $type;
                $media->path = date("Y/m/") . $filename;
                $media->user_id = isset(Auth::guard($guard)->user()->id) ? Auth::guard($guard)->user()->id : 0;
                $media->created_at = date("Y-m-d H:i:s");
                $media->updated_at = date("Y-m-d H:i:s");
                $media->hash = $file_hash;

                if ($media->isImage($extension)) {
                    $media->set_sizes($filename);
                }

                $media->save();

            }

            //delete the temporary file
            @unlink($path);

        }

        return $media;

    }

    /**
     * Generates a gradient image
     * @param int $w
     * @param int $h
     * @param array $c
     * @param bool $hex
     * @return resource
     */
    function gradient($w = 100, $h = 100, $c = array('#FFFFFF', '#FF0000', '#00FF00', '#0000FF'), $hex = true)
    {

        $im = imagecreatetruecolor($w, $h);

        if ($hex) {  // convert hex-values to rgb
            for ($i = 0; $i <= 3; $i++) {
                $c[$i] = $this->hex2rgb($c[$i]);
            }
        }

        $rgb = $c[0]; // start with top left color
        for ($x = 0; $x <= $w; $x++) { // loop columns
            for ($y = 0; $y <= $h; $y++) { // loop rows
                // set pixel color
                $col = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
                imagesetpixel($im, $x - 1, $y - 1, $col);
                // calculate new color
                for ($i = 0; $i <= 2; $i++) {
                    $rgb[$i] =
                        $c[0][$i] * (($w - $x) * ($h - $y) / ($w * $h)) +
                        $c[1][$i] * ($x * ($h - $y) / ($w * $h)) +
                        $c[2][$i] * (($w - $x) * $y / ($w * $h)) +
                        $c[3][$i] * ($x * $y / ($w * $h));
                }
            }
        }
        return $im;
    }

    /**
     * @param $hex
     * @return mixed
     */
    function hex2rgb($hex)
    {
        $rgb[0] = hexdec(substr($hex, 1, 2));
        $rgb[1] = hexdec(substr($hex, 3, 2));
        $rgb[2] = hexdec(substr($hex, 5, 2));
        return ($rgb);
    }


}
