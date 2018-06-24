<style>
.profile_img {
	width:35px;
	height:35px;
	display:inline-block;
}
.username {
	font-size: 25px;
	font-weight:bold;
    font-family: "Times New Roman", Times, serif;
	display: inline-block;
}
.tweet {
	font-size: 20px;
    font-family: "Times New Roman", Times, serif;	
	display: inline-block;
}
.tweet_time {
	font-size: 18px;
    font-family: "Times New Roman", Times, serif;			
	display:inline-block;
}
.div_tweet {
	border: 1px #eee solid;
	min-height: 100px;
	overflow: auto;
}
.tweet_pic {
	margin: 10px 10px;
	width:250px;
	height:150px;
	top:0%;
	float:right;
	display: inline-block;
	vertical-align:top;
}
</style>
<?php 

$command = escapeshellcmd('/usr/custom/test.py');
$output = shell_exec($command);
echo $output;

?>
<!-- TWITTER USER PROFILE INFORMATION WILL BE HERE -->
<?php
function time_elapsed_string($datetime,$present, $full = false) {
   $now = new DateTime($present);
   $ago = new DateTime($datetime);
   $diff = $now->diff($ago);

   $diff->w = floor($diff->d / 7);
   $diff->d -= $diff->w * 7;

   $string = array(
       'y' => 'year',
       'm' => 'month',
       'w' => 'week',
       'd' => 'day',
       'h' => 'hour',
       'i' => 'minute',
       's' => 'second',
   );
   foreach ($string as $k => &$v) {
       if ($diff->$k) {
           $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
       } else {
           unset($string[$k]);
       }
   }

   if (!$full) $string = array_slice($string, 0, 1);
   return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

<?php   	
// keys from your app
	$oauth_access_token = "996826218476462080-LlaSHEx8sxfmF1F5i7zqw0hBZhoze6b";
	$oauth_access_token_secret = "sTYW7SLuzzb2gL46a9WVmp7hzPV3GDLuExYkstPjXbPUX";
	$consumer_key = "SJYzdTnGW3ErTGlkdY7jlzccF";
	$consumer_secret = "dPBbgksauakXZjZjMbUYyn5Rt7Auo9lI49pHfip9sX5WHz83M3";

	// we are going to use "user_timeline"
	$twitter_timeline = "user_timeline";
	
	// specify number of tweets to be shown and twitter username
	// for example, we want to show 20 of Taylor Swift's twitter posts
	$request = array(
						'count' => '20',
						'screen_name' => 'nytimes' 
	);
	
	// put oauth values in one oauth array variable
	$oauth = array(
	'oauth_consumer_key' => $consumer_key,
	'oauth_nonce' => time(),
	'oauth_signature_method' => 'HMAC-SHA1',
	'oauth_token' => $oauth_access_token,
	'oauth_timestamp' => time(),
	'oauth_version' => '1.0'
	);
	
	// combine request and oauth in one array
	$oauth = array_merge($oauth, $request);
		
	// make base string
	$baseURI="https://api.twitter.com/1.1/statuses/$twitter_timeline.json";
	$method="GET";
	$params=$oauth;
		
	$r = array();
	ksort($params);
	foreach($params as $key=>$value){
		$r[] = "$key=" . rawurlencode($value);
	}
	$base_info = $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
		
	// get oauth signature
	$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
	$oauth['oauth_signature'] = $oauth_signature;
	
	// make request
	// make auth header
	$r = 'Authorization: OAuth ';
		
	$values = array();
	foreach($oauth as $key=>$value){
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
	}
	$r .= implode(', ', $values);
		
	// get auth header
	$header = array($r, 'Expect:');
		
	// set cURL options
	$options = array(
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_HEADER => false,
		CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?". http_build_query($request),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => true
	);
	// retrieve the twitter feed
	$feed = curl_init();
	curl_setopt_array($feed, $options);
	$json = curl_exec($feed);
	curl_close($feed);
		
	// decode json format tweets
	$tweets=json_decode($json, true);
	
	// show user information
	//echo "<div class='overflow-hidden'>";
		
		// user data
		$profile_photo= $tweets[0]['user']['profile_image_url_https'];
		$name=$tweets[0]['user']['name'];
		$screen_name=$tweets[0]['user']['screen_name'];
		
		
		// show other information about the user
		//echo "<div class='text-align-center'>";
			//echo "<div><h2>{$name}</h2></div>";
			//echo "<div><a href='https://twitter.com/{$screen_name}' target='_blank'>@{$screen_name}</a></div>";
		//echo "</div>";
			
		//echo "<hr />";
	//echo "</div>";
?>
<div>
	<!-- TWITTER USER FEED WILL BE HERE -->
	<?php
		$statuses_count=$tweets[0]['user']['statuses_count'];
		$followers_count=$tweets[0]['user']['followers_count'];
		$now = gmdate('D M d H:i:s +0000 Y');
		$mytweets = fopen("tweets.csv", "w");
		
		// show tweets
		foreach($tweets as $tweet)
		{				
			// show a tweet
			//echo "<div class='overflow-hidden'>";		
					
				// show tweet content
				//echo "<div class='tweet-text'>";				
						
					// show tweet text
					//echo "<div class='margin-zero'>";				
						
						// get tweet text
						$tweet_text=$tweet['text'];					
							
						// make links clickable
						$tweet_text=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1" target="_blank">Read More &nbsp;</a>', $tweet_text);
						//$tweet_text=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', ' ', $tweet_text );
												
						// filter out the retweets 						
						if(preg_match('/^RT/', $tweet_text) == 0)
						{							
							// show name and screen name
							echo "<div class=\"div_tweet\">";
							echo "<h4 class='margin-top-4px'>";
								echo "<img class=\"profile_img\" src='{$profile_photo}' class='img-thumbnail' />";
								echo "<html>&ensp;</html>";
								echo "<a class=\"username\" href='https://twitter.com/{$screen_name}'>{$name}</a> ";
								//echo "<span class='color-gray'>@{$screen_name}</span>";
								
							echo "</h4>";
							
							// get tweet time
							$tweet_time = $tweet['created_at'];
                                        
							//echo $tweet_time;
							//echo nl2br("\n ");
						
							$t_time= time_elapsed_string($tweet_time,$now);
							echo "<p class='tweet_time'>$t_time</p>";
							echo nl2br("\n ");
							
							// output
							echo "<p class=\"tweet\">$tweet_text</p>";
							$tweet_text = str_replace("\n"," ",$tweet_text);
							
							$tweet_pic;
							if (array_key_exists('media', $tweet['entities']))
							{
								// get tweet picture
								$tweet_pic = $tweet['entities']['media'][0]['media_url_https'];
								echo "<img class='tweet_pic' src='{$tweet_pic}' class='img-thumbnail'/>";
							}
							else 
							{
								$tweet_pic = NULL;
							}
							
							fwrite($mytweets, $screen_name);
							fwrite($mytweets, "\t");
							fwrite($mytweets, $tweet_time);
							fwrite($mytweets, "\t");
							fwrite($mytweets, $tweet_text);
							fwrite($mytweets, "\t");
							fwrite($mytweets, $tweet_pic);
							fwrite($mytweets, "\n");
							echo "</div>";
						}
						
					//echo "</div>";
				//echo "</div>";
					
			//echo "</div>";
		}
		fclose($mytweets);
	?>
</div> <!-- end <div class="col-lg-8"> -->
