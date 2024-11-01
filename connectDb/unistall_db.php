<?php 
function sponser_deactivate() {
   global $wpdb;  
  /**
    * Create new table structure on plugin activate
   */
    $table_name = "sponser_link";
    $delete_table="DROP table `".$wpdb->prefix.$table_name."` ";					
    $wpdb->query($delete_table);
  
  /**
   * When you will activate you plugin then
   * Following array values will create in option_name fields in wp_option table
  */ 
  delete_option( 'sponsersetting' );
  delete_option( 'sponserpagination' );
  delete_option( 'sponserview' );
  
}
?>