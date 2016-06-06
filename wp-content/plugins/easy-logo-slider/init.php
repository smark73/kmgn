<?php
/*---------------------------------------------------------
Plugin Name: Easy Logo Slider

Plugin URI: http://jwthemes.com/easy_logo_slider/

Description: Easy Logo Slider is plugin that helps users to upload the logos of clients, partners, and affiliates along with title, short description and website URL. For frontend display there is option to show or hide title and description and also will be the features like linking images, opening in new window. Embedd in any post/page using shortcode <code>[jw_easy_logo slider_name="Slider Name"]</code> or you can add through widgets.

Version: 1.2.1

Author: JW Themes

Author URI: http://jwthemes.com
------------------------------------------------------------*/
register_activation_hook(__FILE__, 'register_upon_activation_jw' );

function register_upon_activation_jw(){//create the uploads folder upon activation

	  	add_option( 'jwthemes_logo_slider', true );
		$upload_dir=wp_upload_dir();
	  $upload_dir =$upload_dir['basedir'].""."/easy_logo_slider/";

  	if (!is_dir($upload_dir)) {

		mkdir($upload_dir, 0777, true);

  	}

	//creating table upon activation

  	global $wpdb;

  	$table_name = $wpdb->prefix . "jw_easy_logo_slider";

	if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 


  	$sql = "CREATE TABLE $table_name (

  	id int NOT NULL AUTO_INCREMENT,

  	title varchar(50),

  	image varchar(50),

  	url VARCHAR(60),

	description varchar(500),

	slider_id int,

  	PRIMARY KEY id (id)

    );";

	}

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

   dbDelta( $sql );

	 global $wpdb;

	$table_name = $wpdb->prefix . "jw_easy_logo_slider_setting";

	if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 



  	$sql = "CREATE TABLE $table_name (

  	id int NOT NULL AUTO_INCREMENT,

  	name varchar(50),

  	setting varchar(250),

  	PRIMARY KEY id (id)

    );";

	}

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

   dbDelta( $sql );  

}

//Hooked to upgrade_clear_destination
function delete_old_plugin_easy_logo_slider($removed, $local_destination, $remote_destination, $plugin) {
    global $wp_filesystem;

    if ( is_wp_error($removed) )
        return $removed; //Pass errors through.

    $plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
    if ( empty($plugin) )
        return new WP_Error('bad_request', $this->strings['bad_request']);

    $plugins_dir = $wp_filesystem->wp_plugins_dir();
    $this_plugin_dir = trailingslashit( dirname($plugins_dir . $plugin) );

    if ( ! $wp_filesystem->exists($this_plugin_dir) ) //If its already vanished.
        return $removed;

    // If plugin is in its own directory, recursively delete the directory.
    if ( strpos($plugin, '/') && $this_plugin_dir != $plugins_dir ) //base check on if plugin includes directory separator AND that its not the root plugin folder
        $deleted = $wp_filesystem->delete($this_plugin_dir, true);
    else
        $deleted = $wp_filesystem->delete($plugins_dir . $plugin);

    if ( ! $deleted )
        return new WP_Error('remove_old_failed', $this->strings['remove_old_failed']);

    return true;
}
//admin_menu_setup

//admin_menu_setup

add_action('admin_menu','jw_logo_slider');

function jw_logo_slider() {

	//this is the main item for the menu

	add_menu_page('Easy Logo Slider', //page title

	'Easy Logo Slider', //menu title

	'manage_options', //capabilities

	'jw_easy_logo', //menu slug

	'jw_easy_logo',

	 plugin_dir_url( __FILE__ ) . 'images/easy-logo-slider-icon.png'

 //function

	);

	//this is a submenu

	add_submenu_page('null', //parent slug

	'Add New Image', //page title

	'Add New Image', //menu title

	'manage_options', //capability

	'logo_slider_create', //menu slug

	'logo_slider_create'); //function

	add_submenu_page('jw_easy_logo',

	'Add Slider',

	'Add Slider',

	'manage_options',

	'jw_easy_logo_slider_create',

	'jw_easy_logo_slider_create'

	);

	//this submenu is HIDDEN, however, we need to add it anyways

	add_submenu_page(null, //parent slug

	'Update Data', //page title

	'Update', //menu title

	'manage_options', //capability

	'logo_slider_update', //menu slug

	'logo_slider_update'); //function

	

	add_submenu_page(null, //parent slug

	'Remove Data', //page title

	'Remove', //menu title

	'manage_options', //capability

	'logo_slider_remove', //menu slug

	'logo_slider_remove'); //function

	add_submenu_page(null, //page title

	'see slides',

	'see slides', //menu title

	'manage_options', //capabilities

	'slider_content_detail', //menu slug

	'slider_content_detail' //function

	);
}

function randomStr($length = 6){
  $validCharacters = "0123456789abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
  $validCharNumber = strlen($validCharacters);
  $result = "";
  for ($i = 0; $i < $length; $i++) {
   $index = mt_rand(0, $validCharNumber - 1);
   $result .= $validCharacters[$index];
  }
  return $result;
}
/*start of shortcode*/
add_shortcode('jw_easy_logo', 'jw_easy_logo_slider_sht');
	function jw_easy_logo_slider_sht($atts){
  //add shortcode
  ob_start();
  $randomStr = randomStr();
?>
    <div class="wrapper">
        <?php if(!isset($atts['slider_notitle'])) { ?>
        <p class="jw_easy_slider_name"><?php if(isset($atts['slider_title'])) echo $atts['slider_title']; else echo $atts['slider_name'];?></p>
         <?php } ?>
        <div class="jcarousel-wrapper" id="<?php echo $randomStr;?>">
            <div class="jcarousel">
                <ul>
                <?php
                global $wpdb;

                $rw = $wpdb->get_results("SELECT * from ".$wpdb->prefix."jw_easy_logo_slider INNER JOIN ".$wpdb->prefix."jw_easy_logo_slider_setting where ".$wpdb->prefix."jw_easy_logo_slider_setting.id = "."".$wpdb->prefix."jw_easy_logo_slider.slider_id"." AND ".$wpdb->prefix."jw_easy_logo_slider_setting.name='".$atts['slider_name']."'");

                foreach ($rw as $setting){  $res=$setting->setting; $show=unserialize($res);}

                $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."jw_easy_logo_slider INNER JOIN ".$wpdb->prefix."jw_easy_logo_slider_setting where ".$wpdb->prefix."jw_easy_logo_slider_setting.id = "."".$wpdb->prefix."jw_easy_logo_slider.slider_id"." AND ".$wpdb->prefix."jw_easy_logo_slider_setting.name='".$atts['slider_name']."'");

                foreach ($rows as $row ){?>
                    <li>
						 <style>
                        	.easy-logo_image {height:<?php if($show['image_ht']!=''){echo $show['image_ht'];}else{ echo "150px";}?> !important}
                         </style>

                       <?php if($row->url!=''){?>
                         <a href="<?php echo $row->url;?>" target="<?php if($show['url_target']!=''){echo $show['url_target'];} else{ echo "_blank";} ?>" title="<?php echo stripcslashes($row->title);?>"><img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$row->image;?>' class="easy-logo_image" alt="" title="<?php echo stripcslashes($row->title);?>" />
                         </a>
                       <?php } else{?>
                        <img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$row->image;?>' class="easy-logo_image" alt="" title="<?php echo stripcslashes($row->title);?>" />
                       <?php }?>

                       <?php if($row->url!=''){?>
                         <a href="<?php echo $row->url;?>" target="<?php if($show['url_target']!=''){echo $show['url_target'];} else{ echo "_blank";} ?>" title="<?php echo stripcslashes($row->title);?>">
                          <h3><?php if($show['jw_easy_logo_slider_title_sh']!="hide" AND $show['jw_easy_logo_slider_title_sh']!=''){echo stripcslashes($row->title);}?></h3>
                         </a>
                       <?php } else {?>
                         <h3><?php if($show['jw_easy_logo_slider_title_sh']!="hide" AND $show['jw_easy_logo_slider_title_sh']!=''){echo stripcslashes($row->title);}?></h3>
                       <?php }?>

                         <?php $str = substr($row->description, 0, $show['limit_description']);?>
                         <?php if($show['jw_easy_logo_slider_desc_sh']!="hide" AND $show['jw_easy_logo_slider_title_sh']!=''){echo '<p class="descp">'.stripcslashes($str).'</p>';}?>

                    </li>
                    <?php }?>
                </ul>
            </div>
            <a href="#" class="jcarousel-control-prev" title="Previous">&lsaquo;</a>

            <a href="#" class="jcarousel-control-next" title="Next">&rsaquo;</a>

            <p class="jcarousel-pagination"></p>

        </div>
        <script type='text/javascript'>create_jcarousel('<?php echo trim($select_no).$randomStr;?>');</script>
    </div>
  <?php return ob_get_clean();?>

<?php }
/*end of the shortcode*/

/* start of the widgets*/

class Jw_easy_logo_slider extends WP_Widget{

	function __construct(){//function will call the description of the widget and it's name

		$params=array(

			'description'=>'Display the easy logo slider images according to need',

			'name'=>'Easy Logo Slider'

		);

	parent::__construct('Jw_easy_logo_slider','',$params);

	}	

	public function form($instance){//create the title form

		extract($instance);?>
		<p>
        	<label for="<?php echo $this->get_field_id('title');?>">Title</label>

            <input 

            	class="widefat"

                id="<?php echo $this->get_field_id('title');?>"

                name="<?php echo $this->get_field_name('title');?>"

                value="<?php if(isset($title)) echo esc_attr($title); ?>" />
		</p>

        <p>
        	<label for="<?php echo $this->get_field_id('select_no');?>">Select slider to be displayed</label>            

            <select 

            	class="widefat"

                id="<?php echo $this->get_field_id('select_no');?>"

                name="<?php echo $this->get_field_name('select_no');?>"

                value="<?php if(isset($select_no)) echo esc_attr($select_no); ?>">

                <option value="<?php if(isset($select_no)) echo esc_attr($select_no); ?> " ><?php if(isset($select_no)) echo esc_attr($select_no); ?></option>

<?php global $wpdb; $rows = $wpdb->get_results("SELECT name from ".$wpdb->prefix."jw_easy_logo_slider_setting where name!='".$select_no."'");

				foreach ($rows as $row ){?>     

            <option value="<?php echo $row->name;?>"><?php echo $row->name;?></option>

            <?php }?>

        	</select>            

        </p>
<?php }
	public function widget($args,$instance){

		extract($args);

		extract($instance);

        $randomStr = randomStr();

		echo $before_widget;?>

        <div class="wrapper">

            <?php echo $htmltag;?><?php echo $title;?></<?php echo $htmltag;?>>

            <div class="jcarousel-wrapper" id="<?php echo trim($select_no).$randomStr;?>">
                <div class="jcarousel">
                    <ul>
                     <?php

					global $wpdb;

				$rw = $wpdb->get_results("SELECT *from ".$wpdb->prefix."jw_easy_logo_slider JOIN ".$wpdb->prefix."jw_easy_logo_slider_setting where

				".$wpdb->prefix."jw_easy_logo_slider_setting.name='".$select_no."'");

				foreach ($rw as $setting){  $res=$setting->setting; $show=unserialize($res);}

					$rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."jw_easy_logo_slider JOIN ".$wpdb->prefix."jw_easy_logo_slider_setting where ".$wpdb->prefix."jw_easy_logo_slider_setting.id = "."".$wpdb->prefix."jw_easy_logo_slider.slider_id"." AND ".$wpdb->prefix."jw_easy_logo_slider_setting.name='".$select_no."'");

					foreach ($rows as $row ){?>

                        <li>
						 <style>
                        	.easy-logo_image {height:<?php if($show['image_ht']!=''){echo $show['image_ht'];}else{ echo "150px";}?> !important}
                         </style>

                       <?php if($row->url!=''){?>
                         <a href="<?php echo $row->url;?>" target="<?php if($show['url_target']!=''){echo $show['url_target'];} else{ echo "_blank";} ?>" title="<?php echo stripcslashes($row->title);?>"><img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$row->image;?>' class="easy-logo_image" alt="" /></a>
                       <?php } else{?>
                        <img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$row->image;?>' class="easy-logo_image"  alt="" title="<?php echo stripcslashes($row->title);?>" />
                       <?php }?>

                       <?php if($row->url!=''){?>
                         <a href="<?php echo $row->url;?>" target="<?php if($show['url_target']!=''){echo $show['url_target'];} else{ echo "_blank";} ?>" title="<?php echo stripcslashes($row->title);?>">
                          <h3><?php if($show['jw_easy_logo_slider_title_sh']!="hide" AND $show['jw_easy_logo_slider_title_sh']!=''){echo stripcslashes($row->title);}?></h3>
                         </a>
                       <?php } else {?>
                         <h3><?php if($show['jw_easy_logo_slider_title_sh']!="hide" AND $show['jw_easy_logo_slider_title_sh']!=''){echo stripcslashes($row->title);}?></h3>
                       <?php }?>

                       <?php $str = substr($row->description, 0, $show['limit_description']);?>

                        <?php if($show['jw_easy_logo_slider_desc_sh']!="hide"){echo '<p class="descp">'.stripcslashes($str).'</p>';}?>

                        </li>

                        <?php }?>

                    </ul>

                </div>

                <a href="#" class="jcarousel-control-prev" title="Previous">&lsaquo;</a>

                <a href="#" class="jcarousel-control-next" title="Next">&rsaquo;</a>

                <p class="jcarousel-pagination"></p>
            </div>
            <script type='text/javascript'>create_jcarousel('<?php echo trim($select_no).$randomStr;?>');</script>
        </div>

		<?php echo $after_widget;
	}}

//widgets function

add_action('widgets_init','jw_register_easy_logo_slider');

function jw_register_easy_logo_slider(){

	register_widget('Jw_easy_logo_slider');

}

//widgets

/*end of the widgets*/

define('ROOTDIR', plugin_dir_path(__FILE__));

require_once(ROOTDIR . 'inc/logo_slider_list.php');

require_once(ROOTDIR . 'inc/jw_easy_logo.php');

require_once(ROOTDIR . 'inc/jw_easy_logo_slider_create.php');

require_once(ROOTDIR . 'inc/logo_slider_create.php');

require_once(ROOTDIR . 'inc/logo_slider_update.php');

require_once(ROOTDIR . 'inc/logo_slider_remove.php');

function mytheme_enqueue_scripts(){ 

	wp_register_script( 'jquery_jcarousel_min', plugins_url( '/js/jquery.jcarousel.min.js', __FILE__ ), array( 'jquery' ) );

	wp_register_script( 'jcarousel_responsive', plugins_url( '/js/jcarousel.responsive.js', __FILE__ ), array( 'jquery' ) );


  if (!is_admin()): 

    wp_enqueue_script('jquery_jcarousel_min');	

	wp_enqueue_script('jcarousel_responsive');

  endif; //!is_admin 

}

add_action( 'wp_print_scripts', 'mytheme_enqueue_scripts' ); 

add_action( 'wp_print_scripts', 'register_plugin_styles' );


function register_plugin_styles() {

	wp_register_style( 'jcarouselresponsive', plugins_url( 'css/jcarouselresponsive.css',__FILE__ ) );

	if (!is_admin()): 

	wp_enqueue_style( 'jcarouselresponsive' );

	endif;
	
	wp_register_style( 'style-admin', plugins_url( 'css/style-admin.css',__FILE__) );

	wp_enqueue_style( 'style-admin' );
}?>