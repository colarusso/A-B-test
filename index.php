<?php
/*
  Plugin Name: A-B Test
  Description: Enables shortcode hook for a hard-coded A-B test.
  Author: David Colarusso
  Author URI: http://www.davidcolarusso.com
 */
 
 /**
 * Usage: [AB]
 *
 * Displays a random content block from locally-stored files.
 * See readme.md in this directory for instructions on how to 
 * edit and add to these files (located in "./options/") plus 
 * how to tie in a local DB and track user actions via AJAX. 
 **/ 
 
function AB_test() {
	
	# ========================================================
	#             DISPLAY RANDOM CONTENT BLOCK
	# ========================================================
	
	# Scan the directory ./options/ to find the names of 
	# content files. Place these names into an array. 
	# Filter array to exclude any directories.
	$indir = scandir(dirname(__FILE__) . './options/');
	# Count the number of entries in the array ($n).  
	$n = count ($indir);
	
	# Generate a random number between 2 and $n-1.
	# NOTE: we're counting on the fact that the only
	# directories returned on a scan of ./options/ are:
	# Array ( [0] => . [1] => .. [2] ). If this isn't
	# the case, things will BREAK.
	$x = rand ( 2, $n-1 );
	
	# Include a random file from "./options/".
	# This will cause its contents to be displayed on 
	# the page using the [AB] shortcode.
	$content = $indir[$x];
	include (dirname(__FILE__) . './options/'. $content);
	
	# Include javascript block to allow for AJAX reporting
	# of user interaction. 
	echo "\n<script type=\"text/javascript\">\n";
	include (dirname(__FILE__) . './js/log_click.js');	
	echo "\n</script>\n";
	
	# ========================================================
	#             LOG DISPLAY OF CONTENT BLOCK
	# ========================================================
	
	# Include configuration file. 
	include (dirname(__FILE__) . './lib/config.php');

	# Add content name to DB or advance displayed count if 
	# content can already be found in DB. 
	$stmt = $dbh->prepare("INSERT INTO test_results (content, displayed, clicked) VALUES(?, 1, 0) ON DUPLICATE KEY UPDATE displayed = displayed + 1");
	$stmt->execute(array($content));

}

# Adds shortcode "AB" to WP
add_shortcode('AB', 'AB_test');

?>
