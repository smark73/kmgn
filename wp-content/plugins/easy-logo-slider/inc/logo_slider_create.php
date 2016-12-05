<?php
function logo_slider_create () {
if(isset($_POST['insert'])){
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$title = sanitize_text_field($_POST["title"]);
	$url = sanitize_text_field($_POST['url']);
	$txtdesc = sanitize_text_field($_POST['txtarea']);
	$txtslider_id = sanitize_text_field($_POST['slider_id']);
	$upload_dir = wp_upload_dir();
	$path_name=$upload_dir['basedir'].""."/easy_logo_slider/"; //file upload path !important
	$path = ''.$path_name.'';
	$random_digit = rand(000000,999999);// produces random no
	$imgname=basename($_FILES['image']['name']);
	$imgpath = sanitize_file_name($random_digit.$imgname);
	$path = $path.$imgpath;
	global $wpdb;
	if(move_uploaded_file($_FILES['image']['tmp_name'],$path)){

	$wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO ".$wpdb->prefix."jw_easy_logo_slider
		( title, image, url, description, slider_id )
		VALUES ( %s, %s, %s, %s, %d )
	", 
        array(
		$title, 
		$imgpath, 
		$url,
		$txtdesc,
		$txtslider_id
	) ) );
		
	$message.="New Datails Added";
	
}}?>    
<div class="wrap jw_admin_wrap">
    
    <h2>Add New Details &nbsp;&nbsp;&nbsp;&nbsp;<span class="go_back"> <a href="<?php echo admin_url('admin.php?page=slider_content_detail&slider_id='.$_GET['slider_id']);?>">
    <button class="button primary-button">Back to Slider</button></a></span></h2>
    <?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?><br/><a href="<?php echo admin_url('admin.php?page=slider_content_detail&slider_id='.$_GET['slider_id'])?>">&laquo; Back to Images list</a>
    </p></div><?php endif;?>
    <form method="post" action="" enctype="multipart/form-data" class="jw_easy_logo_slider_add_details">
    <table class='wp-list-table widefat fixed'>
    <tr><th>Title</th><td><input type="text" name="title" placeholder="Enter the title..." required/></td></tr>
    <tr><th>Image</th><td><input type="file" name="image" accept="image/*"/></td></tr>
    <tr><th>URL</th><td><input type="text" name="url" id="url" placeholder="Enter the website link..."></td></tr>
    <input type="hidden" name="slider_id" id="slider_id" value="<?php echo $_GET['slider_id'];?>">
    <tr><th>Description</th><td><textarea name="txtarea" id="txtarea" cols="60" rows="10"  placeholder="Add some description..."></textarea></td></tr>
    
    <tr><td></td><td><input type='submit' name="insert" value='&nbsp; Save Details &nbsp;' class='button button-primary' style="float:left;"></td></tr>
    </table>
    </form>
</div>
<?php
}?>