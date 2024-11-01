<?php 
function sponser_activate() {
   global $wpdb;  
  /**
    * Create new table structure on plugin activate
   */
  $table_name = "sponser_link";
  $create_table = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix.$table_name."` (
					`id` INT( 20 ) NOT NULL AUTO_INCREMENT ,
					`title` VARCHAR( 200 ) NOT NULL ,
					`link` VARCHAR( 200 ) NOT NULL ,
					`created` VARCHAR( 200 ) NOT NULL ,
					`publish` VARCHAR( 200 ) NOT NULL ,
					`target` VARCHAR( 200 ) NOT NULL ,
					`image` TEXT NOT NULL ,
					 PRIMARY KEY ( `id` )
					) ENGINE = MYISAM";
  $wpdb->query($create_table);
    add_option( 'sponsersetting', '10' ); /*sponser display on front page*/
    add_option( 'sponserpagination', '10' ); /*sponser pagination */
	add_option( 'sponserview', '10' ); /*sponser view show on frontend */
	
}
?>