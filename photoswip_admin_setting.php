<?php

add_action( 'admin_menu', 'psg_admin_menu' );
function psg_admin_menu() {
    add_submenu_page('edit.php?post_type=slgf_slider', 'Setting', 'Setting', 'manage_options', 'my-plugin', 'psg_photoshwip_gallery_option' );

}

add_action( 'admin_init', 'psg_admin_init' );
function psg_admin_init() {
    register_setting( 'my-settings-group', 'my-setting' );
     register_setting( 'my-settings-group', 'my-setting_two' );
     register_setting( 'my-settings-group', 'my-setting_three' );
}

function psg_field_one_callback() {
    $setting = esc_attr( get_option( 'my-setting' ) );
    echo "<input type='text' name='my-setting' value='$setting' />";
}

function psg_field_two_callback() {
    $settings = esc_attr( get_option( 'my-setting_two' ) );


    ?>
    <select name="my-setting_two" values="<?php  $sttng = $settings; ?>">
      <option value="0">Select</option>
      <option value="yes" <?php if($sttng =="yes") echo 'selected="selected"'; ?>>Yes</option>
      <option value="no" <?php if($sttng =="no") echo 'selected="selected"'; ?>>No</option>

    </select>
    <p>Enable css/js function in pahe section</p>
    <?php
}

 function psg_photoshwip_gallery_option() {
    ?>
     <div class='card pressthis'>
        <div class="wrap">
            <h2>Photoshwip Gallery Option</h2>
            <form action="options.php" method="POST">
                <?php settings_fields( 'my-settings-group' ); ?>
                <?php do_settings_sections( 'my-plugin' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
    <?php
}
function psg_field_three_callback(){

?>
<?php echo $setting_three = esc_attr( get_option( 'my-setting_three' ) ); ?>
<select name="my-setting_three" values="<?php $setting_three; ?>">
<?php
global $post;

$args = array( 'numberposts' => -1);
$posts = get_pages($args);
foreach( $posts as $post ) : setup_postdata($post); ?>
<?php the_title(); ?>
        <option value="<?php echo $post->ID; ?>" <?php if($post->ID == $setting_three) echo 'selected="selected"'; ?>><?php the_title(); ?></option>
<?php endforeach; ?>
</select>
 <?php

  }


function slgf_js_css_load_function_single_page() {

    echo $setting_three = esc_attr( get_option( 'my-setting_three' ) );

    if(is_page($setting_three)){

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

}
}
/** For the_title function **/
add_action( 'wp_footer', 'slgf_js_css_load_function_single_page' );


?>
