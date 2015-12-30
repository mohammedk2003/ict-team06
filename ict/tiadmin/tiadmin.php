<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }



if (!class_exists('TiAdminPanel')){
	class TiAdminPanel{
	//--------Making sure we are a static class-----------	
		private static $instance = NULL;
		public function __construct(){
		}
		public function __destruct(){
		}
		public function __clone(){
		}
		static function getInstance(){
			if (self::$instance == NULL){
			 	self::$instance = new TiAdminPanel();
			 }
			 return self::$instance;
		}
	//----Implementation-------
		//-----Setting Defaults-----------------
		private static $themeName = "MyTheme";
		private static $actions = array();	
		private static $shortcodes = array();
		private static $jscripts = array();
		private static $adminTabs = array();
		private static $themeprefix = "mytheme";
		private static $colorSchemes = array();
		private static $patterns = array();
		//----Getters & Setters-----------------	
		public static function SetThemeName($name){
			TiAdminPanel::$themeName = $name;
		}
		public static function GetThemeName(){
			return TiAdminPanel::$themeName;
		}
		public static function SetThemePrefix($name){
			TiAdminPanel::$themeprefix = $name;
		}
		public static function GetThemePrefix(){
			return TiAdminPanel::$themeprefix;
		}
		//------Helper functions-----------------
		public static function AddAction($tag, $callback){
			array_push(TiAdminPanel::$actions, array($tag , $callback));
		}
		public static function AddScript($script_id, $script_url){
			array_push(TiAdminPanel::$jscripts, array($script_id, $script_url));
		}
		public static function AddShortCode($code, $callback){
			array_push(TiAdminPanel::$shortcodes, array($code , $callback));			
		}
		public static function AddAlert($type, $message){
			add_settings_error(TiAdminPanel::GetThemePrefix().'alert','id_'.TiAdminPanel::GetThemePrefix(), $message, $type);
		}
		public static function GetThemeOptions(){
			settings_fields(TiAdminPanel::GetThemePrefix() );
		}
		public static function CheckColorField($input){
			
			/*if ($input != 'Hello'){
					TiAdminPanel::AddAlert('error', 'Invalid input format');				
				return get_option('color_scheme');
			}else{
				
				return $input;
			}*/
			
			return $input;
                
					
		}
		public static function SetThemeOptions(){
			
			
			function lookshop_validate_email($input){
				$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
				if (preg_match($regexp, $input)) {
					    return $input;
					} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid e-mail address');
					   return get_option('cgemail');
					   
				}
			}
			
			function validate_phone($input){
				$regexp = "/[0-9\+\-]/";
				if (preg_match($regexp, $input)) {
					    return $input;
				} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid fax number');
					   return get_option('cphone');
				}
			}
			
			function validate_fax($input){
				$regexp = "/[0-9\+\-]/";
				if (preg_match($regexp, $input)) {
					    return $input;
					} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid phone number');
					   return get_option('cfax');
					   
				}
			}
			
			register_setting( TiAdminPanel::GetThemePrefix(), 'color_scheme');
			register_setting( TiAdminPanel::GetThemePrefix(), 'ganalytics' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'caddress' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cphone' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cfax' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cgemail' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'logo_image' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'favicon_ico' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'words_trim_grid' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'show_desc' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'default_view' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'prod_sidebar' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'list_sidebar' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'prod_options' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'checkout_im_width' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'checkout_im_height' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'isotope_blog' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'prod_moreinfo' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'pattern' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'boxed' );
			
		}
		
		public static function GetColorScheme(){
		
			foreach(TiAdminPanel::$colorSchemes as $scheme){
			
				if (get_option('color_scheme') == $scheme['id']) return $scheme['css'];  
				
			}
		
		}
		
		public static function GetPattern(){
		
			foreach(TiAdminPanel::$patterns as $pt){
			
				if (get_option('pattern') == $pt['id']) return $pt['css'];  
				
			}
		
		}
		
		public static function RegisterScripts(){
			foreach(TiAdminPanel::$jscripts as $script){
			 	wp_deregister_script($script[0]);
				wp_register_script($script[0], get_template_directory_uri().'/js/'.$script[1]);
				wp_enqueue_script($script[0]);
			}
		} 
		
		public static function RegisterActions(){
			foreach(TiAdminPanel::$actions as $action){
				add_action($action[0], $action[1]);
			}
		}
		public static function RegisterShortcodes(){
			foreach(TiAdminPanel::$shortcodes as $shortcode){
				add_shortcode($shortcode[0], $shortcode[1]);
			}
		}
		// --- Runtime alert------------
		public static function AlertNow($type, $message){
			switch($type){
					case "success": 
						$output .= '<div class="success"><div class="success_icon"></div>'.$message.'</div>'; 
						break;
					case "warning": 
						$output .= '<div class="warning"><div class="warning_icon"></div>'.$message.'</div>';
						break;
					case "error":
						 $output .= '<div class="error"><div class="error_icon"></div>'.$message.'</div>';
						 break;
						case "info": $output .= '<div class="info"><div class="info_icon"></div>'.$message.'</div>';
						break;
				}
				echo $output;
		}
		
		//----------The Actual Work is done here ------------------------
		
	
		
		//----------Registering color schemes----------------------------
		
		public static function RegisterColor($id, $color_icon, $color_name, $color_css){
			array_push(TiAdminPanel::$colorSchemes, array('id'=>$id,'icon'=>$color_icon, 'name'=>$color_name, 'css'=>$color_css));
		}
		
		public static function RegisterPattern($id, $icon, $name, $css){
			array_push(TiAdminPanel::$patterns, array('id'=>$id,'icon'=>$icon, 'name'=>$name, 'css'=>$css));
		}
		
		//-----creating top level menu----------
		public static function TiBuildAdminMenu(){
		
			$html = '<div id="tabs">
						<ul>';
			
			$i = 0;
			
			foreach(TiAdminPanel::$adminTabs as $tab){
				$i++;
				$html .= '<li><a href="#tabs-'.$i.'"><span>'.$tab[0].'</span></a></li>';
			}
			
			$html .= '</ul>';
			$i = 0;
			foreach(TiAdminPanel::$adminTabs as $tab){
				$i++;
				$html .= '<div id="tabs-'.$i.'">'.$tab[1].'</div>';
			}
			
			$html .= '</div>';
			
			return $html;
		}
		
		public static function AddStyles(){
				if ( !is_admin() ) { 
					$styles = TiAdminPanel::GetColorScheme();
					if ($styles != '') wp_enqueue_style('color', $styles);
				}
		}
		
		public static function TiAddAdminScripts(){
			if ( is_admin() ) { 
				
				wp_enqueue_script('jquery');
				wp_enqueue_script('media-upload');
       			wp_enqueue_script('thickbox');
				wp_enqueue_style('tiadminstyle', get_template_directory_uri() . '/tiadmin/admin.css');
			   	wp_enqueue_script('jquery-ui-tabs');
			   	wp_enqueue_script('tiadmin',get_template_directory_uri() . '/tiadmin/tiadmin.js',array('jquery'));
			   
			}
		}
		
		public static function TiAddAdminSection($heading, $content){
			array_push(TiAdminPanel::$adminTabs, array($heading, $content));
		}
		
		public static function TiTopLevelMenu(){
			add_theme_page(TiAdminPanel::GetThemeName().' Options', TiAdminPanel::GetThemeName().' settings', 'manage_options', TiAdminPanel::GetThemePrefix(), 'TiAdminPanel::TiThemeOptions');
			add_action( 'admin_init', 'TiAdminPanel::SetThemeOptions' );

		}
		

		public static function ContactsMapAddressWidget(){
			
			$html = '<h4>Fill out the form below to enable Contacts Widget on contact page</h4>';
			$html .= '<div class="wrapper">';
			$html .= '<p><label for="caddress">Address:</label>&nbsp;<input type="text" id="caddress" name="caddress" value="'.get_option('caddress').'"/></p>';
			$html .= '<p><label for="cphone">Phone:</label>&nbsp;<input type="text" id="cphone" name="cphone" value="'.get_option('cphone').'"/></p>';
			$html .= '<p><label for="cfax">Fax:</label>&nbsp;<input type="text" id="cfax" name="cfax" value="'.get_option('cfax').'"/></p>';
			$html .= '<p><label for="cgemail">E-mail:</label>&nbsp;<input type="text" id="cgemail" name="cgemail" value="'.get_option('cgemail').'"/></p>';
			$html .= '</div>';
			return $html;	
		
		}
		
		
		public static function HomePageTab(){
		
			$html = '<h4>Home page settings</h4>';
			$html .= '<p></p>';
			
			return $html;
		}
		
		public static function GoogleAnalyticsTab(){
		
			$html = '<h4>Paste your web property ID into the text field below to activate your Google Analytics Tracking snippet</h4>';
			$html .= '<p><label for="ganalytics">Analytics Code:</label>&nbsp;<input type="text" id="analytics" name="ganalytics" value="'.get_option('ganalytics').'"></p>';
			
			return $html;
		}
		
		public static function ColorSchemesTab(){
		
			
		
			$html = '';
			
			$html .= '<h4>Please choose color scheme for your theme</h4>';
			$html .= '<p>You may pick from one of the following color schemes</p>';
			
		
			//$html .= '<ul id="color-schemes">';
		
			$html .= '<table class="colorscheme">';
			
			foreach(TiAdminPanel::$colorSchemes as $scheme){
				
				if (get_option('color_scheme') == $scheme['id']) $checked = 'checked'; else $checked = '';
				
				//$html .= '<li><img src='.$scheme['icon'].' alt="'.$scheme['name'].'"/> <input type="radio" name="color_scheme" value="'.$scheme['id'].'" '.$checked.' ></li>';
				$html .= '<tr><td><div style=" width:40px; height:40px; background-color:'.$scheme['icon'].';"></td><td>'.$scheme['name'].'</td>'.'<td><input type="radio" name="color_scheme" value="'.$scheme['id'].'" '.$checked.' ></td></tr>';
				
			}
			
			//$html .= '</ul>';
							
			$html .= '</table>';
			
			
			
			return $html;
		
		}
		
		public static function PatternsTab(){
		
			
		
			$html = '';
			
			$html .= '<h4>Please choose one of the patterns for your theme</h4>';
						
		
			//$html .= '<ul id="color-schemes">';
		
			$html .= '<table class="patterns">';
			
			foreach(TiAdminPanel::$patterns as $pt){
				
				if (get_option('pattern') == $pt['id']) $checked = 'checked'; else $checked = '';
				
				//$html .= '<li><img src='.$scheme['icon'].' alt="'.$scheme['name'].'"/> <input type="radio" name="color_scheme" value="'.$scheme['id'].'" '.$checked.' ></li>';
				$html .= '<tr><td><div style=" width:40px; height:40px; background: url('.$pt['icon'].');"></td><td>'.$pt['name'].'</td>'.'<td><input type="radio" name="pattern" value="'.$pt['id'].'" '.$checked.' ></td></tr>';
				
			}
			
			//$html .= '</ul>';
							
			$html .= '</table>';
			
			
			
			return $html;
		
		}

		public static function lookshopLogo(){
			
		
			$html = '';	
			
			$html .= '<h4>'.__('Upload your logo', 'lookshop').'</h4>';
			$html .= '<p>'.__('You may also upload a Favicon', 'lookshop').'</p>';

			$html .= '<input type="text" id="lookshop_logo" name="logo_image" value="'.get_option('logo_image').'">';
			$html .= '<a href="#" id="upload_lookshop_logo" class="button upload_lookshop_logo">'.__('Upload Logo', 'lookshop').'</a><br/>';
			$html .= '<input type="text" id="lookshop_favicon" name="favicon_ico" value="'.get_option('favicon_ico').'">';
			$html .= '<a href="#" id="upload_lookshop_favicon" class="button upload_lookshop_favicon">'.__('Upload Favicon', 'lookshop').'</a>';
			
			$html .= '
				<script>
					jQuery(document).ready(function($){
						var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
						
						$("#upload_lookshop_logo, #upload_lookshop_favicon").click(function(e){
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = $(this);
							var id = button.attr("id").replace("upload_", "");
							
							_custom_media = true;
							
							wp.media.editor.send.attachment = function(props, attachment){
								if (_custom_media) {
									$("#"+id).val(attachment.url);
								} else {
									return _orig_send_attachment.apply(this, [props, attachment]);
								}
							}
							
							wp.media.editor.open(button);
							return false;	
							
						});
						
						$(".add_media").on("click", function(){
							_custom_media = false;
						});
					
					});
				</script>
			
			';
			
			
			
			
			return $html;
		
		}


		public static function lookshopListing(){
		
			
		
			$html = '';	
		
			$html .= '<h4>'.__('Theme Specific Layout Settings', 'lookshop').'</h4>';
			$html .= '<p>'.__('Here you can adjust different theme specific settings', 'lookshop').'</p>';

			$html .= '<p><label>'.__('Show product description:', 'lookshop').'</label>
			<input id="show_desc" type="checkbox" size="6" name="show_desc" '.(get_option('show_desc') == 'on' ? 'checked="checked"' : '' ).' /></p>';

			$html .= '<p><label>'.__('Set a number of characters in product description on Prodouct Listing:', 'lookshop').'</label>
			<input id="words_trim_grid" type="text" size="6" name="words_trim_grid" value="'.get_option('words_trim_grid').'"  /></p>';

			$html .= '<p><label>'.__('Defulat product listing view:', 'lookshop').'</label>
				<br/><input type="radio" name="default_view" value="grid" '.(get_option('default_view') == 'grid' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Grid', 'lookshop').'
				<br/><input type="radio" name="default_view" value="list" '.(get_option('default_view') == 'list' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('List', 'lookshop').'
			</p>';

			$html .= '<p><label>'.__('Sidebar on Products Listing Page:', 'lookshop').'</label>
				<br/><input type="radio" name="list_sidebar" value="left" '.(get_option('list_sidebar') == 'left' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Left', 'lookshop').'
				<br/><input type="radio" name="list_sidebar" value="right" '.(get_option('list_sidebar') == 'right' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Right', 'lookshop').'
				<br/><input type="radio" name="list_sidebar" value="off" '.(get_option('list_sidebar') == 'off' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Off', 'lookshop').'
			</p>';

			$html .= '<p><label>'.__('Sidebar on Single Product Page:', 'lookshop').'</label>
				<br/>&nbsp;<input type="radio" name="prod_sidebar" value="left" '.(get_option('prod_sidebar') == 'left' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Left', 'lookshop').'
				<br/>&nbsp;<input type="radio" name="prod_sidebar" value="right" '.(get_option('prod_sidebar') == 'right' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Right', 'lookshop').'
				<br/>&nbsp;<input type="radio" name="prod_sidebar" value="off" '.(get_option('prod_sidebar') == 'off' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Off', 'lookshop').'
			</p>';

			$html .= '<p><label>'.__('Show product options on product listing page:', 'lookshop').'</label>
				<br/>&nbsp;<input type="radio" name="prod_options" value="no" '.(get_option('prod_options') == 'no' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('No', 'lookshop').'
				<br/>&nbsp;<input type="radio" name="prod_options" value="yes" '.(get_option('prod_options') == 'yes' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Yes', 'lookshop').'
			</p>';
			
			$html .= '<p><label>'.__('Show "More Information" on Product Listing:', 'lookshop').'</label>
				<br/>&nbsp;<input type="radio" name="prod_moreinfo" value="no" '.(get_option('prod_moreinfo') == 'no' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('No', 'lookshop').'
				<br/>&nbsp;<input type="radio" name="prod_moreinfo" value="yes" '.(get_option('prod_moreinfo') == 'yes' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Yes', 'lookshop').'
			</p>';

			$html .= '<p><label>'.__('Checkout page product image:', 'lookshop').'</label><br/>
				'.__('Width:  &nbsp;', 'lookshop').'<input id="checkout_im_width" type="text" size="6" name="checkout_im_width" value="'.get_option('checkout_im_width').'"  />
				<br/>'.__('Height: ', 'lookshop').'<input id="checkout_im_height" type="text" size="6" name="checkout_im_height" value="'.get_option('checkout_im_height').'"  />
				</p>';
			
			
			return $html;
		
		}
		
		
		public static function lookshopBlog(){
			$html = '';
			$html .= '<h4>'.__('Theme Specific Layout Settings', 'lookshop').'</h4>';
			$html .= '<p>'.__('Here you can adjust different theme specific settings', 'lookshop').'</p>';
			
			$html .= '<p><label>'.__('Use Pinterest Like layout as blog layout:', 'lookshop').'</label>
				<br/>&nbsp;<input type="radio" name="isotope_blog" value="no" '.(get_option('isotope_blog') == 'no' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('No', 'lookshop').'
				<br/>&nbsp;<input type="radio" name="isotope_blog" value="yes" '.(get_option('isotope_blog') == 'yes' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Yes', 'lookshop').'
			</p>';
			
			$html .= '<p><label>'.__('Use Boxed Layout ?', 'lookshop').'</label>';
			$html .= '<br/>&nbsp;<input type="radio" name="boxed" value="no" '.(get_option('boxed') == 'no' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('No', 'lookshop').'';
			$html .= '<br/>&nbsp;<input type="radio" name="boxed" value="yes" '.(get_option('boxed') == 'yes' ? 'checked="checked"' : '' ).'>&nbsp;&nbsp;'.__('Yes', 'lookshop').'</p>';
			return $html;
		}
		
		
		//-----building dasboard page----------
		public static function BuildDashboardPage(){
			
			function settitle(){
				$text = '<h2>'.TiAdminPanel::GetThemeName().__(' theme settings ').'</h2>';
				return $text;
			}
			echo '<div class="wrap"><div class="icon32" id="icon-themes"><br></div>';
			echo settitle();
			echo '</div>';
			echo settings_errors();
			echo '<form method="post" action="options.php">';
			?> <p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'lookshop'); ?>" />
			</p><?php

			TiAdminPanel::GetThemeOptions();
			TiAdminPanel::TiAddAdminSection(__('Color Schemes', 'lookshop'), TiAdminPanel::ColorSchemesTab());
			TiAdminPanel::TiAddAdminSection(__('Patterns', 'lookshop'), TiAdminPanel::PatternsTab());
			TiAdminPanel::TiAddAdminSection(__('Google Analytics','lookshop'), TiAdminPanel::GoogleAnalyticsTab());
			TiAdminPanel::TiAddAdminSection(__('Contacts Page', 'lookshop'), TiAdminPanel::ContactsMapAddressWidget());
			TiAdminPanel::TiAddAdminSection(__('Logo and Favicon', 'lookshop'), TiAdminPanel::lookshopLogo());
			TiAdminPanel::TiAddAdminSection(__('Product Listing Settings', 'lookshop'), TiAdminPanel::lookshopListing());
			TiAdminPanel::TiAddAdminSection(__('General Layout Settings', 'lookshop'), TiAdminPanel::lookshopBlog());
			
			
			echo TiAdminPanel::TiBuildAdminMenu();
			?> <p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'lookshop'); ?>" />
</p><?php
			echo '</form>';
			
		}
		//--------theme options handler-----------
		public static function TiThemeOptions(){
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.', 'lookshop') );
			}
			TiAdminPanel::BuildDashboardPage();
		}
		//----Container (shortcodes for content building)-----------------------
		
		public static function Wrapper($atts, $content = null){
			extract( shortcode_atts( array(
				), $atts ) );
				

				return '<div class="grid_'.$width.'">'.do_shortcode($content).'</div>';
		}
		
		public static function Container($atts, $content = null){
			extract( shortcode_atts( array(
					'width' => 1
				), $atts ) );
				$first = '';
				$last = '';
				if(in_array('first', $atts)) $first = 'alpha';
				if(in_array('last', $atts)) $last = 'omega';
				
			return '<div class="grid_'.$width.' '.$first.' '.$last.' ">'.do_shortcode($content).'</div>';
					
		}
		
		public static function Title($atts, $content = null){
			extract( shortcode_atts( array(
					'size' => 'medium'
				), $atts ) );
				
				return '<h2>'.$content.'</h2>';
				
		}
		
		public static function Contacts($atts){
			extract(shortcode_atts( array(
					'size' => 'medium'
				), $atts ));

			$html = '';
			$html .= '<ul class="contacts">';
			$html .= '<li class="phone">'.get_option('cphone').'</li>';
			$html .= '<li class="location">'.get_option('caddress').'</li>';	
			$html .= '<li class="mail">'.get_option('cgemail').'</li>';
			$html .= '</ul>'; 

			return $html;

		}

		public static function Accordion($atts, $content = null){
			
			$html = '<div id="accordion">'.do_shortcode($content).'</div>';
			$html .= '<script>
    jQuery(function() {
        jQuery( "#accordion" ).accordion( { clearStyle: true });
    });
    </script>';

			return $html;
		}

		public static function Section($atts, $content = null){

			$html = '<h3>'.$atts['title'].'</h3><div><p>';
			$html .= $content;
			$html .= '</p></div>';


			return $html;
		}

		

		public static function Elast($atts, $content = null){
			
			$id = uniqid();
			$html = '';
			$html .= '<ul id="carousel_'.$id.'" class="elastislide-list">';
			$html .= do_shortcode($content);
			$html .= '</ul>';
			$html .= '<script type="text/javascript">
				jQuery(window).load(function() { jQuery(\'#carousel_'.$id.' li a img\').hoverizr({effect:"greyscale"}); });
				jQuery( \'#carousel_'.$id.'\' ).elastislide(); 
			</script>';

			return $html;

		}

		public static function Item($atts, $content = null){
		
			if (isset($atts['link'])) $link = $atts['link']; else $link = '#';
			if (isset($atts['title'])) $title = $atts['title']; else $title = '';
			if (isset($atts['image'])) $image = $atts['image']; else $image = '/';
			
					
			$html = '<li>';
			$html .= '<a href="'.$link.'" title="'.$title.'" >';
			$html .= '<img src="'.$image.'" alt="'.$title.'" class="elast_img" />';
			if ($content) $html .= $content;
			$html .= '</a></li>';
			return $html;
		}


	
		
		//----Buttons ShortCodes---------------
		
		
		//----GMap-----------------------------
		
		public static function GMap($atts){
		
			function toHTMLGMap(){
				$html = '
			
				<div id="map">
					<div id="map_canvas">
						
					</div>
				</div>
				<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    	<script>
    		try { lookshopTheme.googleMapsContacts(\''.get_option('caddress') .'\', \'map_canvas\'); } catch(error){}
		</script>';
				
				return $html;
			}
			
			extract( shortcode_atts( array(
					'address' => '',
				), $atts ) );
				
			
			return toHTMLGMap();
		
		}
		
		//----Source Code----------------------
		
		public static function SourceCode($atts, $content = null){
			

			
				$out = '<script src="'.get_template_directory_uri().'/js/highlight/highlight.pack.js"></script>';
				
				$out .= '<link rel="stylesheet" title="" href="'.get_template_directory_uri().'/js/highlight/styles/github.css">';
				$out .= ''.$content.'';
				
				
			
			extract( shortcode_atts(array('code' => ''), $atts ) );
			
			
			return $out;
 			
		}
				
		
		
		
		//----lookshop Slider Short Code----------
		public static function FancyTransitions($atts){
		
			function toHTMLfancy($gal, $width, $height, $effect, $strips, $delay, $stripDelay, $titleOpacity, $titleSpeed, $position, $direction, $navigation, $links){
				global $nggdb;
				$html = '
					
					<div id=\'slideshowHolder\'>


				';
								$elid = 0;	
				foreach($gal as $item){
					$elid++;
					 $picture = nggdb::find_image($item->pid);
					$html .=  '<img src='.$picture->imageURL.' alt="&lt;div class=\'ftDesc\' &gt;'.htmlentities(nggGallery::i18n($item->description)).'&lt;/div&gt;" />';
					if ($item->alttext) $html .= '<a href="'.$item->alttext.'"></a>'; 
					
				}
				
				$html .= '</div>
				
						<script>
							
								$(\'#slideshowHolder\').jqFancyTransitions({ 
									width: \''.$width.'\', 
									height: \''.$height.'\', 
									effect: \''.$effect.'\', // wave, zipper, curtain
									strips: '.$strips.', // number of strips
									delay: '.$delay.', // delay between images in ms
									stripDelay: '.$stripDelay.', // delay beetwen strips in ms
									titleOpacity: '.$titleOpacity.', // opacity of title
									titleSpeed: '.$titleSpeed.', // speed of title appereance in ms
									position: \''.$position.'\', // top, bottom, alternate, curtain
									direction: \''.$direction.'\', // left, right, alternate, random, fountain, fountainAlternate
									navigation: \''.$navigation.'\', // prev and next navigation buttons
									links: \''.$links.'\' // show images as links

								});
								
						</script>';
				return $html;
			}
			
			if (class_exists('nggLoader')){
				extract( shortcode_atts( array(
					'id' => 0,
					'width' => '940',
					'height' => '367',
					'effect' => 'wave',
					'strips' => '20',
					'delay' => '5000',
					'stripDelay' => '50',
					'titleOpacity' => '0.7',
					'titleSpeed' => '1000',
					'position' => 'alternate',
					'direction' => 'fountainAlternate',
					'navigation' => 'true',
					'links' => 'true'
					
				), $atts ) );
				$gallery = getGallery($id);
				return toHTMLfancy($gallery, $width, $height, $effect, $strips, $delay, $stripDelay, $titleOpacity, $titleSpeed, $position, $direction, $navigation, $links);
				
			//if there is no nextGenGallery tell to get one
			} else {  
				TiAdminPanel::AlertNow('error','NextGen Gallery plugin is not installed. I can not show you the gallery');
			}
			
		} 
		
		//-----Hood Audio Player---------------
		public static function AudioPlayer($atts){
			
			
			
			$html = '';
			
			foreach ($atts as $at){
				$id = rand();
				print_r($at);
				if (strstr($at, 'http://')) $html .= '<p id="audioplayer_'.$id.'">Alternative content</p><script type="text/javascript">AudioPlayer.embed("audioplayer_'.$id.'", {soundFile: "'.html_entity_decode($at).'"});</script>';
			}
			
			
			return $html;
	
		}
			
		
		public static function SwitchPanel(){
				
		}
		
		//----Gallery Page Short Code-----------
		public static function Gallery($attr){
			
			$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'div',
		'icontag'    => 'div',
		'captiontag' => 'div',
		'columns'    => 3,
		'size'       => 'gallery-thumb',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'div';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'div';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'div';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";


			$gallery_style = $gallery_div = '';
			if ( apply_filters( 'use_default_gallery_style', true ) )
				$gallery_style = "
				<style type='text/css'>
					#{$selector} {
						margin: auto;
					}
					#{$selector} .gallery-item {
						float: {$float};
						
						width: {$itemwidth}%;
					}
					#{$selector} img {
						
					}
					#{$selector} .gallery-caption {
						margin-left: 0;
					}
				</style>
				<script src='".get_template_directory_uri().'/js/isotope.js'."'></script>
				<!-- see gallery_shortcode() in wp-includes/media.php -->";
			$size_class = sanitize_html_class( $size );
			$tags = array();

			foreach ( $attachments as $id => $attachment ) {
				
				$tags = array_merge($tags, explode(',' ,$attachment->post_content));

			}
			
			$tags_cleared = array();
			
			foreach($tags as $tag){
				array_push($tags_cleared, trim($tag));
			}
			
			$tags = $tags_cleared;
			
			$tags = array_unique($tags);
			
						
			if (!empty($tags)) {
				$output .= '<div class="galleries"><div id="filters"><ul><li data="all" class="button"><span>all</span></li>';
					foreach($tags as $tag){
						$output .= '<li class="button" data="'.str_replace(' ', '-', trim($tag)).'"><span>'.trim($tag).'</span></li>';
					}
				$output .= '</ul></div><div class="clear"></div>';
			}
			$gallery_div = "
			
			<script src='".get_template_directory_uri()."/js/fancybox/jquery.mousewheel-3.0.6.pack.js' type=text/javascript ></script>
			<script src='".get_template_directory_uri()."/js/fancybox/jquery.fancybox.pack.js' type=text/javascript ></script>
			
			<link rel='stylesheet' type='text/css' href='".get_template_directory_uri()."/js/fancybox/jquery.fancybox.css' media='screen' />
			<link rel='stylesheet' type='text/css' href='".get_template_directory_uri()."/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5' />
			<script type='text/javascript' src=".get_template_directory_uri()."/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>
			<link rel='stylesheet' type='text/css' href=".get_template_directory_uri()."/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7' />
			<script type='text/javascript' src=".get_template_directory_uri()."/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>
			<script type='text/javascript' src=".get_template_directory_uri()."/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5'></script>
		
			<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
			$output .= apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

			$i = 0;

			

			foreach ( $attachments as $id => $attachment ) {
				
				$image_tags = explode(',' ,$attachment->post_content);

				$link = (isset($attr['link'])) && ('file' == $attr['link']) ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

				

				//$link = wp_get_attachment_link($id, $size, false, false);

				$output .= "<{$itemtag} class='gallery-item all";
					foreach($image_tags as $t){
						$output .= ' '.str_replace(' ', '-', trim($t));
					}
				 $output .= " '>";
				$output .= "<div class='gal_cont ic_container'>";

				if ( $captiontag && trim($attachment->post_excerpt) ) {
					$output .= "<div class=\"overlay\" style=\"display:none;\"></div>
						<{$captiontag} class='wp-caption-text gallery-caption ic_caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</{$captiontag}>";
				}

				$output .=	"<{$icontag} class='gallery-icon'>
						$link
					</{$icontag}>";
				
				$output .= "</div></{$itemtag}>";
				if ( $columns > 0 && ++$i % $columns == 0 )
					$output .= '<br style="clear: both" />';
			}

			$output .= "
					<br style='clear: both;' />
				</div></div>\n";

			$output .= "<script>
				jQuery(function(){
				  jQuery('#{$selector}').isotope({
				    // options
				    itemSelector : '.gallery-item',

				    layoutMode : 'masonry',

				     

				  });
				});

				jQuery('#filters li').click(function(){
									jQuery('#{$selector}').isotope({ filter: '.' + jQuery(this).attr('data')});
									jQuery('#filters li').each(function(){
										jQuery(this).removeClass('selected');
									});
									jQuery(this).addClass('selected');
									

				});	
				
				
				
				jQuery('.gallery-icon a').fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			jQuery('.gallery-item').capslide({
                    caption_color	: '#fff',
                    caption_bgcolor	: '#e9a104',
                    overlay_bgcolor : 'black',
                    border			: '',
                    showcaption	    : false
                });
                
                jQuery('.gallery-item').each(function(){
			
				jQuery(this).find('.ic_caption').bind('click', function() {
	    	 		jQuery(this).parent().find('a').trigger('click'); 
	    		})
			
			});

</script>";

			return $output;

		}
	}
}
	
//-----Preapre Theme and Admin Settings----------------
	TiAdminPanel::SetThemeName('lookshop');
	TiAdminPanel::SetThemePrefix('lookshop');
	TiAdminPanel::AddAction('admin_menu', 'TiAdminPanel::TiTopLevelMenu');
	TiAdminPanel::AddShortcode('gallery', 'TiAdminPanel::Gallery');
	TiAdminPanel::AddShortcode('source', 'TiAdminPanel::SourceCode');
	TiAdminPanel::AddShortcode('googlemap', 'TiAdminPanel::GMap');
	TiAdminPanel::AddShortcode('contacts', 'TiAdminPanel::Contacts');
	TiAdminPanel::AddShortcode('fancy_transitions', 'TiAdminPanel::FancyTransitions');
	TiAdminPanel::AddShortcode('title', 'TiAdminPanel::Title');
	TiAdminPanel::AddShortcode('accordion', 'TiAdminPanel::Accordion');
	TiAdminPanel::AddShortcode('section', 'TiAdminPanel::Section');

	TiAdminPanel::AddShortcode('elast', 'TiAdminPanel::Elast');
	TiAdminPanel::AddShortcode('item', 'TiAdminPanel::Item');


	TiAdminPanel::AddShortcode('container', 'TiAdminPanel::Container');
	TiAdminPanel::AddShortcode('wrapper', 'TiAdminPanel::Wrapper');
	
	
	TiAdminPanel::AddAction( 'admin_enqueue_scripts', 'TiAdminPanel::TiAddAdminScripts');
	
	TiAdminPanel::RegisterScripts();
	TiAdminPanel::RegisterShortcodes();
	TiAdminPanel::RegisterActions();
	
	
	TiAdminPanel::RegisterPattern('ptdots', get_template_directory_uri() .'/patterns/1.png', 'Dots', 'dot');
	TiAdminPanel::RegisterPattern('ptmosaic', get_template_directory_uri() .'/patterns/2.png', 'Mosaic', 'mosaic');
	TiAdminPanel::RegisterPattern('ptribs', get_template_directory_uri() .'/patterns/3.png', 'Ribs', 'ribs');
	TiAdminPanel::RegisterPattern('ptwaves', get_template_directory_uri() .'/patterns/4.png', 'Waves', 'waves');
	TiAdminPanel::RegisterPattern('ptmrams', get_template_directory_uri() .'/patterns/5.png', 'Mram', 'mram');
	TiAdminPanel::RegisterPattern('ptpixels', get_template_directory_uri() .'/patterns/6.png', 'Pixels', 'pixels');
	TiAdminPanel::RegisterPattern('ptdefault', get_template_directory_uri() .'/patterns/1.png', 'Default', '');
	
	
	TiAdminPanel::RegisterColor('csblue', '#33b3cd','blue', 'blue');
	TiAdminPanel::RegisterColor('csemerald', '#19ab8e','emerald', 'emerald');
	TiAdminPanel::RegisterColor('cspink', '#f678a4','pink', 'pink');
	TiAdminPanel::RegisterColor('csred', '#dc304b','red', 'red');
	TiAdminPanel::RegisterColor('csviolet', '#8266b1', 'violet', 'violet');
	TiAdminPanel::RegisterColor('csdefault','#ed9d12' ,'yellow(default)', '');		

	
	TiAdminPanel::AddAction( 'wp_enqueue_scripts', 'TiAdminPanel::AddStyles()');
	
	
	
	
	function getAnalyticsCode(){
		
		$code = get_option('ganalytics');
		if ( $code != '') {
		
			return '<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \''.$code.'\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>';
		
		}
	}

?>
