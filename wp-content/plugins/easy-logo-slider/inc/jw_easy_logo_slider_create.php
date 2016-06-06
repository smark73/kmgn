<?php
	function jw_easy_logo_slider_create(){
   		if(isset($_POST['insert'])){
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$jw_name = sanitize_text_field($_POST["jw_name"]);
			global $wpdb;
			$sql=$wpdb->query($wpdb->prepare("
			INSERT INTO ".$wpdb->prefix."jw_easy_logo_slider_setting (name) VALUES ( %s )",
			array($jw_name)
			));
			if($sql){
			$location=admin_url('admin.php?page=jw_easy_logo');
			echo'<script> window.location="'.$location.'"; </script> ';
			}
		}?>		
        <div class="wrap jw_admin_wrap">
        <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/easy-logo-slider/css/style-admin.css" rel="stylesheet" />

            <h2>Create New <strong>Logo Slider</strong></h2>
            <form method="post" action="" class="jw_create_new_slider">
            <table class='wp-list-table widefat fixed'>
            <tr><th>Name</th><td><input type="text" name="jw_name" required placeholder="Enter Slider Name..." /></td></tr>
            </table>
            <input type='submit' name="insert" value='Save Slider' class='button button-primary'>
            </form>
        </div>
<?php }?>