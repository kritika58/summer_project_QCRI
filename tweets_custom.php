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
function time_elapsed_string($datetime,$present, $full = false) 
{
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
    include 'dbconnection.php';
	//$sql="SELECT * FROM tweets_ara ORDER BY tweets_ara.date DESC LIMIT 100";
	$sql="SELECT * FROM tweets_ara, ara_source_name WHERE 
	ara_source_name.source_user_name = tweets_ara.screen_name";
	//$sql ="SELECT TOP (30) * FROM Table ORDER BY date DESC";
	$result = mysqli_query($conn,$sql);
	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc()) 
		{
			$json = $row['tweet'];
			 
				
			// decode json format tweets
			$tweet=json_decode($json, TRUE);
			
?>

	<!-- TWITTER USER FEED WILL BE HERE -->
	<?php
		
		
			$now = gmdate('D M d H:i:s +0000 Y');
			//echo $now;
					
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
				echo "<img class=\"profile_img\" src='{$tweet['user']['profile_image_url_https']}' class='img-thumbnail' />";
				echo "<html>&ensp;</html>";
				echo "<a class=\"username\" href='https://twitter.com/{$row['screen_name']}'>{$tweet['user']['name']}</a> ";
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
								
				$tweet_pic;
				if (array_key_exists('media', $tweet['entities']))
				{
					// get tweet picture
					//if(array_key_exists('media_url', $tweet['entities']['media']))
					//{
						$tweet_pic= $tweet['entities']['media'][0]["media_url"];
						echo "<img class='tweet_pic' src='{$tweet_pic}' class='img-thumbnail'/>";
					//}
					
				}
				/*else 
				{
					$tweet_pic = NULL;
				}*/
				echo "</div>";
			}	
			
			
	?>
	
	<?php
	
			//echo strlen($row['tweet']).'<br>';
			//echo $row['tweet'].'<br>';
			echo '<br>';
		}
	}
?>