<?php
$displayMessage = filter_input(INPUT_GET, 'display', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($displayMessage)){?><div class="updated below-h2" id="message"><p><?php echo $displayMessage ;?></p></div>
<?php }?>
<table class="wp-list-table widefat fixed posts">
  <thead>
    <tr>
      <td colspan="2"><h2><?php esc_html_e( 'Sponser Settings' , 'sponsered-link');?></h2>
        <hr /></td>
    </tr>
	<form name="oscimp_form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
	<input name="action" value="sponser_setting" type="hidden" />
    <tr>
      <td colspan="2">
          <?php wp_nonce_field('sponser_setting','setting-sponser-url'); ?>
          <table>
            <h3><?php esc_html_e( 'Display Url' , 'sponsered-link');?></h3>
            <tr>
              <th><?php esc_html_e( 'How To want display number of sponsered link on front page' , 'sponsered-link');?></th>
            </tr>
            <tr>
              <td><input type="text" name="sponser_text" id="sponser_text" value="<?php echo get_option('sponsersetting'); ?> " required="required">
                </td>
            </tr>
          </table>
        </td>
    </tr>
    <tr>
      <td colspan="2">
          <?php wp_nonce_field('sponser_pagination','setting-sponser-pagination'); ?>
          <table>
            <h3><?php esc_html_e( 'Pagination Setting' , 'sponsered-link');?></h3>
            <tr>
              <td><input type="text" name="sponser_pagination" id="sponser_pagination" value="<?php echo get_option('sponserpagination'); ?> " required="required"/>
                </td>
            </tr>
          </table>
        </td>
    </tr>
	<tr>
      <td colspan="2">
          <?php wp_nonce_field('sponser_view','setting-sponser-view'); ?>
          <table>
            <h3><?php esc_html_e( 'View Setting' , 'sponsered-link');?></h3>
			<tr>
              <th><?php esc_html_e( 'How To want display sponsered' , 'sponsered-link');?></th>
            </tr>
            <tr>
              <td><select name="sponser_view" id="sponser_view">
				<option value="list" <?php if(get_option('sponserview') == 'list'){ echo 'selected'; } ?>>List</option>
				<option value="grid"<?php if(get_option('sponserview') == 'grid'){ echo 'selected'; } ?>  >Grid</option>
				</select>
				</td>
            </tr>
          </table>
       </td>
    </tr>
	<tr><td><input type="submit" name="custom_submit"  value="<?php esc_html_e( 'Submit' , 'sponsered-link');?>" class="button button-primary button-large" /></td></tr>
	</form>
    <tr><td>
          <table>
            <h3><?php esc_html_e( 'Use Shortcode' , 'sponsered-link');?></h3>
           <tr><th><?php esc_html_e( '1. Use shortcode "[SponseredLink]" in page,post, widget.' , 'sponsered-link');?></th></tr>
            <tr><th><?php esc_html_e( "1. Use shortcode  <?php echo do_shortcode('[SponseredLink]');?> for page template files.", 'sponsered-link');?></th></tr>   
          </table>
        </form></td></tr>
    <tr> </tr>
  </thead>
</table>
