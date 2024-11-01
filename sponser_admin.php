<?php
ob_start();
global $wpdb;
$url = plugins_url( '' , __FILE__ );
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(empty($_POST))
{
	$Pagination_limit = get_option('sponserpagination');
	$resultCount = $wpdb->get_var("select count(id) from ".$wpdb->prefix."sponser_link");
	$sponserData = $resultCount;  
	$p = isset($_GET['p']) ? $_GET['p'] : 1; 
	$limit = $Pagination_limit;
	$start_from = $limit * ($p - 1);
	$result = $wpdb->get_results("select * from ".$wpdb->prefix."sponser_link ORDER BY id limit $start_from, $limit");
  if( isset($_REQUEST['edit'] ) )
{
	?>
<style>
#form3{display:none;}
.tablenav {display:none;}
</style>
<?php }
?>
<div class="wrap" id="hide_list">
<?php
$addmsg = filter_input(INPUT_GET, 'addmsg', FILTER_SANITIZE_SPECIAL_CHARS);
$editmsg = filter_input(INPUT_GET, 'editmsg', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($addmsg)){?><div class="updated below-h2" id="message"><p><?php echo $addmsg;?></p></div>
<?php }if(isset($editmsg)){?><div class="updated below-h2" id="message"><p><?php echo $editmsg;?></p>
</div><?php } ?>
<form method="post" id="form3" action="">
    <input type="submit" name="Submit" value="<?php esc_html_e( 'Add New' , 'sponsered-link');?>"  class="add-new-h2"/>
    <input type="button" name="Submit" value="<?php esc_html_e( 'Delete' , 'sponsered-link');?>" onclick="delete_item()"  class="add-new-h2"/>
 <table class="wp-list-table widefat fixed posts" cellpadding="0" border="0">
      <thead>
        <tr>
          <th width="2%"> ID </th>
          <th width="1.5%"> <input type="checkbox" class="checkAll" name="toggle" style="margin-left:0">
          </th>
          <th class="manage-column column-cb check-column" width="10%"><?php esc_html_e( 'Title' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" width="10%"><?php esc_html_e( 'Link' , 'sponsered-link');?></th>
          <th width="15%"> <?php esc_html_e( 'Created' , 'sponsered-link');?> </th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Image' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Target' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Published' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Action' , 'sponsered-link');?></th>
        </tr>
      </thead>
      <tbody id="the-list">
        <?php 
		if($sponserData  > 0){
		foreach($result as $value){?>
          <tr>
              <td class="post-title page-title column-title"><?php echo $value->id;?></td>
              <td class="post-title page-title column-title"><input class="item" type="checkbox" value="<?php echo $value->id;?>" name="cid[]"></td>
              <td class="post-title page-title column-title"><?php echo $value->title;?></td>
              <td class="post-title page-title column-title"><?php echo $value->link;?></td>
              <td class="post-title page-title column-title"><?php 
                echo  date('d-m-y',$value->created);
                ?></td>
              <td class="post-title page-title column-title" style="text-align: center;">
                <img src="<?php echo $value->image;?>" width="80" alt="img" />
              </td>
              <td class="post-title page-title column-title" style="text-align: center;">
                <?php echo $value->target;?>
              </td>
              <td class="post-title page-title column-title" style="text-align: center;"><?php if($value->publish == 1){ echo '<img src="'.plugins_url( 'images/tick.png' , __FILE__ ).'"';}else{ echo '<img src="'.plugins_url( 'images/publish_x.png' , __FILE__ ).'"';}?></td>
              <td class="post-title page-title column-title" style="text-align: center;"><a href="<?php echo $actual_link;?>&edit=<?php echo $value->id;?>">Edit</a></td>
            </tr>
        <?php }
		}else{
		echo "<tr class='no-items'><td colspan='6' class='colspanchange'>No Result Found.</td></tr>";
		}?>
      </tbody>
      <tfoot>
        <tr>
          <th width="2%"> ID </th>
          <th width="1.5%"> <input type="checkbox" class="checkAll" value="" name="toggle" style="margin-left:0">
          </th>
          <th class="manage-column column-cb check-column" width="10%"> <?php esc_html_e( 'Title' , 'sponsered-link');?> </th>
          <th class="manage-column column-cb check-column" width="10%"> <?php esc_html_e( 'Link' , 'sponsered-link');?> </th>
          <th width="15%"> <?php esc_html_e( 'Created' , 'sponsered-link');?> </th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Image' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"><?php esc_html_e( 'Target' , 'sponsered-link');?></th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"> <?php esc_html_e( 'Published' , 'sponsered-link');?> </th>
          <th class="manage-column column-cb check-column" style="text-align: center;" width="10"> <?php esc_html_e( 'Action' , 'sponsered-link');?> </th>
        </tr>
      </tfoot>
    </table>
  </form>
<div class="tablenav bottom">
  <div class="alignleft actions bulkactions">
  <?php
$numberofPages = ceil($sponserData/$limit);   
for($i = 1; $i <= $numberofPages; $i++){  
 if($p != $i){ 
 echo '[<a href='.site_url().'/wp-admin/admin.php?page=sponser_admin&p='.$i.'>'.$i.'</a>] ';  
 }else{  
 echo "[$i] ";  
 }  
} 
?>
</div>
<div class="tablenav-pages one-page"><span class="displaying-num"><?php echo $sponserData.'&nbsp;item';?></span>
</div>
</div>
<?php
}
elseif($_REQUEST['Submit']="Add Sponsered" && !isset($_REQUEST['cid']))     //add Sponser
{
?>
<div class="wrap">
  <div class="col100">
    <fieldset class="form_edit" style="border: 1px solid #CCCCCC; padding: 10px;">
      <legend><?php esc_html_e( 'Add Sponsered Link' , 'sponsered-link');?> </legend>
      <form name="oscimp_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data">
       <?php wp_nonce_field('add_sponser','add-sponser-url'); ?>
       <input name="action" value="add_sponser" type="hidden" />
        <table class="admintable">
          <tbody>
            <tr>
              <td width="100" align="right" class="key"><label for="firstName"> <?php esc_html_e( 'Title' , 'sponsered-link');?> : </label></td>
              <td><input type="text" value="" maxlength="250" size="32" id="title" name="title" class="text_area" required></td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="lastName"> <?php esc_html_e( 'Link' , 'sponsered-link');?> : </label></td>
              <td><input type="text" value="" maxlength="250" size="32" id="link" name="link" class="text_area" required></td>
            </tr>
            <tr>
              <td width="100" align="right" class="key">
                <label for="image"> <?php esc_html_e( 'Image' , 'sponsered-link');?> : </label>
              </td>
              <td>
                <input type="file"  name="image" required>
              </td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="target"> <?php esc_html_e( 'Target' , 'sponsered-link');?> : </label></td>
              <td><input type="radio" value="_blank" name="target">
                <?php esc_html_e( 'New Page' , 'sponsered-link');?> 
                <input type="radio" value="_self" name="target" required>
                <?php esc_html_e( 'Same Page' , 'sponsered-link');?>  
              </td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="publish"> <?php esc_html_e( 'Publish' , 'sponsered-link');?> : </label></td>
              <td><input type="radio" value="1" name="publish">
                <?php esc_html_e( 'Yes' , 'sponsered-link');?> 
                <input type="radio" value="0" name="publish" required>
                <?php esc_html_e( 'No' , 'sponsered-link');?>  
              </td>
            </tr>
            <tr>
           </tr>
            <tr>
              <td colspan="2" style="text-align:center"><input type="submit"  name="Submit" value="<?php esc_html_e( 'Add Sponser' , 'sponsered-link');?> "  class="button button-primary button-large"/></td>
            </tr>
          </tbody>
        </table>
      </form>
    </fieldset>
  </div>
</div>
<?php 
}
else
{
	foreach($_REQUEST['cid'] as $id){
		$sponserResult = $wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."sponser_link WHERE  id = %d ",$id));
	}
	$rurl=site_url()."/wp-admin/admin.php?page=sponser_admin";
	?>
	<script>
	window.location.href = "admin.php?page=sponser_admin";
	</script>
	<?php
	 exit;
}

if( isset($_REQUEST['edit'] ) )
{
	$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."sponser_link WHERE id = %d",$_REQUEST['edit']));
	$value = $result[0]
?>
<div class="wrap">
  <div class>
    <fieldset class="form_edit" style="border: 1px solid #CCCCCC; padding: 10px;">
      <legend><?php esc_html_e( 'Edit Sponsered Link' , 'sponsered-link');?></legend>
      <form name="oscimp_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data" id="edit">
      <?php wp_nonce_field('edit_sponser','edit-sponser-url'); ?>
       <input name="action" value="edit_sponser" type="hidden" />
        <input type="hidden" name="id" value="<?php echo $_REQUEST['edit'];?>"  />
        <table class="admintable">
          <tbody>
            <tr>
              <td width="100" align="right" class="key"><label for="firstName"> <?php esc_html_e( 'Title' , 'sponsered-link');?>: </label></td>
              <td><input type="text" value="<?php echo $value->title;?>" maxlength="250" size="32" id="title" name="title" class="text_area" required></td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="lastName"> <?php esc_html_e( 'Link' , 'sponsered-link');?>: </label></td>
              <td><input type="text" value="<?php echo $value->link;?>" maxlength="250" size="32" id="link" name="link" class="text_area" required></td>
            </tr>
            <tr>
              <td width="100" align="right" class="key">
                <label for="image"> <?php esc_html_e( 'Image' , 'sponsered-link');?> : </label>
              </td>
              <td>
                <img src="<?php echo $value->image; ?>" width="150" /> <br />
				 <input type="hidden" name="image_hidden" value="<?php echo $value->image; ?>">
                <input type="file" name="image" value="">
              </td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="target"> <?php esc_html_e( 'Target' , 'sponsered-link');?> : </label></td>
              <td><input type="radio" value="_blank" name="target" required <?php if($value->target == "_blank"){echo 'checked="checked"';}?>>
                <?php esc_html_e( 'New Page' , 'sponsered-link');?> 
                <input type="radio" value="_self" name="target" required <?php if($value->target == "_self"){echo 'checked="checked"';}?>>
                <?php esc_html_e( 'Same Page' , 'sponsered-link');?>  </td>
            </tr>
            <tr>
              <td width="100" align="right" class="key"><label for="publish"> <?php esc_html_e( 'Publish' , 'sponsered-link');?>: </label></td>
              <td><input type="radio" value="1" name="publish" required <?php if($value->publish == 1){echo 'checked="checked"';}?>>
                <?php esc_html_e( 'Yes' , 'sponsered-link');?>
                <input type="radio" value="0" name="publish" required <?php if($value->publish == 0){echo 'checked="checked"';}?>>
               <?php esc_html_e( 'No' , 'sponsered-link');?> </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:center"><input type="submit" onclick="return check_image();" name="Submit" value="<?php esc_html_e( 'Update Sponser link' , 'sponsered-link');?>" class="button button-primary button-large" /></td>
            </tr>
          </tbody>
        </table>
      </form>
    </fieldset>
  </div>
</div>
<?php
}
?>
