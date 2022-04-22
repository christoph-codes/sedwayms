<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage GREENVILLE
 * @since GREENVILLE 1.0
 */

greenville_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	?><div class="posts_container"><?php
	
	$greenville_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$greenville_sticky_out = is_array($greenville_stickies) && count($greenville_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($greenville_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($greenville_sticky_out && !is_sticky()) {
			$greenville_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $greenville_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($greenville_sticky_out) {
		$greenville_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	greenville_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>