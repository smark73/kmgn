<?php 
	function jw_easy_logo(){?>
        <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/easy-logo-slider/css/style-admin.css" rel="stylesheet" />
        <div class="wrap jw_admin_wrap">
        <?php 
        global $wpdb;
        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."jw_easy_logo_slider_setting");

		foreach($rows as $row);
		if($row->id!=''){
			echo "<h2>Available Slider</h2>";
		echo "<table class='list-table widefat fixed'>";
		echo "<tr><th>Slider Name</th><th>Add Images</th><th>Shortcode</th><th>Action</th></tr>"; 
		foreach($rows as $row){?>
            
            <tr class="slider_list"><td><a href="<?php echo admin_url('admin.php?page=slider_content_detail&slider_id='.$row->id);?>" class="jw_easy_logo_slider_nam">
				<?php echo $row->name;?></a></td><td>&nbsp;<a href="<?php echo admin_url('admin.php?page=slider_content_detail&slider_id='.$row->id);?>" class="jw_easy_logo_add_image">Add</a></td>
                <!--shortcode-->
               <td>[jw_easy_logo slider_name="<?php echo $row->name;?>"]</td>
               <!--removetheslider-->
                <td><span class="remove_jw_easy_logo_slider_name"> 
                <a href="#" slider_id="<?php echo $row->id;?>" class="delete_slider">
              <button>Remove</button></a></span></td></tr>
             
            
            <?php }?></table>
            	<!--deleting-content-->
			<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".delete_slider").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("slider_id");
                //Built a url to send
                var info = 'slider_id=' + del_id;
                if(confirm("Sure you want to delete this slider and content? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=logo_slider_remove');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".slider_list").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
            </script>

            <h2 style="margin-top:25px;">Add New Slider</h2><br/>
            <a href="admin.php?page=jw_easy_logo_slider_create"><button class="button primary-button">Create New Slider</button></a> 
			<?php } else {?>
            <strong>Create the New Slider</strong><br/><br/>
            <a href="admin.php?page=jw_easy_logo_slider_create"><button class="button primary-button">Create New Slider</button></a><?php }?>
        </div>
	<?php }?>