<?php extract(shortcode_atts(array(
    'title'         => '',
    'content_over'         => '',
    'link'         => '',
  ), $attr));
?>
<div class="st-overview-content">
	<div class="st-content-over">
		<div class="st-content">
			<div class="title">
				<h3><?php echo $title; ?></h3>
			</div>
			<div class="content">
				<?php echo $content_over; ?>
			</div>
			<div class="read_more">
				<a href="<?php echo (vc_build_link($link)['url']);?>"><?php echo (vc_build_link($link)['title']);?></a>
			</div>
		</div>
	</div>
</div>