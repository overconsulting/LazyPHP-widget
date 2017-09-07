<div id="gallery_widget_<?php echo $gallery->id; ?>" class="widget widget-gallery row">
    <?php foreach ($gallery->galleriesmedias as $gallerymedia) : ?>
        <div class="media col-lg-3">
            <!-- <a href="<?php echo $gallerymedia->url; ?>" title="<?php echo $gallerymedia->title; ?>"> -->
                <img class="img-thumbnail" src="<?php echo $gallerymedia->media->image->url; ?>" alt="<?php echo $gallerymedia->title; ?>" />
                <div class="title"><?php echo $gallerymedia->title; ?></div>
                <div class="description"><?php echo $gallerymedia->description; ?></div>
            <!-- </a> -->
        </div>
    <?php endforeach; ?>
</div>
