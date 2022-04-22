<?php
/**
 * The style "light" of the Services
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');

if (empty($args['featured'])) $args['featured'] = 'image';

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = get_permalink();
$featured_position = !empty($args['featured_position']) ? $args['featured_position'] : 'top';
$svg_present = false;

if ($args['slider']) {
	?><div class="swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
?>
<div class="sc_services_item<?php
	echo isset($args['hide_excerpt']) && (int)$args['hide_excerpt']>0 ? ' without_content' : ' with_content';
	echo empty($args['featured']) || $args['featured']=='image' 
					? ' with_image' 
					: ($args['featured']=='icon' ? ' with_icon' : ' with_number');
	echo ' sc_services_item_featured_'.esc_attr($featured_position);
?>">
	<?php
	// Featured image or icon
	if ( has_post_thumbnail() && (empty($args['featured']) || $args['featured']=='image')) {
		trx_addons_get_template_part('templates/tpl.featured.php',
										'trx_addons_args_featured',
										apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_services_item_thumb',
														'thumb_size' => trx_addons_get_thumb_size( 'service' )
														),
														'services-light'
														)
									);
	} else if ($args['featured']=='icon' && !empty($meta['icon'])) {
		$svg = '';
		if (!empty($args['icons_animation']) && $args['icons_animation'] > 0 && ($svg = trx_addons_get_file_dir('css/svg-icons/'.trx_addons_esc($meta['icon']).'.svg')) != '') {
			$svg_present = true;
		}
		?><a href="<?php echo esc_url($link); ?>"
			 id="<?php echo esc_attr($args['id'].'_'.trim($meta['icon'])); ?>"
			 class="sc_services_item_icon <?php echo empty($svg) ? esc_attr($meta['icon']) : 'sc_icon_type_svg'; ?>"
			 ><?php
			if (!empty($svg)) {
				trx_addons_show_layout(trx_addons_get_svg_from_file($svg));
			}
		?></a><?php
	} else if ($args['featured']=='number') {
		?><span class="sc_services_item_number"><?php
			$number = get_query_var('trx_addons_args_item_number');
			printf("%02d", $number);
		?></span><?php
	}
	?>	
	<div class="sc_services_item_info">
		<div class="sc_services_item_header">
            <?php
            if ($args['featured']!='number' || $featured_position!='top') {
                ?><div class="sc_services_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms('/ ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY));?></div><?php
            }
            ?>
			<?php
			$title_tag = $args['featured']=='number' ? 'h4' : 'h5';
			if ($args['featured']=='number' && $featured_position=='top') {
				?><div class="sc_services_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms('/ ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY));?></div><?php
			}
			?>
			<<?php echo esc_html($title_tag); ?> class="sc_services_item_title"><a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a></<?php echo esc_html($title_tag); ?>>

		</div>
		<?php if (!isset($args['hide_excerpt']) || (int)$args['hide_excerpt']==0) { ?>
			<div class="sc_services_item_content"><?php the_excerpt(); ?></div>
			<div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>" class="sc_button sc_button_simple"><?php esc_html_e('Learn more', 'greenville'); ?></a></div>
		<?php } ?>
	</div>
</div>
<?php
if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
	wp_enqueue_script( 'vivus', trx_addons_get_file_url('shortcodes/icons/vivus.js'), array('jquery'), null, true );
	wp_enqueue_script( 'trx-addons-sc-icons', trx_addons_get_file_url('shortcodes/icons/icons.js'), array('jquery'), null, true );
}
?>