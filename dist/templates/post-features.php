<?php
/*
Template to print the post features
*/
?>
<h3>What I did</h3>
<ol class='rectangle-list'>
<?php
	$features = get_the_terms(get_the_ID(), get_post_type().'-features');
	if(is_array($features)) foreach($features as $feature){
		echo "<li><a>".$feature->name."</a></li>";
	}
?>
</ol>