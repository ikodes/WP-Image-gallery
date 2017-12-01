<?php
    /**
     * Load Saved Lightbox
     */
	$PostId = $post->ID;
	$SLGF_Gallery_Settings = "SLGF_Gallery_Settings_".$PostId;
	$SLGF_Settings = unserialize(get_post_meta( $PostId, $SLGF_Gallery_Settings, true));
    if($SLGF_Settings['SLGF_Hover_Animation'] && $SLGF_Settings['SLGF_Gallery_Layout']) {

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
    } else {
		$SLGF_Show_Gallery_Title  = "yes";
		$SLGF_Show_Image_Label    = "yes";
        $SLGF_Hover_Animation     = "stripe";
        $SLGF_Gallery_Layout      = "col-md-6";
		$SLGF_Thumbnail_Layout    = "same-size";
        $SLGF_Hover_Color         = "#0AC2D2";
		$SLGF_Text_BG_Color       = "#FFFFFF";
		$SLGF_Text_Color          = "#000000";
        $SLGF_Hover_Color_Opacity = "yes";
        $SLGF_Font_Style          = "font-name";
		$SLGF_Box_Shadow          = "yes";
		$SLGF_Custom_CSS          = "";
    }
?>
<script>
jQuery(document).ready(function(){
	slgf_icon_settings();
});

function slgf_icon_settings() {
	if (jQuery('#wl-view-lightbox').is(":checked")) {
	  jQuery('.slgf-icon-settings').show();
	} else {
		jQuery('.slgf-icon-settings').hide();
	}
}
</script>

    <input type="hidden" id="slgf_save_action" name="slgf_save_action" value="slgf-save-settings">
    <table class="form-table">
        <tbody>
		<?php /*
			<tr>
				<th scope="row"><label><?php _e("Show Gallery Title", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
				<td>
					<?php if($SLGF_Show_Gallery_Title == "") $SLGF_Show_Gallery_Title = "yes"; ?>
					<input type="radio" name="wl-show-gallery-title" id="wl-show-gallery-title" value="yes" <?php if($SLGF_Show_Gallery_Title == 'yes' ) { echo "checked"; } ?>> <i class="fa fa-check fa-2x"></i>
					<input type="radio" name="wl-show-gallery-title" id="wl-show-gallery-title" value="no" <?php if($SLGF_Show_Gallery_Title == 'no' ) { echo "checked"; } ?>> <i class="fa fa-times fa-2x"></i>
					<p class="description"><?php _e("Select Yes/No option to hide or show gallery title", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>. </p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label><?php _e("Show Image Label", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
				<td>
					<?php if($SLGF_Show_Image_Label == "") $SLGF_Show_Image_Label = "yes"; ?>
					<input type="radio" name="wl-show-image-label" id="wl-show-image-label" value="yes" <?php if($SLGF_Show_Image_Label == 'yes' ) { echo "checked"; } ?>> <i class="fa fa-check fa-2x"></i>
					<input type="radio" name="wl-show-image-label" id="wl-show-image-label" value="no" <?php if($SLGF_Show_Image_Label == 'no' ) { echo "checked"; } ?>> <i class="fa fa-times fa-2x"></i>
					<p class="description"><?php _e("Select Yes/No option to hide or show label on image", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.</p>
				</td>
			</tr>
		*/ ?>
            <tr>
                <th scope="row"><label><?php _e("Image Hover Animation", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
                <td>
					<?php if($SLGF_Hover_Animation == "") $SLGF_Hover_Animation = "fade"; ?>
                    <select name="wl-hover-animation" id="wl-hover-animation">
                        <optgroup label="Select Animation">
                            <option value="stroke" <?php if($SLGF_Hover_Animation == 'stroke') echo "selected=selected"; ?>>Stroke</option>
                        </optgroup>
                    </select>
                    <p class="description"><?php _e("Choose an animation effect apply on images after mouse hover.", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php _e("Gallery Layout", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
                <td>
					<?php if($SLGF_Gallery_Layout == "") $SLGF_Gallery_Layout = "col-md-6"; ?>
                    <select name="wl-gallery-layout" id="wl-gallery-layout">
                        <optgroup label="Select Gallery Layout">
                            <option value="col-md-6" <?php if($SLGF_Gallery_Layout == 'col-md-6') echo "selected=selected"; ?>><?php _e("Style two", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                            <option value="col-md-4" <?php if($SLGF_Gallery_Layout == 'col-md-4') echo "selected=selected"; ?>><?php _e("Style three", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                             <option value="col-md-3" <?php if($SLGF_Gallery_Layout == 'col-md-3') echo "selected=selected"; ?>><?php _e("Style four", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></option>
                        </optgroup>
                    </select>
                    <p class="description"><?php _e("Choose a column layout for image gallery", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
                </td>
            </tr>



		 <tr>
				<th scope="row"><label><?php _e("Hover Effects", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
				<td>
					<?php if($SLGF_Hover_Color == "") $SLGF_Hover_Color = "#0AC2D2"; ?>
					<input type="radio" name="wl-hover-color" id="wl-hover-color" value="milo" <?php if($SLGF_Hover_Color == 'milo' ) { echo "checked"; } ?>><label style="color:#0AC2D2;">Milo</label>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="wl-hover-color" id="wl-hover-color" value="honey" <?php if($SLGF_Hover_Color == 'honey' ) { echo "checked"; } ?>><label style="color:#000000;">Honey</label>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="wl-hover-color" id="wl-hover-color" value="selena" <?php if($SLGF_Hover_Color == 'selena') { echo "checked"; } ?>><label style="color:#dd4242;">Selena</label>
					<p class="description"><?php _e("Select Effects", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label><?php _e("Text Background Color", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
				<td>
					<?php if($SLGF_Text_BG_Color == "") $SLGF_Text_BG_Color = "#FFFFFF"; ?>
					<input type="radio" name="wl-text-bg-color" id="wl-text-bg-color" value="#FFFFFF" <?php if($SLGF_Text_BG_Color == '#FFFFFF' ) { echo "checked"; } ?>><label>White</label>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="wl-text-bg-color" id="wl-text-bg-color" value="#000000" <?php if($SLGF_Text_BG_Color == '#000000' ) { echo "checked"; } ?>><label>Black</label>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="wl-text-bg-color" id="wl-text-bg-color" value="#dd4242" <?php if($SLGF_Text_BG_Color == '#dd4242' ) { echo "checked"; } ?>><label>Red</label>
					<p class="description"><?php _e("Select Text Background Color", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.  </p>
				</td>
			</tr>



            <tr>
				<th scope="row"><label><?php _e("ON/OFF", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>

				<td>
					<?php if(!isset($SLGF_Hover_Color_Opacity)) $SLGF_Hover_Color_Opacity = "yes"; ?>
					<input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity" value="yes" <?php if($SLGF_Hover_Color_Opacity == 'yes' ) { echo "checked"; } ?>> <i class="fa fa-check fa-2x"></i>
					<input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity" value="no" <?php if($SLGF_Hover_Color_Opacity == 'no' ) { echo "checked"; } ?>> <i class="fa fa-times fa-2x"></i>
					<p class="description"><?php _e("Select Yes/No for enable disable gallery", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.</p>
				</td>
			</tr>



			<tr>
				<th scope="row"><label><?php _e("Image Box Shadow", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?></label></th>
				<td>
					<?php if($SLGF_Box_Shadow == "") $SLGF_Box_Shadow = "yes"; ?>
					<input type="radio" name="wl-box-Shadow" id="wl-box-Shadow" value="yes" <?php if($SLGF_Box_Shadow == 'yes' ) { echo "checked"; } ?>>  <i class="fa fa-check fa-2x"></i>
					<input type="radio" name="wl-box-Shadow" id="wl-box-Shadow" value="no" <?php if($SLGF_Box_Shadow == 'no' ) { echo "checked"; } ?>> <i class="fa fa-times fa-2x"></i>
					<p class="description"><?php _e("Select Yes/No option to hide or show Image Box Shadow", WEBLIZAR_SLGF_TEXT_DOMAIN ); ?>.</p>
				</td>
			</tr>




        </tbody>
    </table>

<?php
wp_enqueue_style('wl-slgf-font-awesome-4', WEBLIZAR_SLGF_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');
