<?php

echo '<div id="gallery_widget_'.$gallery->id.'" class="widget widget-gallery row">';

$gallery->galleriesmedias;
if (!empty($gallery->galleriesmedias)) {
    foreach ($gallery->galleriesmedias as $galleryMedia) {
        if ($galleryMedia->media->type == 'image') {
            $imageUrl = $galleryMedia->media->getUrl();
        } else {
            $imageUrl = '';
        }

        $title = 
            $galleryMedia->title != '' ?
            $galleryMedia->title : 
                $galleryMedia->media->name != '' ?
                $galleryMedia->media->name :
                '';

        $description = 
            $galleryMedia->description != '' ?
            $galleryMedia->description : 
                $galleryMedia->media->description != '' ?
                $galleryMedia->media->description :
                '';

        echo 
            '<div class="col-lg-3">'.
                '<div class="gallery-media">'.
                    '<img class="gallery-media-image img-fluid" src="'.$imageUrl.'" alt="'.$galleryMedia->title.'" />'.
                    // '<div class="gallery-media-title">'.$title.'</div>'.
                    // '<div class="gallery-media-description">'.$description.'</div>'.
                '</div>'.
            '</div>';
    }
}

echo '</div>';

