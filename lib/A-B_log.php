<?php
header('Content-type: text/plain');

# Check if someone has sent parameter "c"
# if so, log a click for c;

# Returns int. if referer on same server as this.
$same = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));

# Check if parameter "c" exists and was passed from 
# same server as this file. See $same above.
if ($_POST['c'] != "" AND $same) {

	# Read value of "c" into $content
	$content = $_POST['c'];

	# Include configuration file to get DB info.
	include (dirname(__FILE__) . './config.php');
		
	# Log your click of the above cited block (i.e., $content).
	$stmt = $dbh->prepare("UPDATE test_results SET clicked = clicked + 1 WHERE content = ?");
	$stmt->execute(array($content));
	
	# report your success
	echo "logged: $content";
	
} else { 

	# report your error
	echo "error"; 

}
?>
