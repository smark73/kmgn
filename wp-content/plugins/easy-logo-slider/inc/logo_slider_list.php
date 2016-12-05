<?php function slider_content_detail(){?>
<div class="wrap jw_admin_wrap">

  <aside>

  <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/easy-logo-slider/css/style-admin.css" rel="stylesheet" />

  <h2>Logo Slider : <?php global $wpdb;

        $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."jw_easy_logo_slider_setting where id=".$_GET['slider_id']);

		foreach($rows as $row){

		echo $row->name;

		}?>

  </h2>

  <a href="<?php echo admin_url('admin.php?page=logo_slider_create&action=create&slider_id='.$_GET['slider_id']); ?>" class="button button-primary jw_easy_logo_slider_add_image"> Add New Image</a> <br/>

  <?php
        global $wpdb;

        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."jw_easy_logo_slider");

		$slider_id = $wpdb->get_var($wpdb->prepare("SELECT slider_id FROM ".$wpdb->prefix."jw_easy_logo_slider where slider_id = %d",$_GET['slider_id']));	

		if($slider_id!=$_GET['slider_id']){

		 echo "<br/>Enter the Content by Clicking on above button";} else{

        echo "<table class='list-table widefat fixed jw_easy_logo_slider_list'>";

        echo "<tr><th>Title</th><th>Image</th><th>URL</th><th>Description</th><th>Action</th></tr>";

        foreach ($rows as $row ){if($row->slider_id==$_GET['slider_id']){?>

  <tr class="jw_easy_logo_slider_list list_logo_cnt">

    <td class="jw_easy_logo_slider_title"><?php echo esc_attr( stripcslashes($row->title));?></td>

    <td class="jw_easy_logo_slider_image"><img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_logo_slider/".$row->image;?>'></td>

    <td class="jw_easy_logo_slider_url"><?php echo esc_url($row->url); ?></td>

    <td class="jw_easy_logo_slider_description"><?php echo esc_attr(stripcslashes($row->description));?></td>

    <td class="jw_easy_logo_slider_action"><a href='<?php echo admin_url('admin.php?page=logo_slider_update&slider_id='.$_GET['slider_id'].'&id='.$row->id );?>'class="button jw_easy_logo_slider_details_edit">Edit</a> <a href='#' id="<?php echo $row->id;?>" class="button jw_easy_logo_slider_details_delete">Remove</a></td>
</tr>

  <?php }}?>

  </table>

</div>		<!--deleting-content-->
			<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".jw_easy_logo_slider_details_delete").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("id");
                //Built a url to send
                var info = 'id=' + del_id;
                if(confirm("Sure you want to delete this logo and content? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=logo_slider_remove');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".list_logo_cnt").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
            </script>

<?php if(isset($_POST['submit_setting'])){	

	global $wpdb;

	$id =$_GET['slider_id'];

	$limit_description=mysql_real_escape_string($_POST['limit_description']);
	$image_ht=mysql_real_escape_string($_POST['image_ht']);

	$url_target=mysql_real_escape_string($_POST['url_target']);

	$jw_easy_logo_slider_title_sh=mysql_real_escape_string($_POST['jw_easy_logo_slider_title_sh']);

	$jw_easy_logo_slider_desc_sh=mysql_real_escape_string($_POST['jw_easy_logo_slider_desc_sh']);
	$setting=array(

		'limit_description'=>$limit_description,

		'url_target'=>$url_target,
		'image_ht'=>$image_ht,
		'jw_easy_logo_slider_title_sh'=>$jw_easy_logo_slider_title_sh,

		'jw_easy_logo_slider_desc_sh'=>$jw_easy_logo_slider_desc_sh
		);

	$wpdb->update(

		''.$wpdb->prefix.'jw_easy_logo_slider_setting', //table

		array('setting' => serialize($setting)),array( 'id' => $id ), //data

		array( '%s' ),array( '%d' ));	

		}       

		else{

	global $wpdb;

        $wp_jw_easy_logo_slider_setting = $wpdb->get_results("SELECT *from ".$wpdb->prefix."jw_easy_logo_slider_setting where id=".$_GET['slider_id']);

	foreach ($wp_jw_easy_logo_slider_setting as $s ){

		$slider_name=$s->name;

		$row=unserialize($s->setting);

		$limit_description=$row['limit_description'];

		$url_target=$row['url_target'];
		$image_ht=$row['image_ht'];

		$jw_easy_logo_slider_title_sh=$row['jw_easy_logo_slider_title_sh'];

		$jw_easy_logo_slider_desc_sh=$row['jw_easy_logo_slider_desc_sh'];

	}}

?>

<div class="wrap jw_admin_wrap">

  <h3>

    <?php 

global $wpdb;

$slider_name = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."jw_easy_logo_slider_setting where id=".$_GET['slider_id']);

foreach($slider_name as $row){?>

    <strong>Slider Shortcode: &nbsp;&nbsp;&nbsp;&nbsp;</strong><code>[jw_easy_logo slider_name="<?php echo $row->name;?>"]</code></h3>

  <br>

  <?php }if ($_POST['submit_setting']) {?>

  <div class="updated">

    <p>Setting updated</p>

  </div>

  <?php }?>

  <div class="update_setting"><strong>Update the setting of the slider</strong></div>

  <table class="form-table jw_easy_logo_slider_options">

    <form method="post" action="">

      <tbody>

        <tr>

        <tr>

          <th scope="row"><label for="limit_description">limit description To</label></th>

          <td><input name="limit_description" id="limit_description" 

            value="<?php if(isset($limit_description)){echo esc_attr($limit_description);}else{ echo 100;}?>" 

            class="small-text" type="text">

            Words</td>

        </tr>

        <tr>

          <th scope="row"><label for="url_target">Where do you want to open the links</label></th>

          <td><?php  if($url_target=='') {?>

            <input type="radio" name="url_target" value="_blank" checked>

            Open in new Window &nbsp;

            <input type="radio" name="url_target" value="_parent" >

            Open in same window

            <?php }?>

            <?php if($url_target=="_blank" AND $url_target!=''){?>

            <input type="radio" name="url_target" value="_blank" checked>

            Open in new Window &nbsp;

            <input type="radio" name="url_target" value="_parent" >

            Open in same window

            <?php } if($url_target=="_parent" AND $url_target!='') {?>

            <input type="radio" name="url_target" value="_blank" >

            Open in new Window &nbsp;

            <input type="radio" name="url_target" value="_parent" checked>

            Open in same window

            <?php }?></td>

        </tr>
		<tr>
          <th scope="row"><label for="Image size height ">Image Height: </label></th>

          <td><input type="text" name="image_ht" id="image_ht" class="small-text" value="<?php if(isset($image_ht)){echo $image_ht;}else{ echo "150px";} ?>"></td>
        <tr>

          <th scope="row"><label for="title ">Title </label></th>

          <td><input type="radio" name="jw_easy_logo_slider_title_sh" class="post-format" id="post-format-0" 

            value="show"<?php if($jw_easy_logo_slider_title_sh!="hide"){?> checked<?php }?> >

            Show

            <input type="radio" name="jw_easy_logo_slider_title_sh" <?php if($jw_easy_logo_slider_title_sh!="show"){?> checked <?php }?> 

            class="post-format" id="post-format-0" value="hide"  >

            Hide </td>

        </tr>

        <tr>

          <th scope="row"><label for="description ">Description </label></th>

          <td><input type="radio" name="jw_easy_logo_slider_desc_sh"<?php if($jw_easy_logo_slider_desc_sh!="hide"){?> checked<?php }?> 

             class="post-format" id="post-format-0" value="show" >

            Show

            <input type="radio" name="jw_easy_logo_slider_desc_sh" <?php if($jw_easy_logo_slider_desc_sh!="show"){?> checked<?php }?> 

            class="post-format" id="post-format-0" value="hide"  >

            Hide </td>

        </tr>

        <tr>

         <td></td> <td><input name="submit_setting" id="submit_setting" class="button button-primary" value="Save Changes" type="submit"></td>

        </tr>

      </tbody>

    </form>

  </table>

  </aside>

</div>
<?php }}?>