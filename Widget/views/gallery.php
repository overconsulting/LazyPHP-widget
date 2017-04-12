<div id="gallery_"<?php echo $this->id ?>" class="widget widget-gallery">
    <ul>
<?php foreach ($this->galleriesmedias as $gallerymedia): ?>
        <li class="media">
            Media : <?php echo $gallerymedia->media->id; ?>
        </li>
<?php endforeach ?>
    </ul>
</div>