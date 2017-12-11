<?php

use Core\Utils;

echo 
    '<div id="gallery_widget_'.$gallery->id.'" class="widget widget-gallery row">'.
        '<div class="col-lg-12">'.
            '<h2>'.$gallery->title.'</h2>'.
        '</div>';

$gallery->galleriesmedias;
if (!empty($gallery->galleriesmedias)) {
    foreach ($gallery->galleriesmedias as $index => $galleryMedia) {
        $media = $galleryMedia->media;

        if ($media->type == 'image') {
            $imageUrl = $media->getUrl();

            $path = PUBLIC_DIR.$imageUrl;

            $imageInfos = array();
            if (file_exists($path)) {
                $img = new \Imagick($path);

                $imageInfos['width'] = $img->getImageWidth();
                $imageInfos['height'] = $img->getImageHeight();
                $imageInfos['size'] = Utils::bytesToHumanReadable($img->getImageLength());

                $imageInfos['mime'] = $img->getImageMimeType();

                $r = $img->getImageResolution();
                $imageInfos['resolution_x'] = $r['x'];
                $imageInfos['resolution_y'] = $r['y'];
            }

        } else {
            $imageUrl = '';
        }

        $title = 
            $galleryMedia->title != '' ?
            $galleryMedia->title : 
                $media->name != '' ?
                $media->name :
                '';

        $description = 
            $galleryMedia->description != '' ?
            $galleryMedia->description : 
                $media->description != '' ?
                $media->description :
                '';

        $media = urlencode(json_encode(array(
            'index' => $index,
            'type' => $media->type,
            'image' => $imageUrl,
            'title' => $title,
            'description' => $description,
            'imageInfos' => $imageInfos
        )));

        echo 
            '<div class="col-lg-3">'.
                '<div class="gallery-media" data-index="'.$index.'" data-media="'.$media.'">'.
                    '<img class="gallery-media-image img-fluid" src="'.$imageUrl.'" alt="'.$title.'" data-index="'.$index.'" />'.
                    // '<div class="gallery-media-title">'.$title.'</div>'.
                    // '<div class="gallery-media-description">'.$description.'</div>'.
                '</div>'.
            '</div>';
    }
}

echo '</div>';

