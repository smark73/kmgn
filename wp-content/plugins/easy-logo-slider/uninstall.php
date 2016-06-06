<?php 
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$option_name = 'jwthemes_logo_slider';

delete_option( $option_name );
global $wpdb;

$jw_plugin_table_name_slider = $wpdb->prefix."jw_easy_logo_slider";

$jw_plugin_table_name_setting = $wpdb->prefix."jw_easy_logo_slider_setting";



 $sql= "DROP TABLE IF EXISTS ".$jw_plugin_table_name_slider ;

 $sql1= "DROP TABLE IF EXISTS ".$jw_plugin_table_name_setting ;



 $wpdb->query($sql);

 $wpdb->query($sql1);
 
 $upload_dir=wp_upload_dir();
 $upload_dir =$upload_dir['path'].""."/easy_logo_slider";
 
 function destroy_upload_dir($upload_dir) { 
    if (!is_upload_dir($upload_dir) || is_link($upload_dir)) return unlink($upload_dir); 
        foreach (scanupload_dir($upload_dir) as $file) { 
            if ($file == '.' || $file == '..') continue; 
            if (!destroy_upload_dir($upload_dir . upload_dirECTORY_SEPARATOR . $file)) { 
                chmod($upload_dir . upload_dirECTORY_SEPARATOR . $file, 0777); 
                if (!destroy_upload_dir($upload_dir . upload_dirECTORY_SEPARATOR . $file)) return false; 
            }; 
        } 
        return rmupload_dir($upload_dir); 
    } 
 ?>