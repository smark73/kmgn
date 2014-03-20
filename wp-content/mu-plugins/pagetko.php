<?php

/*
Plugin Name: GCMAZ Page Take Over
Plugin URI: http://www.gcmaz.com
Description: Enable / Disable page take overs on site
Author: Stacy Mark
Version: 1.0
Author URI: 
*/

// SETTINGS PAGE IN ADMIN
class PTKO_Settings{

    // Used to make previously saved settings available to the class
    public $settings;
    
    // Retrieves previously saved settings and binds class methods to existing WordPress actions to ensure everything initializes in the correct order
    public function __construct()
    {
      $this->settings = get_option('ptko_settings');
      add_action('admin_menu', array($this, 'page_takeover_admin_menu'));
      add_action('admin_init', array($this, 'register_ptko_setting'));
      add_action('admin_notices', array($this, 'admin_error_notice_action'));
      add_filter('plugin_action_links', array($this, 'ptko_plugin_action_links'), 10, 2);
    }

    // adds Page Take Over to side menu
    public function page_takeover_admin_menu(){
        $page_title = 'Page Take Over';
        $menu_title = 'Page Take Over';
        $capability = 'manage_options';
        $menu_slug = 'page-takeover-settings';
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'page_takeover_settings'));

        //add submenu with same slug
        $sub_menu_title = 'Settings';
        add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array($this, 'page_takeover_settings'));

        //add submenu page for Help
        $submenu_page_title = 'Page Take Over Help';
        $submenu_title = 'Help';
        $submenu_slug = 'page-takeover-help';
        add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this, 'page_takeover_help'));
    }
    
    // displays the content of the ptko settings page
    public function page_takeover_settings(){
         if (!current_user_can('manage_options')){
             wp_die('You do not have sufficient permissions to access this feature');
         }
         ?>
        <div class="wrap">
            <h2>Page Take Over Settings</h2>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields( 'ptko_options_group' );?>
                <?php do_settings_sections( 'page-takeover-settings' );?>
                <?php submit_button('Save Changes', 'submit', 'ptko_save');?>
            </form>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                //header image uploader
                var hdr_uploader;
                $('#ptko_settings\\[ptko_hdrimg\\]').click(function(e) {
                    e.preventDefault();
                    //If the uploader object has already been created, reopen the dialog
                    if (hdr_uploader) {
                        hdr_uploader.open();
                        return;
                    }
                    //Extend the wp.media object
                    hdr_uploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Image',
                        button: {
                            text: 'Choose Image'
                        },
                        multiple: false
                    });
                    //When a file is selected, grab the URL and set it as the text field's value
                    hdr_uploader.on('select', function() {
                        attachment = hdr_uploader.state().get('selection').first().toJSON();
                        $('#ptko_settings\\[ptko_hdrimg\\]').val(attachment.url);
                    });
                    //Open the uploader dialog
                    hdr_uploader.open();
                });
                //bg image uploader
                var bg_uploader;
                $('#ptko_settings\\[ptko_bgimg\\]').click(function(e) {
                    e.preventDefault();
                    //If the uploader object has already been created, reopen the dialog
                    if (bg_uploader) {
                        bg_uploader.open();
                        return;
                    }
                    //Extend the wp.media object
                    bg_uploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Image',
                        button: {
                            text: 'Choose Image'
                        },
                        multiple: false
                    });
                    //When a file is selected, grab the URL and set it as the text field's value
                    bg_uploader.on('select', function() {
                        attachment = bg_uploader.state().get('selection').first().toJSON();
                        $('#ptko_settings\\[ptko_bgimg\\]').val(attachment.url);
                    });
                    //Open the uploader dialog
                    bg_uploader.open();
                });
            });
        </script>
        <?php
    }
    
    // display PTKO Section Description
    public function ptko_section_callback(){
        echo 'Choose your NEW settings first, THEN enable the Page Takeover';
    }

    // register the new settings fields and functions
    public function register_ptko_setting() {
        // First, we register a section. This is necessary since all future options must belong to one. 
        add_settings_section(
                'ptko-settings-section',                            // ID used to identify this section and with which to register options
                'Settings',                                             // Title to be displayed on the administration page
                array($this, 'ptko_section_callback'),      // Callback used to render the description of the section
                'page-takeover-settings'                        // Page on which to add this section of options
                );
        // Next, add the fields that belong to the section
        add_settings_field(
                'ptko_toggle',                                      // ID
                'Check to Enable:',                                            // label
                array($this, 'ptko_toggle_callback'),     // name of the function rendering  interface
                'page-takeover-settings',                     // page this option will be displayed
                'ptko-settings-section',                        // name of the section this field belongs
                array('')                                             // array of arguments to pass to the callback
                );
        add_settings_field(
                'ptko_link',                                        // ID 
                'Client Link (include http:// ):',                                     // label
                array($this, 'ptko_link_callback'),       // name of the function rendering the interface
                'page-takeover-settings',                   // page this option will be displayed
                'ptko-settings-section',                     // name of the section this field belongs
                array('')                                          // array of arguments to pass to the callback
                );
        add_settings_field(
                'ptko_hdrimg',                                   // ID 
                'Header Image (1000x150):',                                // label
                array($this, 'ptko_hdrimg_callback'),   // name of the function rendering the interface
                'page-takeover-settings',                   // page this option will be displayed
                'ptko-settings-section',                      // name of the section this field belongs
                array('')                                           // array of arguments to pass to the callback
                );
        add_settings_field(
                'ptko_bgimg',                                       // ID 
                'Background Image (1600x900 avg):',                           // label
                array($this, 'ptko_bgimg_callback'),      // name of the function rendering the interface
                'page-takeover-settings',                      // page this option will be displayed
                'ptko-settings-section',                         // name of the section this field belongs
                array('')                                            // array of arguments to pass to the callback
                );
        add_settings_field(
                'ptko_bgcolor',                                     // ID 
                'Background Color:',                            // label
                array($this, 'ptko_bgcolor_callback'),    // name of the function rendering the interface
                'page-takeover-settings',                     // page this option will be displayed
                'ptko-settings-section',                        // name of the section this field belongs
                array('')                                            // array of arguments to pass to the callback
                );
        // Finally, we register the fields with WordPress
        register_setting(
            'ptko_options_group',
            'ptko_settings',
            array($this, 'ptko_validate')
            );

    } 

    // PTKO Enable/Disable
    public function ptko_toggle_callback(){
        //$settings = $this->settings[ptko_toggle];
        if($this->settings[ptko_toggle] == 1){
            echo "<input type='checkbox' name='ptko_settings[ptko_toggle]' id='ptko_settings[ptko_toggle]' value='1'  checked='true' />";
        } else {
            echo "<input  type='checkbox' name='ptko_settings[ptko_toggle]' id='ptko_settings[ptko_toggle]' value='1'  />";
        }
    }
    // PTKO Link option
    public function ptko_link_callback(){
        $link = esc_url($this->settings[ptko_link]);
        echo "<input type='text' name='ptko_settings[ptko_link]' value='$link' />";
    }

    // PTKO Hdr Image
    public function ptko_hdrimg_callback(){
        wp_enqueue_media();
        echo "<input type='text' name='ptko_settings[ptko_hdrimg]' id='ptko_settings[ptko_hdrimg]' value='http://' />";
        //display the image if exists
        if($this->settings[ptko_hdrimg]){
            echo '<img src="' . $this->settings[ptko_hdrimg] . '" style="width:300px;height:auto;vertical-align:top;margin-left:20px;" />';
        }
    }

    // PTKO Bg Image
    public function ptko_bgimg_callback(){
        wp_enqueue_media();
        echo "<input type='text' name='ptko_settings[ptko_bgimg]' id='ptko_settings[ptko_bgimg]' value='http://' />";
        //display the image if exists
        if($this->settings[ptko_bgimg]){
            echo '<img src="' . $this->settings[ptko_bgimg] . '" style="width:300px;height:auto;vertical-align:top;margin-left:20px;" />';
        }
    }

    // PTKO Bg Color option
    public function ptko_bgcolor_callback(){
        // enqueue and load necessary jquery ui components and iris color picker assets
        wp_enqueue_style('iris-cp', get_template_directory_uri() . '/assets/js/Automattic-Iris-8ac1152/src/iris.min.css', false, null);
        wp_register_script('iris-colorpicker', get_template_directory_uri() . '/assets/js/Automattic-Iris-8ac1152/dist/iris.min.js', false, null, true);
        wp_enqueue_style('iris-cp');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('iris-colorpicker');
        //get and return stored settings
        $bgcolor = $this->settings['ptko_bgcolor'];
        echo "
        <p>Background color should match the BOTTOM of the bg image<br/>so the color continues below the image</p>
        <input type='text' id='ptko_settings[ptko_bgcolor]' name='ptko_settings[ptko_bgcolor]' value='$bgcolor' />
        <script type='text/javascript'>
            jQuery(document).ready(function($){
                $('#ptko_settings\\\[ptko_bgcolor\\\]').iris();
            });
        </script>
        ";
    }

    // called in register_ptko_setting -> register_setting
    // EACH option we want to store HAS TO set a value in the returning $output array
    public function ptko_validate($input){
        //get current values to return
        $output = $this->settings;
        
        //ENABLE/DISABLE
        $output['ptko_toggle'] = ($input['ptko_toggle'] == 1 ? 1 : 0);
        
        //LINK
        if(!filter_var($input['ptko_link'], FILTER_VALIDATE_URL)){
            add_settings_error('ptko_settings', 'invalid-url', 'URL is not valid');
        } else {
            $output['ptko_link'] = $input['ptko_link'];
        }

        //HEADER IMAGE
        if($input['ptko_hdrimg'] === 'http://'){
            //no input, so keep old value
            $output['ptko_hdrimg'] = $this->settings['ptko_hdrimg'];
        } else {
            $output['ptko_hdrimg'] = $input['ptko_hdrimg'];
        }
        
        //BACKGROUND IMAGE
        if($input['ptko_bgimg'] === 'http://'){
            //no input, so keep old value
            $output['ptko_bgimg'] = $this->settings['ptko_bgimg'];
        } else {
            $output['ptko_bgimg'] = $input['ptko_bgimg'];
        }
        
        //BACKGROUND COLOR
        $output['ptko_bgcolor'] = $input['ptko_bgcolor'];
        
        return $output;
    }

    //need to hook error in ptko_validate to admin_notices to display it
    public function admin_error_notice_action(){
        settings_errors('ptko_settings');
    }

    public function page_takeover_help(){
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this feature');
        }

        echo "
            <h3>Page Take Over Read Me</h3>
            <h4>Enabling a Page Take Over</h4>
            <ol>
                <li>Before you enable a page take over, it's best to customize your settings first, because changes are reflected on the live site.</li>
            </ol>
            <h4>Client Link</h4>
            <ol>
                <li>Include the entire link (http://www.link.com)  Only VALID URL's will be accepted.</li>
            </ol>
            <h4>Header Image</h4>
            <ol>
                <li>1000 pixels wide by 150 pixels high</li>
                <li>This is the show/hide header that animates up/down on hover</li>
            </ol>
            <h4>Background Image</h4>
            <ol>
                <li>Approximately 1600 pixels wide by 900 pixels high</li>
                <li>This fills the background, and the left / right gutters
                <li>Should contain a logo or text on the left / right gutters for the sponsor</li>
            </ol>
            <h4>Background Color</h4>
            <ol>
                <li>This color should MATCH the bottom of the background image, so the background appears continuous.  The color will continue where the image cuts off.</li>
            </ol>
        ";

    }

    // adds shortcut to edit settings on plugin page
    public function ptko_plugin_action_links($links, $file){
        static $this_plugin;

        if(!$this_plugin){
            $this_plugin = plugin_basename (__FILE__);
        }
        if($file == $this_plugin){
            // The "page" query string value must be equal to the slug
            // of the Settings admin page we defined earlier, which in
            // this case equals "page-takeover-settings".
            $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=page-takeover-settings">Settings</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }
}

new PTKO_Settings;