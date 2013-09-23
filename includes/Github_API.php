<?php
/*
* Github API helper class
* 
* Uses the github api to retrieve public gists, repos or commits for a specific user
*/
class Github_API{
	static function get_data($url){
        $base = "https://api.github.com/";
        $response = wp_remote_get($base . $url, array( 'sslverify' => false ));
        $response = json_decode($response['body'], true);
        return $response;
    }

    // Get the json from github for the repos
    static function get_repos($user) {
    	return self::get_data("users/$user/repos");
    }

    // Get the name of the repo that we'll use in the request url
    static function get_commits($repo, $user){
        return self::get_data("repos/$user/$repo/commits");
    }

    static function get_gists($user){
        return self::get_data("users/$user/gists");
    }
}
?>