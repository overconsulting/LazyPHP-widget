<div id="gallery_widget_<?php echo $gallery->id; ?>" class="widget widget-gallery row">
	<?php foreach ($gallery->galleriesmedias as $gallerymedia) : ?>
		<a href="<?php echo $gallerymedia->url; ?>" title="<?php echo $gallerymedia->title; ?>">
			<div class="col-lg-3 media">
				<div class="img"><img src="<?php echo $gallerymedia->media->image->url; ?>" alt="<?php echo $gallerymedia->title; ?>" /></div>
				<div class="title"><?php echo $gallerymedia->title; ?></div>
				<div class="description"><?php echo $gallerymedia->description; ?></div>
			</div>
		</a>
	<?php endforeach; ?>
</div>
