<?php
function logo_slider_update () {
if(isset($_POST['update'])){	
	global $wpdb;
	$id = sanitize_text_field($_POST['id']);
	$title = sanitize_text_field($_POST['title']);
	$txtdesc = sanitize_text_field($_POST['txtarea']);
	$url = sanitize_text_field($_POST['url']);
	$random_digit=rand(000000,999999);// produces random no
	$imgname=basename($_FILES['image']['name']);
	$imgpath=$random_digit.$imgname;
	$upload_dir = wp_upload_dir();
	move_uploaded_file($_FILES['image']['tmp_name'],$upload_dir['basedir'].""."/easy_logo_slider/".$imgpath);	
	$path=''.$path_name.'';
	
	$path=$path.$imgpath;		
	
	if ($_FILES['image']['name'] != '') {
	$wpdb->update(
		''.$wpdb->prefix.'jw_easy_logo_slider', //table
		array('title' => $title,'image'=>$random_digit.$imgname,'url'=>$url,'description'=>$txtdesc),array( 'id' => $id ), //data
		array('%s','%s','%s','%s'),array('%d') //data format			
	);
	}
	else {
		$wpdb->update(
		''.$wpdb->prefix.'jw_easy_logo_slider', //table
		array('title' => $title,'url'=>$url,'description'=>$txtdesc),array( 'id' => $id ), //data
		array('%s','%s','%s'),array('%d') //data format			
	);
	}
}

else{//selecting value to update
	global $wpdb;	
        $jw_easy_logo_slider = $wpdb->get_results("SELECT *from ".$wpdb->prefix."jw_easy_logo_slider where id=".$_GET['id']);
	foreach ($jw_easy_logo_slider as $s ){
		$id=$_GET['id'];
		$title = esc_attr($s->title);
		$url = esc_url($s->url);
		$image = $s->image;
		$txtdesc = esc_attr($s->description);
	}
}?>
<div class="wrap jw_admin_wrap">

<?php if (isset($_POST['update'])) { 
$location=admin_url('admin.php?page=slider_content_detail&slider_id='.$_GET['slider_id']);
echo'<script> window.location="'.$location.'"; </script> ';
}?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/easy-logo-slider/css/style-admin.css" rel="stylesheet" />
<h2>Update the Details &nbsp;&nbsp;&nbsp;&nbsp;<span class="go_back"><a href="<?php echo admin_url('admin.php?page=slider_content_detail&slider_id='.$_GET['slider_id']);?>">
<button class="button primary-button">Go Back</button></a></span></h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" class="jw_easy_logo_slider_add_details">
<table class='wp-list-table widefat fixed'>
<tr><th>Title</th><td><input type="text" name="title" value="<?php echo $title;?>" required/></td></tr>
<tr><th>Image</th><td><input type="file" name="image" id="image" accept="image/*"/></td></tr>
<tr><th></th><td style="text-align:left;"><?php if(isset($image)){?><img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$image;?>'><?php }?></td></tr>
<tr><th>URL</th><td><input type="text" name="url" value="<?php echo $url;?>"></td></tr>
<tr><th>Description</th><td><textarea name="txtarea" id="txtarea" cols="60" rows="10" ><?php echo $txtdesc;?></textarea></td></tr>
</table>
<input type="hidden" value="<?php echo $_GET['id'];?>" name="id" id="id"><br />
<input type='submit' name="update" value='Save' class='button button-primary'> &nbsp;&nbsp;
</form>
</div>
<?php }?>