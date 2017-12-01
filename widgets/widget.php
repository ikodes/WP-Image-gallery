<?php

/*Photoswip Gallery widget*/

class PHP_Code_Widget extends WP_Widget {
	function __construct() {
		//load_plugin_textdomain( 'php-code-widget', false, dirname( plugin_basename( __FILE__ ) ) );
		$widget_ops = array('classname' => 'widget_execphp', 'description' => __('Display Gallery Image with Multiple Layout.', 'php-code-widget'));
		$control_ops = array('width' => 300, 'height' => 350);
		parent::__construct('execphp', __('Photoswip Gallery'), $widget_ops, $control_ops);
	}


	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_execphp', $instance['text'], $instance );
		$name = apply_filters( 'widget_execphp', $instance['name'], $instance );
		$posttype = apply_filters( 'widget_execphp', $instance['posttype'], $instance );
		echo $before_widget;

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
			ob_start();
			eval('?>'.$text);
			$text = ob_get_contents();
			ob_end_clean();
			?>
			<div class="execphpwidget"><?php  $instance['filter'] ? wpautop($text) : $text; ?></div>
			<div class="execphpwidget"><?php  $guj = $instance['filter'] ? wpautop($name) : $name; ?></div>
			<div class="execphpwidget"><?php  $instance['posttype'] ? wpautop($posttype) : $posttype; ?></div>

            <?php $post_id = $guj; ?>
			<?php
				$subjects = array($guj);
				$i = 1;
				foreach ($subjects as $subject){


				             $exp = explode(',', $subject);
				             //echo $exp[0].$i++;


				}
			$SLGF_CPT_Name = "slgf_slider";
		    $AllGalleries = array(  'p' => $guj, 'post_type' => $SLGF_CPT_Name, 'order' => 'desc');
		    $loop = new WP_Query( $AllGalleries ); ?>

		    <?php
		    if(!isset($Id['id'])) {
        $Id['id'] = "";
		$SLGF_Show_Gallery_Title  = "yes";
		$SLGF_Show_Image_Label    = "yes";
        $SLGF_Hover_Animation     = "stripe";
        $SLGF_Gallery_Layout      = "col-md-4";
		$SLGF_Thumbnail_Layout    = "same-size";
        $SLGF_Hover_Color         = "#0AC2D2";
		$SLGF_Text_BG_Color       = "#FFFFFF";
		$SLGF_Text_Color          = "#000000";
        $SLGF_Hover_Color_Opacity = "yes";
        $SLGF_Font_Style          = "font-name";
		$SLGF_Box_Shadow          = "yes";
		$SLGF_Custom_CSS          = "";
    } else {
		$SLGF_Id = $Id['id'];
		$SLGF_Settings = "SLGF_Gallery_Settings_".$SLGF_Id;
		$SLGF_Settings = unserialize(get_post_meta( $SLGF_Id, $SLGF_Settings, true));
		if(count($SLGF_Settings)) {
			$SLGF_Show_Gallery_Title  = $SLGF_Settings['SLGF_Show_Gallery_Title'];
			$SLGF_Show_Image_Label    = $SLGF_Settings['SLGF_Show_Image_Label'];
			$SLGF_Hover_Animation     = $SLGF_Settings['SLGF_Hover_Animation'];
			$SLGF_Gallery_Layout      = $SLGF_Settings['SLGF_Gallery_Layout'];
			$SLGF_Thumbnail_Layout    = $SLGF_Settings['SLGF_Thumbnail_Layout'];
			$SLGF_Hover_Color         = $SLGF_Settings['SLGF_Hover_Color'];
			$SLGF_Text_BG_Color       = $SLGF_Settings['SLGF_Text_BG_Color'];
			$SLGF_Text_Color          = $SLGF_Settings['SLGF_Text_Color'];
			$SLGF_Hover_Color_Opacity = $SLGF_Settings['SLGF_Hover_Color_Opacity'];
			$SLGF_Font_Style          = $SLGF_Settings['SLGF_Font_Style'];
			$SLGF_Box_Shadow          = $SLGF_Settings['SLGF_Box_Shadow'];
			$SLGF_Custom_CSS          = $SLGF_Settings['SLGF_Custom_CSS'];
		}
	}

    $RGB = SLGF_RPGhex2rgb($SLGF_Hover_Color);
    $HoverColorRGB = implode(", ", $RGB);




		     ?>
    	<div class="gal-container" id="slgf_<?php $post_id = get_the_ID(); ?>">
			<?php while ( $loop->have_posts() ) : $loop->the_post();?>
			<!--get the post id-->
			<?php $post_id = get_the_ID(); ?>

				<!--Gallery Title-->
				<?php if($SLGF_Show_Gallery_Title == "yes") { ?>
				<div style="font-weight: bolder; padding-bottom:20px; border-bottom:2px solid #cccccc;margin-bottom: 20px">
					<?php echo get_the_title($post_id); ?>
				</div>
				<?php } ?>

				<div class="gallery1">
					<?php
					/**
					 * Get All Photos from Lightbox
					 */
					$SLGF_AlPhotosDetails = unserialize(get_post_meta( get_the_ID(), 'slgf_all_photos_details', true));
					$TotalImages =  get_post_meta( get_the_ID(), 'slgf_total_images_count', true );
					$i = 1;

					if($TotalImages) {
						foreach($SLGF_AlPhotosDetails as $SLGF_SinglePhotosDetail) {
							$name = $SLGF_SinglePhotosDetail['slgf_image_label'];
							$url  = $SLGF_SinglePhotosDetail['slgf_image_url'];
							$url1 = $SLGF_SinglePhotosDetail['slgf_12_thumb'];
							$url2 = $SLGF_SinglePhotosDetail['slgf_346_thumb'];
							$url3 = $SLGF_SinglePhotosDetail['slgf_12_same_size_thumb'];
							$url4 = $SLGF_SinglePhotosDetail['slgf_346_same_size_thumb'];
							$i++;


							if($SLGF_Gallery_Layout == "col-md-6") { // two column
								if($SLGF_Thumbnail_Layout == "same-size") $Thummb_Url = $url3;
								if($SLGF_Thumbnail_Layout == "masonry") $Thummb_Url = $url1;
								if($SLGF_Thumbnail_Layout == "original") $Thummb_Url = $url;
							}
							if($SLGF_Gallery_Layout == "col-md-4") {// Three column
								if($SLGF_Thumbnail_Layout == "same-size") $Thummb_Url = $url4;
								if($SLGF_Thumbnail_Layout == "masonry") $Thummb_Url = $url2;
								if($SLGF_Thumbnail_Layout == "original") $Thummb_Url = $url;
							}
							if($SLGF_Gallery_Layout == "col-md-2") {// four column
								if($SLGF_Thumbnail_Layout == "same-size") $Thummb_Url = $url0;
								if($SLGF_Thumbnail_Layout == "masonry") $Thummb_Url = $url1;
								if($SLGF_Thumbnail_Layout == "original") $Thummb_Url = $url;
							}
						?>
						<div class="<?php echo $SLGF_Gallery_Layout; ?> col-sm-4 wl-gallery" >
							<div class="img-box-shadow">

								<?php //  Swipe box	?>
								<a title="<?php echo $name; ?>" class="swipebox_<?php $post_id = get_the_ID(); ?>"  href="<?php echo $url; ?>">
									<div class="b-link-<?php echo $SLGF_Hover_Animation; ?> b-animate-go">
										<img src="<?php echo $url2; ?>" class="gall-img-responsive" alt="<?php echo $name; ?>">
									</div>
								</a>

								<!--Gallery Label-->
								<?php if($SLGF_Show_Image_Label == "yes" && $name) {?>
								<div class="slgf_home_portfolio_caption">
									<h3><?php echo $name; ?></h3>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php
						}// end of foreach
					} else {
						echo __("No Photo Found In Photo Gallery.", WEBLIZAR_SLGF_TEXT_DOMAIN);
					}// end of if else total images
				?>
				</div>
		<?php endwhile; ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				;( function( jQuery ) {
					jQuery( '.swipebox_<?php $post_id = get_the_ID(); ?>' ).swipebox({
									hideBarsDelay:0,
									hideCloseButtonOnMobile : false,
								});
				})( jQuery );
			});

			jQuery('.gallery1').imagesLoaded( function(){
			  jQuery('.gallery1').masonry({
			   itemSelector: '.wl-gallery',
			   isAnimated: true,
			   isFitWidth: true
			  });
			});
	</script>
    		</div>


		<?php
		echo $after_widget;
	}




	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		 $instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		  $instance['posttype'] = ( ! empty( $new_instance['posttype'] ) ) ? strip_tags( $new_instance['posttype'] ) : '';

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}




function form( $instance ) {
	$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
	$title = strip_tags($instance['title']);
	$text = format_to_edit($instance['text']);
	$posttype = $instance['posttype'];
if ( isset( $instance[ 'name' ] ) ) {

       $name = $instance[ 'name' ];
        }
        else {
            $name = __( 'Enter gallery ID', 'widget_execphp' );
        }


?>

<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'php-code-widget'); ?></label>

<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

<textarea class="widefat" rows="6" cols="4" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

<p>
    <label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Include:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Please use(,)comma separated attachment IDs (like include="24,30,43")' ); ?></label>
</p>
<p>
<label>Choose your Style</label>
      <select id="<?php echo $this->get_field_id('posttype'); ?>" name="<?php echo $this->get_field_name('posttype'); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['posttype'], 'Document Icon'); ?> value="document">Seclect Layout</option>
        <option <?php selected( $instance['posttype'], 'Document Icon'); ?> value="document" selected="selected">Show Masonry Style Thumbnails</option>
        <option <?php selected( $instance['posttype'], 'Show Same Size Thumbnails'); ?> value="briefcase" selected="selected">Show Same Size Thumbnails</option>
        <option <?php selected( $instance['posttype'], 'Show Original Image As Thumbnails '); ?> value="chat" selected="selected">Show Original Image As Thumbnails </option>

    </select></p>

<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs.', 'php-code-widget'); ?></label></p>
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("PHP_Code_Widget");'));
