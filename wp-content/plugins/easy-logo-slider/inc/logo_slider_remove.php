<?php 
	function logo_slider_remove(){
	global $wpdb;
	if($_GET['id']){
		$id=$_GET['id'];
		$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."jw_easy_logo_slider WHERE id = %s",$id));
}
	global $wpdb;
	if($_GET['slider_id']){
		$slider_id=$_GET['slider_id'];
		$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."jw_easy_logo_slider_setting WHERE id = %s",$slider_id));

}}?>