<?php


// Image Crop Size Function
add_image_size( 'slgf_12_thumb', 500, 9999, array( 'center', 'top'));
add_image_size( 'slgf_346_thumb', 400, 9999, array( 'center', 'top'));
add_image_size( 'slgf_12_same_size_thumb', 500, 500, array( 'center', 'top'));
add_image_size( 'slgf_346_same_size_thumb', 400, 400, array( 'center', 'top'));

/**
 * Support and Our Products Page
 */
function psg_admin_content_slb_144936() {
	if(get_post_type()=="Photoswip") { ?>
		<style>
		.wlTBlock{
			background:#F8504B;
			padding: 27px 0 23px 0;
			margin-left: -20px;
			font-family: Myriad Pro ;
			cursor: pointer;
			text-align: center;
		}
		.wlTBlock .wlTBig{
			color: white;
			font-size: 30px;
			font-weight: bolder;
			padding: 0 0 15px 0;
		}
		.wlTBlock .wlTBig .dashicons{
			font-size: 40px;
			position: absolute;
			margin-left: -45px;
			margin-top: -10px;
		}
		.wlTBlock .WlTSmall{
			font-weight: bolder;
			color: white;
			font-size: 18px;
			padding: 0 0 15px 15px;
		}

		.wlTBlock a{
		text-decoration: none;
		}
		@media screen and ( max-width: 600px ) {
			.wlTBlock{ padding-top: 60px; margin-bottom: -50px; }
			.wlTBlock .WlTSmall { display: none; }

		}
		</style>

	<?php
	}
}
add_action('in_admin_header','psg_admin_content_slb_144936');


/**
 * Weblizar Lightbox Slider Pro Shortcode Detect Function
 */
function slgf_js_css_load_function() {
    global $wp_query;
    $Posts = $wp_query->posts;
    $Pattern = get_shortcode_regex();

    foreach ($Posts as $Post) {
		if ( strpos($Post->post_content, 'Photoswip_' ) ) {
            /**
             * js scripts
             */
            wp_enqueue_script('jquery');
            wp_enqueue_script('wl-slgf-hover-pack-js',WEBLIZAR_SLGF_PLUGIN_URL.'js/hover-pack.js', array('jquery'));
            wp_enqueue_script('wl-slgf-rpg-script', WEBLIZAR_SLGF_PLUGIN_URL.'js/reponsive_photo_gallery_script.js', array('jquery'));


			//swipe box js css
            wp_enqueue_style('wl-slgf-swipe-css', WEBLIZAR_SLGF_PLUGIN_URL.'lightbox/swipebox/swipebox.css');
			wp_enqueue_script('wl-slgf-swipe-js', WEBLIZAR_SLGF_PLUGIN_URL.'lightbox/swipebox/jquery.swipebox.js', array('jquery'));

            /**
             * css scripts
             */
			wp_enqueue_style('wl-slgf-hover-pack-css', WEBLIZAR_SLGF_PLUGIN_URL.'css/hover-pack.css');
			wp_enqueue_style('wl-slgf-boot-strap-css', WEBLIZAR_SLGF_PLUGIN_URL.'css/bootstrap.css');
			wp_enqueue_style('wl-slgf-img-gallery-css', WEBLIZAR_SLGF_PLUGIN_URL.'css/img-gallery.css');

            /**
             * font awesome css
             */
			wp_enqueue_style('wl-slgf-font-awesome-4', WEBLIZAR_SLGF_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');

            /**
             * envira & isotope js
             */
			wp_enqueue_script( 'slgf_envira-js', WEBLIZAR_SLGF_PLUGIN_URL.'js/masonry.pkgd.min.js', array('jquery') );
			wp_enqueue_script( 'slgf_imagesloaded', WEBLIZAR_SLGF_PLUGIN_URL.'js/imagesloaded.pkgd.min.js', array('jquery') );

            break;
        } //end of if
    } //end of foreach
}

/** For the_title function **/
add_action( 'wp', 'slgf_js_css_load_function' );

add_filter('the_title', 'psg_slgf_convac_lite_untitled');
function psg_slgf_convac_lite_untitled($title) {
	if ($title == '') {
		return __('No Title','convac-lite');
	} else {
		return $title;
	}
}

function psg_slgf_remove_image_box() {
	remove_meta_box('postimagediv','slgf_slider','side');
}
add_action('do_meta_boxes', 'psg_slgf_remove_image_box');

/**
 * Class Defination For Lightbox
 */
class psg_Photoswip_ {

    private $admin_thumbnail_size = 150;
    private $thumbnail_size_w = 150;
    private $thumbnail_size_h = 150;

	public function __construct() {
		add_action('admin_print_scripts-post.php', array(&$this, 'slgf_admin_print_scripts'));
        add_action('admin_print_scripts-post-new.php', array(&$this, 'slgf_admin_print_scripts'));
		add_image_size('rpg_gallery_admin_thumb', $this->admin_thumbnail_size, $this->admin_thumbnail_size, true);
        add_image_size('rpg_gallery_thumb', $this->thumbnail_size_w, $this->thumbnail_size_h, true);
		add_shortcode('lightboxslider', array(&$this, 'shortcode'));

		if (is_admin()) {
            add_action('init', array(&$this, 'Photoswip_posttype'), 1);
            add_action('add_meta_boxes', array(&$this, 'add_all_slgf_meta_boxes'));
            add_action('admin_init', array(&$this, 'add_all_slgf_meta_boxes'), 1);
            add_action('save_post', array(&$this, 'slgf_add_image_meta_box_save'), 9, 1);
			add_action('save_post', array(&$this, 'slgf_settings_meta_save'), 9, 1);
            add_action('wp_ajax_slgf_get_thumbnail', array(&$this, 'ajax_get_thumbnail_slgf'));
        }
	}

	//Required JS & CSS
	public function slgf_admin_print_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('slgf-media-uploader-js', WEBLIZAR_SLGF_PLUGIN_URL . 'js/slgf-multiple-media-uploader.js', array('jquery'));
		wp_enqueue_media();
		//custom add image box css
		wp_enqueue_style('slgf-meta-css', WEBLIZAR_SLGF_PLUGIN_URL.'css/rpg-meta.css');

		//font awesome css
		wp_enqueue_style('slgf-font-awesome-4', WEBLIZAR_SLGF_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');

		//single media uploader js
		wp_enqueue_script('slgf-media-uploads',WEBLIZAR_SLGF_PLUGIN_URL.'js/slgf-media-upload-script.js',array('media-upload','thickbox','jquery'));
    }

	// Register Custom Post Type
	public function Photoswip_posttype() {
		$labels = array(
        'name'                => _x( 'Photo Swip', 'Photoswip', 'Photoswip' ),
        'singular_name'       => _x( 'Photo Swip Gallery', 'Photoswip', 'Photoswip' ),
        'menu_name'           => __( 'Photo Swip ', 'Photoswip' ),
        'parent_item_colon'   => __( 'Parent Item:', 'Photoswip' ),
        'all_items'           => __( 'All Photo Swip', 'Photoswip' ),
        'view_item'           => __( 'View Photo Swip', 'Photoswip' ),
        'add_new_item'        => __( 'Add New Photo Swip Gallery', 'Photoswip' ),
        'add_new'             => __( 'Add Photo Swip Gallery', 'Photoswip' ),
        'edit_item'           => __( 'Edit Photo Swip Gallery', 'Photoswip' ),
		'new_item' 			  => __( 'New Gallery', 'Photoswip' ),
        'update_item'         => __( 'Update Photo Swip Gallery', 'Photoswip' ),
        'search_items'        => __( 'Search Photo Swip', 'Photoswip' ),
        'not_found'           => __( 'No Photo Swip Gallery Found', 'Photoswip' ),
        'not_found_in_trash'  => __( 'No Photo Swip Gallery found in Trash', 'Photoswip' ),
    );
    $args = array(
        'label'               => __( 'slgf_slider', WEBLIZAR_SLGF_TEXT_DOMAIN ),
        'description'         => __( 'Photo Swip Gallery', WEBLIZAR_SLGF_TEXT_DOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'thumbnail', '', '', '', '', '', '', '', '', '', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-format-gallery',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
		register_post_type( 'slgf_slider', $args );
        add_filter( 'manage_edit-slgf_gallery_columns', array(&$this, 'slgf_gallery_columns' )) ;
        add_action( 'manage_slgf_gallery_posts_custom_column', array(&$this, 'slgf_gallery_manage_columns' ), 10, 2 );
	}

	//column fields on all galleries page
	function slgf_gallery_columns( $columns ){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Gallery' ),
            'shortcode' => __( 'Gallery Shortcode' ),
            'date' => __( 'Date' )
        );
        return $columns;
    }

	//column action fields on all galleries page
	function slgf_gallery_manage_columns( $column, $post_id ){
        global $post;
        switch( $column ) {
          case 'shortcode' :
            echo '<input type="text" value="[Photoswip_ id='.$post_id.']" readonly="readonly" />';
            break;
          default :
            break;
        }
    }

	// all metabox generator function
	public function add_all_slgf_meta_boxes() {
		add_meta_box( __('Add Images', WEBLIZAR_SLGF_PLUGIN_URL), __('Add Images', WEBLIZAR_SLGF_PLUGIN_URL), array(&$this, 'slgf_generate_add_image_meta_box_function'), 'slgf_slider', 'normal', 'low' );
		add_meta_box( __('Apply Setting On Photoswip Gallery', WEBLIZAR_SLGF_PLUGIN_URL), __('Apply Setting On Photoswip Gallery', WEBLIZAR_SLGF_PLUGIN_URL), array(&$this, 'slgf_settings_meta_box_function'), 'slgf_slider', 'normal', 'low');
		add_meta_box ( __('Photoswip Gallery Shortcode', WEBLIZAR_SLGF_PLUGIN_URL), __('Photoswip Shortcode', WEBLIZAR_SLGF_PLUGIN_URL), array(&$this, 'slgf_shotcode_meta_box_function'), 'slgf_slider', 'side', 'low');

   }


	/**
	 * This function display Add New Image interface
	 * Also loads all saved gallery photos into photo gallery
	 */
    public function slgf_generate_add_image_meta_box_function($post) { ?>
		<style>
		#titlediv #title {
			margin-bottom:15px;
		}
		</style>
		<div id="rpggallery_container">

			<ul id="slgf_gallery_thumbs" class="clearfix">
				<?php
				/* Load saved photos into gallery */
				$SLGF_AllPhotosDetails = unserialize(get_post_meta( $post->ID, 'slgf_all_photos_details', true));
				$TotalImages =  get_post_meta( $post->ID, 'slgf_total_images_count', true );
				if($TotalImages) {
					foreach($SLGF_AllPhotosDetails as $SLGF_SinglePhotoDetails) {
						$name = $SLGF_SinglePhotoDetails['slgf_image_label'];
						$UniqueString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
						$url = $SLGF_SinglePhotoDetails['slgf_image_url'];
						$url1 = $SLGF_SinglePhotoDetails['slgf_12_thumb'];
						$url2 = $SLGF_SinglePhotoDetails['slgf_346_thumb'];
						$url3 = $SLGF_SinglePhotoDetails['slgf_12_same_size_thumb'];
						$url4 = $SLGF_SinglePhotoDetails['slgf_346_same_size_thumb'];
						?>
						<li class="rpg-image-entry" id="rpg_img">
							<a class="gallery_remove lbsremove_bt" href="#gallery_remove" id="lbs_remove_bt" ><img src="<?php echo  WEBLIZAR_SLGF_PLUGIN_URL.'images/Close-icon.png'; ?>" /></a>
							<img src="<?php echo $url; ?>" class="rpg-meta-image" alt=""  style="">
							<!--<input type="button" id="upload-background-<?php //echo $UniqueString; ?>" name="upload-background-<?php //echo $UniqueString; ?>" value="Upload Image" class="button-primary " onClick="weblizar_image('<?php //echo $UniqueString; ?>')" />
							<input type="text" id="slgf_image_label[]" name="slgf_image_label[]" value="<?php // echo htmlentities($name); ?>" placeholder="Enter Image Label" class="rpg_label_text">-->

							<input type="text" id="slgf_image_url[]"  name="slgf_image_url[]"  class="rpg_label_text"  value="<?php echo  $url; ?>"   readonly="readonly" style="display:none;" />
							<input type="text" id="slgf_image_url1[]" name="slgf_image_url1[]" class="rpg_label_text"  value="<?php echo  $url1; ?>"  readonly="readonly" style="display:none;" />
							<input type="text" id="slgf_image_url2[]" name="slgf_image_url2[]" class="rpg_label_text"  value="<?php echo  $url2; ?>"  readonly="readonly" style="display:none;" />
							<input type="text" id="slgf_image_url3[]" name="slgf_image_url3[]" class="rpg_label_text"  value="<?php echo  $url3; ?>"  readonly="readonly" style="display:none;" />
							<input type="text" id="slgf_image_url4[]" name="slgf_image_url4[]" class="rpg_label_text"  value="<?php echo  $url4; ?>"  readonly="readonly" style="display:none;" />
						</li>
						<?php

					} // end of foreach
				} else {
					$TotalImages = 0;
				}
				?>
            </ul>

        </div>

		<!--Add New Image Button-->
		<div class="rpg-image-entry add_rpg_new_image" id="slgf_gallery_upload_button" data-uploader_title="Upload Image" data-uploader_button_text="Select" >
			<div class="dashicons dashicons-plus"></div>
			<p>
				<?php _e('Add New Images', WEBLIZAR_SLGF_PLUGIN_URL); ?>
			</p>
		</div>

		<div style="clear:left;"></div>
		<input id="slgf_delete_all_button" class="button" type="button" value="Delete All" rel="">

		<?php
	}

	/**
	 * This function display Add New Image interface
	 * Also loads all saved gallery photos into Lightbox gallery
	 */
    public function slgf_settings_meta_box_function($post) {
		require_once('simple-lightbox-slider-setting-metabox.php');
	}

	public function slgf_shotcode_meta_box_function() { ?>
		<p><?php _e("Use below shortcode in any Page/Post to publish your photo gallery", WEBLIZAR_SLGF_PLUGIN_URL);?></p>
		<input readonly="readonly" type="text" value="<?php echo "[Photoswip_ id=".get_the_ID()."]"; ?>">
		<?php
	}

	//
	public function admin_thumb($id) {
        $image  = wp_get_attachment_image_src($id, 'lightboxslider_admin_medium', true);
		$image1 = wp_get_attachment_image_src($id, 'slgf_12_thumb', true);
        $image2 = wp_get_attachment_image_src($id, 'slgf_346_thumb', true);
        $image3 = wp_get_attachment_image_src($id, 'slgf_12_same_size_thumb', true);
        $image4 = wp_get_attachment_image_src($id, 'slgf_346_same_size_thumb', true);

		$UniqueString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        ?>
		<li class="rpg-image-entry" id="rpg_img">
			<a class="gallery_remove lbsremove_bt" href="#gallery_remove" id="lbs_remove_bt" ><img src="<?php echo  WEBLIZAR_SLGF_PLUGIN_URL.'images/Close-icon.png'; ?>" /></a>
			<img src="<?php echo $image[0]; ?>" class="rpg-meta-image" alt=""  style="">
			 <input type="button" id="upload-background-<?php echo $UniqueString; ?>" name="upload-background-<?php echo $UniqueString; ?>" value="Upload Image" class="button-primary " onClick="weblizar_image('<?php echo $UniqueString; ?>')" />
			<input type="text" id="slgf_image_label[]" name="slgf_image_label[]" placeholder="Enter Image Label" class="rpg_label_text">

			<input type="text" id="slgf_image_url[]"  name="slgf_image_url[]"  class="rpg_label_text"  value="<?php echo $image[0]; ?>"   readonly="readonly" style="display:none;" />
			<input type="text" id="slgf_image_url1[]" name="slgf_image_url1[]" class="rpg_label_text"  value="<?php echo $image1[0]; ?>"  readonly="readonly" style="display:none;" />
			<input type="text" id="slgf_image_url2[]" name="slgf_image_url2[]" class="rpg_label_text"  value="<?php echo $image2[0]; ?>"  readonly="readonly" style="display:none;" />
			<input type="text" id="slgf_image_url3[]" name="slgf_image_url3[]" class="rpg_label_text"  value="<?php echo $image3[0]; ?>"  readonly="readonly" style="display:none;" />
			<input type="text" id="slgf_image_url4[]" name="slgf_image_url4[]" class="rpg_label_text"  value="<?php echo $image4[0]; ?>"  readonly="readonly" style="display:none;" />
		</li>
        <?php
    }

	public function ajax_get_thumbnail_slgf() {
        echo $this->admin_thumb($_POST['imageid']);
        die;
    }

	public function slgf_add_image_meta_box_save($PostID) {
		if(isset($PostID) && isset($_POST['slgf_image_url'])) {
			$TotalImages = count($_POST['slgf_image_url']);
			$ImagesArray = array();
			if($TotalImages) {
				for($i=0; $i < $TotalImages; $i++) {
					$image_label = stripslashes($_POST['slgf_image_label'][$i]);
					$url = sanitize_text_field($_POST['slgf_image_url'][$i]);
					$url1 = sanitize_text_field($_POST['slgf_image_url1'][$i]);
					$url2 = sanitize_text_field($_POST['slgf_image_url2'][$i]);
					$url3 = sanitize_text_field($_POST['slgf_image_url3'][$i]);
					$url4 = sanitize_text_field($_POST['slgf_image_url4'][$i]);

					$ImagesArray[] = array(
						'slgf_image_label' => $image_label,
						'slgf_image_url' => $url,
						'slgf_12_thumb' => $url1,
						'slgf_346_thumb' => $url2,
						'slgf_12_same_size_thumb' => $url3,
						'slgf_346_same_size_thumb' => $url4
					);
				}
				update_post_meta($PostID, 'slgf_all_photos_details', serialize($ImagesArray));
				update_post_meta($PostID, 'slgf_total_images_count', $TotalImages);
			} else {
				$TotalImages = 0;
				update_post_meta($PostID, 'slgf_total_images_count', $TotalImages);
				$ImagesArray = array();
				update_post_meta($PostID, 'slgf_all_photos_details', serialize($ImagesArray));
			}
		}
		//die;
    }

	//save settings meta box values
	public function slgf_settings_meta_save($PostID) {
		if(isset($PostID) && isset($_POST['slgf_save_action'])) {
			$SLGF_Show_Gallery_Title  = sanitize_text_field($_POST['wl-show-gallery-title']);
			$SLGF_Show_Image_Label    = sanitize_text_field($_POST['wl-show-image-label']);
			$SLGF_Hover_Animation     = sanitize_text_field($_POST['wl-hover-animation']);
			$SLGF_Gallery_Layout      = sanitize_text_field($_POST['wl-gallery-layout']);
			$SLGF_Thumbnail_Layout    = sanitize_text_field($_POST['wl-thumbnail-layout']);
			$SLGF_Hover_Color         = sanitize_text_field($_POST['wl-hover-color']);
			$SLGF_Text_BG_Color       = sanitize_text_field($_POST['wl-text-bg-color']);
			$SLGF_Text_Color          = sanitize_text_field($_POST['wl-text-color']);
			$SLGF_Hover_Color_Opacity = sanitize_text_field($_POST['wl-hover-color-opacity']);
			$SLGF_Font_Style          = sanitize_text_field($_POST['wl-font-style']);
			$SLGF_Box_Shadow          = sanitize_text_field($_POST['wl-box-Shadow']);
			$SLGF_Custom_CSS          = sanitize_text_field($_POST['wl-custom-css']);

			$SLGF_DefaultSettingsArray = serialize( array(
				'SLGF_Show_Gallery_Title' => $SLGF_Show_Gallery_Title,
				'SLGF_Show_Image_Label'   => $SLGF_Show_Image_Label,
				'SLGF_Hover_Animation'    => $SLGF_Hover_Animation,
				'SLGF_Gallery_Layout'     => $SLGF_Gallery_Layout,
				'SLGF_Thumbnail_Layout'   => $SLGF_Thumbnail_Layout,
				'SLGF_Hover_Color'        => $SLGF_Hover_Color,
				'SLGF_Text_BG_Color'      => $SLGF_Text_BG_Color,
				'SLGF_Text_Color'         => $SLGF_Text_Color,
				'SLGF_Hover_Color_Opacity'=> $SLGF_Hover_Color_Opacity,
				'SLGF_Font_Style'         => $SLGF_Font_Style,
				'SLGF_Box_Shadow'         => $SLGF_Box_Shadow,
				'SLGF_Custom_CSS'         => $SLGF_Custom_CSS
			));

			$SLGF_Gallery_Settings = "SLGF_Gallery_Settings_".$PostID;
			update_post_meta($PostID, $SLGF_Gallery_Settings, $SLGF_DefaultSettingsArray);
		}
	}
}

/**
 * Initialize Class with Object
 */
$Photoswip_ = new psg_Photoswip_();

/**
 * Lightbox Slider Short Code [Photoswip_]
 */
require_once("simple-lightbox-slider-shortcode.php");

/**
 * Hex Color code to RGB Color Code converter function
 */
if(!function_exists('SLGF_RPGhex2rgb')) {
    function SLGF_RPGhex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       return $rgb; // returns an array with the rgb values
    }
}

add_action('media_buttons_context', 'add_slgf_custom_button');
add_action('admin_footer', 'add_slgf_inline_popup_content');

function add_slgf_custom_button($context) {
	//$img = plugins_url( '/images/Photos-icon.png' , __FILE__ );
	$container_id = 'Photoswip_';
	$title = 'Photoswip Gallery';
	$context .= '<a class="button button-primary thickbox" title="Photoswip Gallery to insert into post" href="#TB_inline?width=400&inlineId='.$container_id.'">
	<span class="wp-media-buttons-icon" style="background: url('.$img.'); background-repeat: no-repeat; background-position: left bottom;"></span>
	Photoswip Gallery Shortcode</a>';
	register_setting( 'my_options_group', 'my_photoswip_gallery', 'intval' );
	$posttype = get_post_type();
	$settings = esc_attr( get_option( 'my-setting_two' ) );
	if($settings=='yes'){
		if($posttype=='page'){
			?>
			<h2>Remove script and Css From Header</h2>
			<select name="my_photoswip_gallery">
			 <option value="">Select</option>
			  <option  <?php if($settings == "yes") echo 'selected="selected"'; ?> value="yes">Yes</option>
			  <option  <?php if($settings == "no") echo 'selected="selected"'; ?> value="no">No</option>

			</select>

			<?php
		}
	}
  return $context;
}
add_action( 'admin_init', 'add_slgf_custom_button' );
function add_slgf_inline_popup_content() { ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#slgfgalleryinsert').on('click', function() {
			var id = jQuery('#slgf-gallery-select option:selected').val();
			window.send_to_editor('<p>[Photoswip_ id=' + id + ']</p>');
			tb_remove();
		})
	});
	</script>

	<div id="Photoswip_" style="display:none;">
		<h3>Select Photoswip Gallery to insert into post</h3>
		<?php
		$all_posts = wp_count_posts( 'slgf_slider')->publish;
		$args = array('post_type' => 'slgf_slider', 'posts_per_page' =>$all_posts);
		global $rpg_galleries;
		$rpg_galleries = new WP_Query( $args );
		if( $rpg_galleries->have_posts() ) { ?>
			<select id="slgf-gallery-select">
			<?php
			while ( $rpg_galleries->have_posts() ) : $rpg_galleries->the_post(); ?>
				<option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
			<?php
			endwhile;
			?>
			</select>
			<button class='button primary' id='slgfgalleryinsert'>Insert Gallery Shortcode</button>
			<?php
		} else {
			_e("No Gallery Found", WEBLIZAR_SLGF_TEXT_DOMAIN);
		}
		?>
	</div>
	<?php
}
include_once( $dir . 'widgets/widget.php' );
include_once( $dir . 'photoswip_admin_setting.php' );
?>
