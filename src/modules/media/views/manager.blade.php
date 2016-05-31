<div class="cinema"></div>

<link rel="stylesheet" href="<?php echo assets("uploader/cropper.css") ?>" type="text/css"/>
<script src="<?php echo assets("uploader/cropper.js") ?>"></script>

<div class="file_manager">

    <div class="file_manager_header">


        <div class="media_loader sk-spinner sk-spinner-double-bounce">
            <div class="sk-double-bounce1"></div>
            <div class="sk-double-bounce2"></div>
        </div>

        <ul class="file_manager_tabs nav nav-tabs ">


            <li class="upload-area-list">
                <a data-toggle="tab" href="#upload-area">
                    <i class="fa fa-cloud-upload"></i>
                    <strong class="hidden-xs"><?php echo trans("media::media.upload_files"); ?></strong>
                </a>
            </li>
            <li class="active">
                <a data-toggle="tab" href="#library-area">
                    <i class="fa fa-cloud"></i>
                    <strong class="hidden-xs"><?php echo trans("media::media.media"); ?></strong>
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#galleries-area">
                    <i class="fa fa-camera"></i>

                    <strong class="hidden-xs"><?php echo trans("media::media.galleries"); ?></strong></a>
            </li>
            <!--<li>
                <a data-toggle="tab" href="#embed-settings">
                    <i class="fa fa-cog"></i>
                    <span class="hidden-xs"><?php echo trans("media::media.settings"); ?></span></a>
            </li>-->
            <?php /*
              <li class="search-area-list" class="hidden-xs">
              <form class="search_media" >
              <div class="input-group">
              <input class="form-control" placeholder="<?php echo  trans("media::media.search_media"); ?>" value="" id="file_query" name="q">
              <span class="input-group-btn">
              <button type="submit" class="btn">
              <i class="fa fa-search"></i>
              </button>
              </span>
              </div>
             *
             *
             *
              </form>
              </li>
             *
             */ ?>
        </ul>

            <span class="file_manager_close">
        <i class="fa fa-times"></i>
    </span>

    </div>
    <link rel="stylesheet" href="<?php echo assets() ?>/uploader/jquery.fileupload.css"/>

    <div class="file_manager_content">
        <div class="tab-content" style="padding:0">
            <div id="upload-area" class="tab-pane fade">

                <div class="container">

                    <div class="upload_errors"></div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="dropzone-box dz-clickable span6" id="dropzonejs-example" style="height:430px">
                                <div class="dz-default dz-message" style="padding-top: 0px;">
                                    <i class="fa fa-cloud-upload hidden-xs"></i>
                                    <?php echo trans("media::media.drop_files_here"); ?><span class="dz-text-small">
                                        <span class="btn btn-primary btn-flat fileinput-button"
                                              style="position: relative; top: 7px;">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span><?php echo trans("media::media.select_files"); ?></span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files[]" multiple>
                                        </span>
                                    </span>
                                </div>
                            </div>


                            <!-- The global progress bar -->
                            <div id="progress" class="progress progress-striped" style="background: none repeat scroll 0 0 #ccc;margin-top: -13px;opacity: 1;position: relative;z-index: 9999; border-radius:0">
                                <div class="progress-bar progress-bar-primary text-center"> <div class="loaded" data-message="<?php echo trans("media::media.processing"); ?>"></div> </div>
                            </div>

                            <?php /* ?>
                              <!-- The container for the uploaded files -->
                              <div class="row">
                              <div class="col-md-11 current-uploading-file"></div>
                              <div class="col-md-1 text-right current-uploading-rate"></div>
                              </div>
                              <?php */ ?>

                        </div>

                        <div class="col-md-6">

                            <div class="panel panel-default" style="height:430px">
                                <div class="panel-heading">


                                    <span class="panel-title">
                                        <i class="fa fa-link"></i> &nbsp;&nbsp;&nbsp;
                                        <?php echo trans("media::media.add_external_link"); ?>
                                    </span>


                                </div> <!-- / .panel-heading -->

                                <form id="mediaform" method="post">
                                    <div class="list-group" style="margin-top: 93px; padding: 10px;">

                                        <div class="input-group input-group-md col-lg-10 col-md-10 col-sm-10 col-xs-10 pull-left">
                                            <span class="input-group-addon">
                                                <i class="fa fa-link"></i>
                                            </span>
                                            <input style="text-align:left; direction: ltr" name="link" value=""
                                                   class="form-control"
                                                   placeholder="https://"/>
                                        </div>

                                        <button data-required-text="<?php echo trans("media::media.required_link"); ?>" data-fail-text="<?php echo trans("media::media.invalid_link"); ?>" type="submit" data-loading-text="<?php echo trans("media::media.grabbing"); ?>" class="btn btn-primary btn-flat btn-download col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>


                                        <blockquote style="margin-top:50px">
                                            <strong><?php echo trans("media::media.supported_links") ?>: </strong>
                                            <small><i class="fa fa-link" aria-hidden="true"></i> <?php echo trans("media::media.external_links") ?></small>
                                            <small><i class="fa fa-youtube-play" aria-hidden="true"></i> <?php echo trans("media::media.youtube") ?></small>
                                            <small><i class="fa fa-soundcloud" aria-hidden="true"></i> <?php echo trans("media::media.soundcloud") ?></small>
                                        </blockquote>

                                    </div>


                                </form>

                            </div>

                        </div>
                    </div>


                </div>
            </div> <!-- / .tab-pane -->
            <div id="library-area" class="tab-pane fade active in">

                <div id="media-editor">

                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <!-- This is the image we're attaching Jcrop to -->
                        <div class="media-editor-image">
                            <img src="" data-src="" class="cropper" alt="Picture"/>
                        </div>
                    </div>

                    <span class="panel-arrow-wrapper">
                        <div class="col-md-3 col-sm-3 hidden-xs media-setting-panel">

                            <?php /*
                              <div style="width:100px;height:100px;overflow:hidden;margin-left:5px;">
                              <img id="preview">

                              </div>
                             *
                             */ ?>


                            <?php /*
                              <!-- This is the form that our event handler fills -->
                              <select id="editor-media-size">
                              <option data-width="0" data-height="0" value="full">الصورة الأصلية</option>
                              <?php foreach (Config::get("media.sizes") as $size => $dim) { ?>
                              <option data-width="<?php echo $dim[0] ?>" data-height="<?php echo $dim[1] ?>" value="<?php echo $size ?>"><?php echo ucfirst($size) ?> <?php echo $dim[0] ?>X<?php echo $dim[1] ?></option>
                              <?php } ?>
                              </select>
                             *
                             */ ?>


                            <button class="btn btn-large btn-danger btn-inverse pull-right" id="revert_editing">

                                <?php echo trans("media::media.back"); ?>
                                <i class="fa fa-chevron-left"></i>

                            </button>

                            <br/><br/>
                            <?php if (User::access("media.cropping")) { ?>
                                <div class="cropped_images">
                                    <?php /*
                                      <div class="size-row" data-size="full">


                                      الصورة الأصلية

                                      </div>
                                     */ ?>

                                    <?php foreach (Config::get("media.sizes") as $size => $dim) { ?>
                                        <div class="size-row" data-width="<?php echo $dim[0] ?>"
                                             data-height="<?php echo $dim[1] ?>" data-size="<?php echo $size ?>">

                                            <img class="cropped_image" src="" width="<?php echo $dim[0] / 4 ?>"
                                                 data-width="<?php echo $dim[0] ?>" data-height="<?php echo $dim[1] ?>"
                                                 data-size="<?php echo $size ?>"/>
                                            <span class="pull-right">
                                                <?php echo ucfirst($size) ?> <?php echo $dim[0] ?>X<?php echo $dim[1] ?>
                                                <br/>
                                            </span>
                                        </div>
                                    <?php } ?>
                                </div>


                                <form method="post" class="crop_form form-horizontal">

                                    <fieldset>
                                        <legend><?php echo trans("media::media.crop_settings"); ?></legend>
                                        <p>
                                            <?php echo trans("media::media.crop_settings_help"); ?>

                                        </p>
                                        <button type="submit" id="cropbtn"
                                                data-loading-text="<?php echo trans("media::media.please_wait"); ?>"
                                                class="btn btn-large btn-primary btn-inverse">
                                            <i class="fa fa-crop"></i>
                                            <?php echo trans("media::media.crop_image"); ?>
                                        </button>

                                        <div style="display:none">
                                            <div class="row">
                                                <label>البعد الأفقى</label>
                                                <input type="text" id="x" name="x" class="form-control input-md"/>
                                            </div> <!-- / .form-group -->

                                            <div class="row">
                                                <label>البعد الرأسى</label>
                                                <input type="text" id="y" name="y" class="form-control input-md"/>
                                            </div> <!-- / .form-group -->

                                            <div class="row">
                                                <label>عرض الصورة</label>
                                                <input type="text" id="w" name="w" class="form-control input-md"/>
                                            </div> <!-- / .form-group -->

                                            <div class="row">
                                                <label>طول الصورة</label>
                                                <input type="text" id="h" name="h" class="form-control input-md"/>
                                            </div> <!-- / .form-group -->
                                            <?php /*
                                              <div class="row watermark-check">

                                              <input type="checkbox" name="watermark" value="1" class="switcher watermark-switch switcher-sm" /> وضع العلامة المائية

                                              </div>
                                             *
                                             */ ?>
                                        </div>
                                    </fieldset>
                                </form>
                            <?php } ?>

                            <?php if (User::access("media.watermarking")) { ?>
                                <fieldset>
                                    <legend><?php echo trans("media::media.watermark_settings"); ?></legend>

                                    <p>
                                        <?php echo trans("media::media.watermark_settings_help"); ?>
                                    </p>
                                    <select id="watermark-position" style="display:none">
                                        <option value="top-left">مكان العلامة المائية</option>
                                        <option value="top-left">أعلى شمال</option>
                                        <option value="top">أعلى</option>
                                        <option value="top-right">أعلى يمين</option>
                                        <option value="left">شمال</option>
                                        <option value="center">توسيط</option>
                                        <option value="right">يمين</option>
                                        <option value="bottom-left">أسفل شمال</option>
                                        <option value="bottom">أسفل</option>
                                        <option value="bottom-right">أسفل يمين</option>
                                    </select>

                                    <button type="submit" id="waterbtn"
                                            data-loading-text="<?php echo trans("media::media.please_wait"); ?>"
                                            class="btn btn-large btn-primary watermark_editor btn-inverse">
                                        <i class="fa fa-file-image-o"></i>
                                        <?php echo trans("media::media.set_watermark"); ?>
                                    </button>

                                </fieldset>
                            <?php } ?>
                        </div>
                    </span>
                </div>

                <div class="files-area">
                    <div class="filter-bar" style="margin:0; padding: 0">
                        <a href="#" media-type="all" class="active"><i class="fa fa-home"></i></a>
                        <a href="#" media-type="image"><i class="fa fa-picture-o"></i></a>
                        <a href="#" media-type="audio"><i class="fa fa-music"></i></a>
                        <a href="#" media-type="video"><i class="fa fa-film"></i></a>
                        <a href="#" media-type="pdf"><i class="fa fa-file-text"></i></a>
                    </div>
                    <div class="media-wrapper" style="margin:0; padding: 0">
                        <div class="search_bar">
                            <form class="search_media pull-left col-lg-4 col-md-4 col-sm-4 col-xs-6" data-required-text="<?php echo trans("media::media.keyword_required"); ?>" data-empty-text="<?php echo trans("media::media.empty_media"); ?>">
                                <input type="hidden" name="type" value="all"/>
                                <div class="input-group">
                                    <input class="form-control"
                                           placeholder="<?php echo trans("media::media.search_media"); ?>"
                                           value="" id="file_query" name="q">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                </div>
                                <div class="col-md-2" style="display: none;">
                                    <input type="checkbox" name="motive" value="1"
                                           class="switcher search-switcher switcher-sm" style="float:left">
                                </div>
                            </form>

                            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"></div>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pull-right text-right">

                                <button class="btn btn-icon btn-danger btn-flat disabled"
                                        data-loading-text="<?php echo trans("media::media.deleting"); ?>" type="button"
                                        id="delete_selected_media" data-message="<?php echo trans("media::media.confirm_delete_files"); ?>">
                                    <i class="fa fa-trash"></i>
                                        <span class="hidden-xs">
                                    <?php echo trans("media::media.delete"); ?>
                                            </span>
                                </button>

                                <button class="btn btn-icon btn-primary btn-flat disabled"
                                        data-loading-text="<?php echo trans("media::media.please_wait"); ?>"
                                        type="button"
                                        id="select_media"><i class="fa fa-check-square-o"></i>

                                    <span class="hidden-xs">
                                         <?php echo trans("media::media.select_media"); ?>
                                    </span>


                                </button>

                            </div>
                        </div>


                        <div class="media-grid-wrapper">

                            <input type="hidden" class="media-grid-page" value="1"/>
                            <input type="hidden" class="media-grid-type" value="all"/>

                            <div class="media-grid pull-left col-lg-10 col-md-9 col-sm-9 col-xs-12 text-center"></div>
                            <div class="media-form-wrapper pull-right col-lg-2 col-md-3 col-sm-3 hidden-xs">
                                <br/>
                                <!-- Extra small tabs -->

                                <div class="row details-box">

                                    <div class="col-lg-4 col-md-4 hidden-sm hidden-xs  details-box-image">
                                        <img class="img-rounded" src=""/>
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 details-box-name">
                                        <div class="file_name" style="word-wrap: break-word;"></div>
                                        <div class="file_date"></div>
                                        <div class="file_size"></div>
                                        <div class="file_duration"></div>
                                        <br/>
                                    </div>
                                </div>

                                <br/>
                                <div class="btn-group btn-group-justified">

                                    <a class="btn btn-primary btn-flat" href="javascript:void(0)" target="_blank"
                                       id="download_media">
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                    <?php /* if (User::access("media.watermarking") or User::access("media.cropping")) { ?>
                                        <a class="btn btn-success btn-flat" href="javascript:void(0)"
                                           data-loading-text="<?php echo trans("media::media.please_wait") ?>"
                                           target="_blank"
                                           id="set_media"><?php echo trans("media::media.settings") ?></a>
                                    <?php } */ ?>
                                    <a class="btn btn-danger btn-flat" href="javascript:void(0)"
                                       data-loading-text="<?php echo trans("media::media.deleting") ?>"
                                       data-message="<?php echo trans("media::media.confirm_delete_file"); ?>"
                                       id="delete_media">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>

                                <form action="" method="post" class="media-form">

                                    <input type="hidden" name="file_id"/>
                                    <input type="hidden" id="file_provider"/>
                                    <input type="hidden" id="file_provider_id"/>
                                    <input type="hidden" id="file_type"/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input readonly=""
                                                       style="text-align:left; direction: ltr; font-family: tahoma"
                                                       name="url" name="file_url" id="file_url" value=""
                                                       class="form-control" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (User::access("media.manage_captions")) { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input name="file_title" id="file_title" value=""
                                                           class="form-control input-md" value=""
                                                           placeholder="<?php echo trans("media::media.title"); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea style="height:100px" name="file_description"
                                                              id="file_description" class="form-control input-md"
                                                              value=""
                                                              placeholder="<?php echo trans("media::media.description"); ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit"
                                                   data-loading-text="<?php echo trans("media::media.loading"); ?>"
                                                   id="save_media" class="pull-right btn btn-flat btn-primary"
                                                   ><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo trans("media::media.save"); ?></button>
                                        </div>
                                    <?php } ?>

                                </form><!-- media-form -->
                            </div><!-- media-form-wrapper -->
                        </div> <!-- media-grid-wrapper -->


                    </div>
                </div>
            </div>

            <div id="galleries-area" class="tab-pane fade gallery_rows row" style="margin: 0;">
                <?php $galleries_count = Gallery::count(); ?>
                <div class="no-galleries text-center <?php if ($galleries_count) { ?>hidden<?php } ?>">
                    <p>
                        <?php echo trans("media::media.no_galleries_added"); ?>
                    </p>
                    <button class="btn btn-w-m btn-primary" type="button" data-toggle="modal"
                            data-target="#createGalleryModal">
                        <i class="fa fa-camera"></i>
                        <?php echo trans("media::media.add_new_gallery"); ?>
                    </button>
                </div>

                <div class="row galleries-panel <?php if (!$galleries_count) { ?>hidden<?php } ?>">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">

                        <form class="search_galleries row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-9">

                                <div class="input-group gallery_search_box">
                                    <a href="#" class="galleries-home btn btn-primary">
                                        <i class="fa fa-home"></i>
                                    </a>
                                    <a data-toggle="modal" data-target="#createGalleryModal" href="javascript:void(0)"
                                       class="galleries-create btn btn-danger">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <input name="q" id="gallery_query" value=""
                                           placeholder="<?php echo trans("media::media.search_galleries"); ?>"
                                           class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>

                            </div>

                            <div class="hidden-lg hidden-md hidden-sm col-xs-3 text-left">
                                <button class="btn btn-icon btn-primary btn-flat"
                                        data-loading-text="<?php echo trans("media::media.please_wait"); ?>"
                                        type="button"
                                        id="select_gallery"><i class="fa fa-check-square-o"></i></button>
                            </div>

                        </form>

                        <div class="modal fade" id="createGalleryModal" tabindex="-1" role="dialog"
                             aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="create_gallery_form">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            <h4 class="modal-title"
                                                id="myModalLabel"><?php echo trans("media::media.add_new_gallery"); ?></h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-camera"></i>
                                                </span>
                                                <input placeholder="<?php echo trans("media::media.gallery_name"); ?>"
                                                       value="" class="form-control" name="name">
                                            </div>
                                            <br/>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <input placeholder="<?php echo trans("media::media.author_name"); ?>"
                                                       value="" class="form-control" name="author">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal"><?php echo trans("media::media.close"); ?></button>
                                            <button type="submit"
                                                    class="btn btn-primary"><?php echo trans("media::media.save_gallery"); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editGalleryModal" tabindex="-1" role="dialog"
                             aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="edit_gallery_form">

                                        <input type="hidden" name="gallery_id" value=""/>

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            <h4 class="modal-title"
                                                id="editGalleryLabel"><?php echo trans("media::media.edit_gallery"); ?></h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-camera"></i>
                                                </span>
                                                <input placeholder="<?php echo trans("media::media.gallery_name"); ?>"
                                                       value="" class="form-control" name="name">
                                            </div>
                                            <br/>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <input placeholder="<?php echo trans("media::media.author_name"); ?>"
                                                       value="" class="form-control" name="author">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal"><?php echo trans("media::media.close"); ?></button>
                                            <button type="submit"
                                                    class="btn btn-primary"><?php echo trans("media::media.save_gallery"); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="galleries-sidebar" page="1"></div>

                    </div>
                    <div class="gallery_details_panel col-lg-9 col-md-8 col-sm-8 hidden-xs">
                        <form class="gallery_form">
                            <input type="hidden" id="gallery_id" name="gallery_id" value="0"/>
                            <div class="gallery-ctrl-bar">

                                <ul class="breadcrumb breadcrumb-no-padding" style="display: inline;line-height: 31px;">
                                    <li><a href="#"><i
                                                class="fa fa-camera"></i> <?php echo trans("media::media.galleries"); ?>
                                        </a></li>
                                    <li><a href="#" class="name"></a></li>
                                </ul>


                                <button class="btn btn-primary btn-flat gallery-select pull-right"
                                        data-loading-text="<?php echo trans("media::media.please_wait"); ?>"
                                        type="button"
                                        id="select_gallery"><i class="fa fa-check-square-o"></i></button>

                                <div class="btn-group pull-right gallery_btns">


                                    <button type="button" class="btn btn-default fileinput-button add-to-album"
                                            aria-label="<?php echo trans("media::media.add_to_gallery"); ?>">
                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        <input type="file" multiple="" name="files[]" id="add_to_gallery">
                                    </button>

                                    <button data-loading-text="<?php echo trans("media::media.deleting_gallery"); ?>"
                                            id="delete_gallery" type="button" class="btn btn-default"
                                            aria-label="<?php echo trans("media::media.add_to_gallery"); ?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>

                                    <button data-loading-text="<?php echo trans("media::media.saving_gallery"); ?>"
                                            id="save_gallery" type="button" class="btn btn-default"
                                            aria-label="<?php echo trans("media::media.saving_gallery"); ?>">
                                        <i class="fa fa-save"></i>
                                    </button>


                                </div>

                                <?php /*
                                <span class="btn btn-primary fileinput-button add-to-album">
                                    <i class="fa fa-plus"></i>
                                     <span><?php echo trans("media::media.add_to_gallery"); ?></span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input type="file" multiple="" name="files[]" id="add_to_gallery">
                                </span>

                                <div class="btn-group btn-group-justified pull-right" style="width:37%">

                                    <a id="delete_gallery" href="javascript:void(0)"
                                       data-loading-text="<?php echo trans("media::media.deleting_gallery"); ?>"
                                       class="btn btn-danger "><i class="fa fa-times"></i> <?php echo trans("media::media.delete_gallery"); ?></a>

                                    <a id="save_gallery" href="javascript:void(0)"
                                       data-loading-text="<?php echo trans("media::media.saving_gallery"); ?>"
                                       class="btn btn-success "><i class="fa fa-save"></i> <?php echo trans("media::media.saving_gallery"); ?></a>
                                </div>

 */ ?>

                            </div>

                            <div id="galleries-content"></div>
                        </form>
                    </div>
                    <div class="file_manager_footer row" style="display: none">
                        <div class="col-md-2 col-xs-2 col-sm-2 pull-left text-left">
                            <button class="btn btn-primary btn-flat"
                                    data-loading-text="<?php echo trans("media::media.please_wait"); ?>" type="button"
                                    id="select_gallery"><?php echo trans("media::media.select_media"); ?></button>
                        </div>
                    </div>

                </div>
            </div>

            <div id="embed-settings" class="tab-pane fade">
                <div class="container">
                    <form class="embed_settings"><br/>

                        <div class="row">
                            <div class="col-md-6">

                                <fieldset>
                                    <legend><?php echo trans("media::media.embed_settings"); ?></legend>
                                    <div class="form-group">
                                        <label><?php echo trans("media::media.width"); ?></label>
                                        <input type="text" class="form-control" name="embed_width"
                                               placeholder="<?php echo trans("media::media.width"); ?>">
                                    </div> <!-- / .form-group -->

                                    <div class="form-group">
                                        <label><?php echo trans("media::media.height"); ?></label>
                                        <input type="text" class="form-control" name="embed_height"
                                               placeholder="<?php echo trans("media::media.height"); ?>">
                                    </div> <!-- / .form-group -->


                                    <div class="form-group">
                                        <label><?php echo trans("media::media.start_time"); ?> <span
                                                class="badge"> <?php echo trans("media::media.seconds"); ?> </span></label>
                                        <?php /*
                                          <div class="input-group date">
                                          <input type="text" class="form-control" id="bs-timepicker-component"><span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                          </div>
                                         */ ?>

                                        <input type="number" class="form-control" name="embed_start" placeholder="0"
                                               value="0">
                                        <!--
                                        <div class="ui-slider-danger ui-slider-colors-demo"></div>
                                        -->
                                    </div> <!-- / .form-group -->

                                    <label class="checkbox">
                                        <input type="checkbox" value=""
                                               name="embed_autoplay"> <?php echo trans("media::media.auto_play"); ?>
                                    </label>

                                    <style>
                                        .ui-slider-colors-demo {
                                            margin-bottom: 20px;
                                        }

                                        .ui-v-slider-colors-demo {
                                            float: left;
                                            margin-right: 20px;
                                        }

                                        .right-to-left .ui-v-slider-colors-demo {
                                            float: right;
                                            margin-left: 20px;
                                            margin-right: 0;
                                        }
                                    </style>
                                    <!-- / Styles -->

                                    <!-- Javascript -->
                                    <script>
                                        $(document).ready(function () {

                                            var options2 = {
                                                minuteStep: 1,
                                                showSeconds: true,
                                                showMeridian: false,
                                                showInputs: false,
                                                orientation: $('body').hasClass('right-to-left') ? {
                                                    x: 'right',
                                                    y: 'auto'
                                                } : {x: 'auto', y: 'auto'}
                                            }
                                            /* $('#bs-timepicker-component').timepicker(options2);
                                             var colorful_sliders_options = {
                                             'range': 'min',
                                             'min': 0,
                                             'max': 60,
                                             'value': 30
                                             };
                                             $('.ui-slider-colors-demo').slider(colorful_sliders_options);*/
                                        });</script>


                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div> <!-- / .tab-pane -->
    </div>


</div>
