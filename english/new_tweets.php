<style>
.profile_img {
    width:35px;
    height:35px;
    display:inline-block;
}
.username {
    font-size: 18px;
    font-weight:bold;
    color:gray;
    font-family: "Times New Roman", Times, serif;
    display: inline-block;
}
.tweet {
    font-size: 23px;
    font-family: "Times New Roman", Times, serif;    
    display: inline-block;
}
.tweet_time {
    font-size: 18px;
    color:gray;
    font-family: "Times New Roman", Times, serif;            
    display:inline-block;
}
.div_tweet {
    border: 3px #eee solid;
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

//$command = escapeshellcmd('/usr/custom/test.py');
//$output = shell_exec($command);
//echo $output;

?>
<!-- TWITTER USER PROFILE INFORMATION WILL BE HERE -->
<?php
function time_elapsed_string($datetime, $present, $full = false)
{
    $now  = new DateTime($present);
    $ago  = new DateTime($datetime);
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
        's' => 'second'
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    
    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

   
<?php
include 'dbconnection.php';
echo "connected<br>";
$sql = "SELECT * FROM tweets_eng,eng_source_name WHERE tweets_eng.screen_name=eng_source_name.source_user_name ORDER BY tweets_eng.date DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    echo "num_rows>0";
    while ($row = $result->fetch_assoc()) {
        echo "in while <br><br>";
        $json = $row['tweet'];
        
        
        // decode json format tweets
        $tweet = json_decode($json, TRUE);
        
        libxml_use_internal_errors(true);
        
        $now = gmdate('D M d H:i:s +0000 Y');
        //echo $now;
        
        // get tweet text
        $tweet_text = $tweet['text'];
        
        $org_tweet_text = $tweet_text;
        // make links clickable
        $tweet_text     = preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1" target="_blank">... &nbsp;</a>', $tweet_text);
        
        if (array_key_exists('urls', $tweet['entities'])) {
            if (array_key_exists(0, $tweet['entities']['urls'])) {
                $tweet_url = $tweet['entities']['urls'][0]['expanded_url'];
            }
        } else {
            $tweet_url = NULL;
        }
        
        
        //$tweet_text=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', ' ', $tweet_text );
        
        // filter out the retweets                         
        if (preg_match('/^RT/', $tweet_text) == 0) {
            echo "<div class=\"div_tweet\">";
            
            
            // show name and screen name
            echo "<img class=\"profile_img\" src='{$tweet['user']['profile_image_url_https']}' class='img-thumbnail' />";
            echo "<html>&ensp;</html>";
            echo "<p class=\"username\">{$tweet['user']['name']}</p> ";
            //echo "<span class='color-gray'>@{$screen_name}</span>";
            
            
            // output
            if ($tweet_url != NULL) {
                $article = new DOMDocument;
                
                // enable user error handling
                libxml_use_internal_errors(true);
                
                $article->loadHTMLFile($tweet_url);
                //echo $article; 
                //var_dump($article);
                $titles = $article->getElementsByTagName("title");
                //foreach($titles as $title)
                //{ 
                
                echo "<h4 class='margin-top-4px'>";
                echo "<p class=\"tweet\">$titles[0]->nodeValue &nbsp;</p>";
                echo "<a href='{$tweet_url}'>...</a> ";
                echo "</h4>";
                //echo $title->nodeValue, PHP_EOL; 
                //echo nl2br("\n "); 
                //}
            } else {
                echo "<h4 class='margin-top-4px'>";
                echo "<p class=\"tweet\">$tweet_text</p>";
                echo "</h4>";
            }
            
            // get tweet time
            $tweet_time = $tweet['created_at'];
            //echo $tweet_time;
            //echo nl2br("\n ");
            
            $t_time = time_elapsed_string($tweet_time, $now);
            echo "<p class='tweet_time'>$t_time &nbsp; ($tweet_time)</p>";
            echo nl2br("\n ");
            
            if ($tweet_url != NULL) {
                $page_content = file_get_contents($tweet_url);
                
                $dom_obj = new DOMDocument();
                
                libxml_use_internal_errors(true);
                
                
                $dom_obj->loadHTML($page_content);
                $meta_val = null;
                
                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('property') == 'og:image') {
                        $meta_val = $meta->getAttribute('content');
                    }
                }
                echo "<img class='tweet_pic' src='{$meta_val}' class='img-thumbnail'/>";
            } else if (array_key_exists('media', $tweet['entities'])) {
                // get tweet picture
                //if(array_key_exists('media_url', $tweet['entities']['media']))
                //{
                $tweet_pic = $tweet['entities']['media'][0]["media_url"];
                echo "<img class='tweet_pic' src='{$tweet_pic}' class='img-thumbnail'/>";
                //}
            }
            echo "</div>";
        }
        
        
        
        //echo strlen($row['tweet']).'<br>';
        //echo $row['tweet'].'<br>';
        echo '<br>';
    }
}
?>