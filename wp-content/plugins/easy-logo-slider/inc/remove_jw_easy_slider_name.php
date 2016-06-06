<?php
	function remove_jw_easy_slider_name(){
		global $wpdb;
		$id = $_GET["id"];
			$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."jw_easy_logo_slider_setting where id = %s",$id));
			if($sql){
			$location=admin_url('admin.php?page=jw_easy_logo');
			echo'<script> window.location="'.$location.'"; </script> ';
			}		
	}
?>