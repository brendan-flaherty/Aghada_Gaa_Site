<?php
if ($count === 1) {
	// Big Template
	$el_class = 'big-element';
	$el_thumbnail_size = array($bigElementWidth, $bigElementHeight);
} else {
	// Small Template
	$el_class = 'small-element';
	if ($el_decrement > 0) {
		$el_thumbnail_size = array($smallElementWidth, ($smallElementHeight + 1));
		$el_decrement--;
	} else {
		$el_thumbnail_size = array($smallElementWidth, $smallElementHeight);
	}


}

if (has_post_thumbnail()) {
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
} else {
	$img_url = '';
}

if ($enable_description) {
	$content = get_the_content();
	$trimmed_content = wp_trim_words($content, $limit_words, '');
}
?>

<div class="<?php echo $el_class; ?> item">
	<div class="entry-thumb">
		<img src="<?php echo aq_resize($img_url, $el_thumbnail_size[0], $el_thumbnail_size[1], true); ?>" alt="">

		<?php if ($enable_title): ?>
			<div class="entry-title">
				<?php if ($enable_link) { ?>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

				<?php
				} else {
					the_title();
				}
				?>
			</div>
		<?php endif; ?>

	</div>
</div>