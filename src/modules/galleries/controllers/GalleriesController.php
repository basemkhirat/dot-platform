<?php

class GalleriesController extends Dot\Controller
{

    public $data = array();

    function __construct()
    {
        parent::__construct();
        $this->middleware("permission:galleries.manage");
    }

    public function index($id = false)
    {

        if (Request::isMethod("post")) {
            if (Request::has("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $ob = Gallery::with("files")->orderBy("id", "DESC");

        if (Request::has("q")) {
            $ob->where('name', 'LIKE', '%' . Request::get("q") . '%');
        }

        if (Request::has("per_page")) {
            $this->data["per_page"] = $per_page = Request::get("per_page");
        } else {
            $this->data["per_page"] = $per_page = 20;
        }

        $this->data["galleries"] = $galleries = $ob->paginate($per_page);

        return View::make("galleries::show", $this->data);
    }

    public function create()
    {

        if (Request::isMethod("post")) {

            $gallery = new gallery();

            $gallery->name = Request::get("name");
            $gallery->author = Request::get("author");
            $gallery->user_id = Auth::user()->id;
            $gallery->lang = app()->getLocale();

            // fire gallery saving action
            Action::fire("gallery.saving", $gallery);

            if (!$gallery->validate()) {
                return Redirect::back()->withErrors($gallery->errors());
            }

            $gallery->save();

            $gallery->files()->sync((array)Request::get("media_id"));

            // fire gallery saved action
            Action::fire("gallery.saved", $gallery);

            return Redirect::route("admin.galleries.edit", array("id" => $gallery->id))->with("message", trans("galleries::galleries.events.created"));
        }


        $this->data["gallery"] = false;
        return View::make("galleries::edit", $this->data);
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        if (Request::isMethod("post")) {

            $gallery->name = Request::get("name");
            $gallery->author = Request::get("author");
            $gallery->lang = app()->getLocale();

            // fire gallery saving action
            Action::fire("gallery.saving", $gallery);

            if (!$gallery->validate()) {
                return Redirect::back()->withErrors($gallery->errors());
            }

            $gallery->save();

            $gallery->files()->sync((array)Request::get("media_id"));

            // fire gallery saved action
            Action::fire("gallery.saved", $gallery);

            return Redirect::route("admin.galleries.edit", array("id" => $gallery->id))->with("message", trans("galleries::galleries.events.updated"));

        }

        $this->data["gallery"] = $gallery;
        $this->data["gallery_media"] = $gallery->files;

        return View::make("galleries::edit", $this->data);
    }

    function content()
    {
        if (Request::isMethod("post")) {

            $id = Request::get("id");
            $files = GalleryMedia::where("id", $id)
                ->join("media", "media.id", "=", "galleries_media.media_id")
                ->get();
            ?>

            <table cellpading="0" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <div
                            style="overflow: hidden; background: #3e3e3e; margin: 10px 0; padding: 10px; border-radius: 4px">
                            <?php foreach ($files as $media) { ?>
                                <div class="media_row"
                                     style="border-radius: 2px; margin: 4px 5px; width: 145px; border: 1px solid rgb(139, 139, 139); box-shadow: 0px 1px 1px rgb(142, 142, 142); float: right; height: 127px; position: relative; padding: 3px;margin-bottom: 30px;">
                                    <?php if ($media->media_provider == "") { ?>
                                        <img style="width:100%; height:100%"
                                             src="<?php echo thumbnail($media->media_path); ?>">
                                    <?php } else { ?>
                                        <?php if ($media->media_provider_image != "") { ?>
                                            <img style="width:100%; height:100%"
                                                 src="<?php echo $media->media_provider_image; ?>"/>
                                        <?php } else { ?>
                                            <img style="width:100%; height:100%"
                                                 src="<?php echo assets("default/soundcloud.png"); ?>"/>
                                        <?php } ?>
                                    <?php } ?>
                                    <span
                                        style="font-family: tahoma; background: none repeat scroll 0 0 #555555;  color: #ccc;  float: left;  height: 37px;  margin-top: -43px;  opacity: 0.81;  overflow: hidden;  width: 100%;  word-wrap: break-word;"><?php echo Str::limit($media->title, 30); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php
        }
    }

    function get($page = 1)
    {

        $limit = 20;

        $ob = Gallery::orderBy("id", "DESC");

        if (Request::has("q")) {
            $ob->where('name', 'LIKE', '%' . Request::get("q") . '%');
        }

        if (Request::has("id")) {
            $ob->where('galleries.id', Request::get("id"));
        }

        $ob->take($limit);
        $ob->skip(($page - 1) * $limit);
        $galleries = $ob->get();

        if (count($galleries)) {
            ?>
            <?php foreach ($galleries as $gallery) { ?>
                <div class="col-md-12 gallery_row" gallery-type="<?php echo $gallery->type; ?>"
                     gallery-id="<?php echo $gallery->id; ?>">
                    <div class="gallery_details">
                        <div class="gallery_details_name"><?php echo $gallery->name; ?></div>
                        <div style="display: none" class="gallery_details_author"><?php echo $gallery->author; ?></div>
                        <div class="gallery_details_count">
                            (<span><?php echo $gallery->media_count; ?></span>) <?php echo trans("media::media.files"); ?>
                        </div>
                    </div>
                    <div class="gallery_ctrls">
                        <a href="javascript:void(0)" class="gallery_edit text-primary"
                           data-gallery="<?php echo $gallery->id; ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="gallery_delete text-danger"
                           data-gallery="<?php echo $gallery->id; ?>">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php
    }

    function files()
    {
        if (Request::isMethod("post")) {

            $id = Request::get("id");
            $gallery_media = GalleryMedia::where("gallery_id", $id)
                ->join("media", "media.id", "=", "galleries_media.media_id")
                ->get();
            ?>
            <ul class="media_rows">

                <?php foreach ($gallery_media as $media) { ?>
                    <li class="media_row">
                        <input type="hidden" name="media_id[]" value="<?php echo $media->media_id; ?>"/>

                        <a href="#" class="media_row_delete" data-message="<?php echo trans("galleries::galleries.media_row_delete"); ?>">
                            <i class="fa fa-times"></i>
                        </a>

                        <div>
                            <i class="fa fa-arrows"></i>
                        </div>

                        <?php if ($media->provider == "") { ?>
                            <img src="<?php echo thumbnail($media->path, "thumbnail"); ?>">
                        <?php } else { ?>
                            <?php if ($media->provider_image != "") { ?>
                                <img src="<?php echo $media->provider_image; ?>"/>
                            <?php } else { ?>
                                <img src="<?php echo assets("default/soundcloud.png"); ?>"/>
                            <?php } ?>
                        <?php } ?>

                        <label>
                            <input type="text" name="media_title[<?php echo $media->media_id; ?>]"
                                   value="<?php echo $media->title; ?>"/>
                        </label>
                    </li>
                <?php } ?>
            </ul>

            <div class="no-media text-center empty-content <?php if (count($gallery_media)) { ?> hidden <?php } ?>">
                <i class="fa fa-file"></i>
            </div>

            <?php
        }
    }

    function save()
    {

        $id = Request::get("gallery_id");
        DB::table("galleries_media")->where("gallery_id", $id)->delete();

        // update media files titles
        if (Request::get("media_title") == null) {
            return "";
        }

        $titles = Request::get("media_title");

        foreach ($titles as $media_id => $media_title) {
            Media::where("id", $media_id)->update(array(
                "title" => $media_title
            ));
        }

        if ($ids = Request::get("media_id")) {
            foreach ($ids as $media_id) {
                GalleryMedia::insert(array(
                    "gallery_id" => $id,
                    "media_id" => $media_id
                ));
            }
        }
    }

    public function delete() {

        $ids = Request::get("id");

        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $ID) {
            $gallery = Gallery::findOrFail($ID);

            // fire gallery deleting action
            Action::fire("gallery.deleting", $gallery);

            $gallery->files()->detach();
            $gallery->delete();

            // fire gallery deleted action
            Action::fire("gallery.deleted", $gallery);
        }
        return Redirect::back()->with("message", trans("galleries::galleries.events.deleted"));
    }


}
