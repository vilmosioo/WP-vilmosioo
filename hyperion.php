<?php
/*
* This code displays the latest commits of Hyperion as a list
*/
echo "<h2>Latest updates</h2><ul>";
$commits = array_slice(Github_API::get_commits("Hyperion", "vilmosioo"), 0, 5);
foreach($commits as $commit){
	$url = 'https://github.com/vilmosioo/Hyperion/commit/'.$commit['sha'];
	$commit = $commit['commit'];
	$date = date("d M Y", strtotime($commit['committer']['date']));
	$msg = $commit['message'];
	echo "<li><span class='meta'>$date</span> <a href='$url' title='$msg'>$msg</li>";
}	
echo '</ul>';
?>