<?php if (count($files)) { ?>
    <?php foreach ($files as $row) { ?>
        <div class="dz-preview dz-image-preview" media-id="<?php echo $row->id ?>">

            <input type="hidden" name="media_url" value="<?php echo $row->url; ?>"/>
            <input type="hidden" name="media_thumbnail" value="<?php echo $row->thumbnail; ?>"/>
            <input type="hidden" name="media_path" value="<?php echo $row->path ?>"/>
            <input type="hidden" name="media_type" value="<?php echo $row->type ?>"/>
            <input type="hidden" name="media_provider" value="<?php echo $row->provider; ?>"/>
            <input type="hidden" name="media_provider_id" value="<?php echo $row->provider_id; ?>"/>
            <input type="hidden" name="media_duration" value="<?php echo $row->duration; ?>"/>
            <input type="hidden" name="media_id" value="<?php echo $row->id ?>"/>
            <input type="hidden" name="media_title" value="<?php echo $row->title ?>"/>
            <input type="hidden" name="media_description" value="<?php echo $row->description ?>"/>
            <input type="hidden" name="media_created_date" value="<?php echo $row->created_at ?>"/>

            <i class="fa fa-check right-mark"></i>

            <div class="dz-details">
                <div class="dz-thumbnail-wrapper">

                    <div class="dz-thumbnail">

                        <?php if (in_array($row->type, array("video", "audio"))) { ?>
                            <i class="vid fa fa-play-circle"></i>
                        <?php } ?>

                        <img src="<?php echo $row->thumbnail; ?>">

                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
<?php } elseif(count($files) == 0 and $page == 1) { ?>
    <div class="no-media text-center">
        <i class="fa fa-file"></i>
    </div>
<?php } ?>
