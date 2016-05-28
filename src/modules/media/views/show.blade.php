<?php foreach ($files as $row) { ?>
    <div class="dz-preview dz-image-preview" media-id="<?php echo $row->id ?>">

        <?php if ($row->provider == "youtube") { ?>
            <input type="hidden" name="provider" value="youtube"/>
            <input type="hidden" name="duration" value="<?php echo format_duration($row->duration); ?>"/>
            <input type="hidden" name="url" value="<?php echo "https://www.youtube.com/watch?v=" . $row->path; ?>"/>   
            <input type="hidden" name="thumbnail" value="http://img.youtube.com/vi/<?php echo $row->path; ?>/0.jpg"/>
            <input type="hidden" name="size" value=""/>
            <input type="hidden" name="path" value="<?php echo $row->title ?>"/>
            <input type="hidden" name="provider_id" value="<?php echo $row->path; ?>"/>
        <?php } else { ?>
            <input type="hidden" name="url" value="<?php echo uploads_url($row->path); ?>"/>   
            <input type="hidden" name="thumbnail" value="<?php echo thumbnail($row->path) ?>"/>
            <input type="hidden" name="size" value="<?php echo (File::exists(uploads_path($row->path))) ? format_file_size(File::size(uploads_path($row->path))) : "0 MB" ?>"/>
            <input type="hidden" name="path" value="<?php echo $row->path ?>"/>
            <input type="hidden" name="duration" value=""/>
            <input type="hidden" name="provider" value=""/>
        <?php } ?>

        <input type="hidden" name="id" value="<?php echo $row->id ?>"/>
        <input type="hidden" name="title" value="<?php echo $row->title ?>"/>
        <input type="hidden" name="description" value="<?php echo $row->description ?>"/>
        <input type="hidden" name="created_date" value="<?php echo $row->created_date ?>"/>

        <i class="fa fa-check right-mark"></i>
        <div class="dz-details">
            <div class="dz-thumbnail-wrapper">
               
                <div class="dz-thumbnail">
                    <?php if($row->type == "video"){ ?>
                    <i class="vid fa fa-play-circle"></i>
                    <?php } ?>
                    <?php if ($row->provider == "youtube") { ?>
                        <img src="http://img.youtube.com/vi/<?php echo $row->path; ?>/0.jpg">
                    <?php } else { ?>
                        <img src="<?php echo thumbnail($row->path) ?>">
                    <?php } ?>
                    <span class="dz-nopreview">No preview</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>