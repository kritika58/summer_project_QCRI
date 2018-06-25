<!DOCTYPE html>
<html lang="en">
<head>
  <title>Site Anatomy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="favicon.gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
           .heading {
         font-family: "Times New Roman", Times, serif;
         font-weight: bold;
         font-size:30px;
           }
           .desc {
         font-size: 20px;
         font-family: "Times New Roman", Times, serif;
         }
         .t_desc {
         font-size: 22px;
         font-family: "Times New Roman", Times, serif;
         }
  </style>
</head>
<center>
<div class="container">  
<h2 class="heading">Arabic Site Anatomy</h2>
<?php
   include 'dbconnection.php';
   ?>

<?php
    $total_count=$conn->query("SELECT * FROM news_english");
    $total_count_row=mysqlI_fetch_array($total_count,MYSQL_NUM);
    $total_count_val=$total_count_row[0];

    $facebook_count=$conn->query("SELECT COUNT('Facebook Page (https://www.facebook.com/)') FROM news_english");
    $facebook_count_row=mysqli_fetch_assoc($facebook_count);
    $facebook_count_val=$facebook_count_row["COUNT('Facebook Page (https://www.facebook.com/)')"];

    $twitter_count=$conn->query("SELECT COUNT(user_name) FROM news_english");
    $twitter_count_row=$twitter_count->fetch_array();
    $twitter_count_val=$twitter_count_row["COUNT(user_name)"];

    $rss_count=$conn->query("SELECT COUNT('RSS Feed link') FROM news_english");
    $rss_count_row=$rss_count->fetch_array();
    $rss_count_val=$rss_count_row["COUNT('RSS Feed link')"];

    $wiki_count=$conn->query("SELECT COUNT('Wikipedia page (https://ar.wikipedia.org/wiki/)') FROM news_english");
    $wiki_count_row=$wiki_count->fetch_array();
    $wiki_count_val=$wiki_count_row["COUNT('Wikipedia page (https://ar.wikipedia.org/wiki/)')"];

    $alexa_count=$conn->query("SELECT COUNT('Alexa page (https://www.alexa.com/siteinfo/)') FROM news_english");
    $alexa_count_row=$alexa_count->fetch_array();
    $alexa_count_val=$alexa_count_row["COUNT('Alexa page (https://www.alexa.com/siteinfo/)')"];

    $yt_count=$conn->query("SELECT COUNT('YouTube (http://www.youtube.com/)') FROM news_english");
    $yt_count_row=$yt_count->fetch_array();
    $yt_count_val=$yt_count_row["COUNT('YouTube (http://www.youtube.com/)')"];

    $gp_count=$conn->query("SELECT COUNT('GooglePlus (https://plus.google.com/)') FROM news_english");
    $gp_count_row=$gp_count->fetch_array();
    $gp_count_val=$gp_count_row["COUNT('GooglePlus (https://plus.google.com/)')"];

    $insta_count=$conn->query("SELECT COUNT('Instagram (https://www.instagram.com/)') FROM news_english");
    $insta_count_row=$insta_count->fetch_array();
    $insta_count_val=$insta_count_row["COUNT('Instagram (https://www.instagram.com/)')"];
                    
?>

<h4 class="t_desc">Social Media Profile</h4>        
  <table style="width:50%" class="desc table table-striped">
    <thead>
      <tr>
        <th>Account</th>
        <th>News Sources</th>
      </tr>
    </thead>
    <tbody>
    <tr>
         <td>Total News Sources</td>
         <td><?php $total_count_val ?></td>
    </tr>
    <tr>
         <td>Twitter Accounts</td>
         <td><?php $twitter_count_val ?></td>
    </tr>
    <tr>
         <td>Facebook Accounts</td>
         <td><?php $facebook_count_val ?></td>
    </tr>
    <tr>
         <td>Alexa Page Information</td>
         <td><?php $alexa_count_val ?></td>
    </tr>
    <tr>
         <td>Instagram Accounts</td>
         <td><?php $insta_count_val ?></td>
    </tr>
    <tr>
         <td>YouTube Accounts</td>
         <td><?php $yt_count_val ?></td>
    </tr>
    <tr>
         <td>Google Plus Accounts</td>
         <td><?php $gp_count_val ?></td>
    </tr>
    <tr>
         <td>Wikipedia Page</td>
         <td><?php $wiki_count_val ?></td>
    </tr>
    <tr>
         <td>RSS Feed</td>
         <td><?php $rss_count_val ?></td>
    </tr>

    </tbody>
</table>    

<?php
$sql_country_count="SELECT COUNT(country), country from news_english GROUP BY country ORDER BY COUNT(country) DESC";
$result_country_count = $conn->query($sql_country_count);
$i=0;
?> 
<h4 class="t_desc">News sources per country</h4>        
  <table style="width:50%" class="desc table table-striped">
    <thead>
      <tr>
        <th>Country</th>
        <th>News Sources</th>
      </tr>
    </thead>
    <tbody>
            <?php
    while ($row_country_count = $result_country_count->fetch_assoc())
        {
            $country_name[]=$row_country_count["country"];
            $country_count[]=$row_country_count["COUNT(country)"];
            
            echo "<tr>
                    <td>$country_name[$i]</td>
                    <td>$country_count[$i]</td>
                    
                    </tr>";  
        
                    $i++;
        }

    echo"</table>";                    
    ?>

    <!-- count of sources per category-->
    <?php
    $sql_category_count="SELECT COUNT(category), Category from news_english GROUP BY Category ORDER BY COUNT(category) DESC";
    $result_category_count = $conn->query($sql_category_count);
    $i=0;
    ?>
<h4 class="t_desc">News sources per category</h4>        
  <table style="width:50%" class="desc table table-striped">
    <thead>
      <tr>
        <th>Category</th>
        <th>News Sources</th>
      </tr>
    </thead>
    <tbody>
    <?php
    while ($row_category_count = $result_category_count->fetch_assoc())
        {
            $category_name[]=$row_category_count["Category"];
            $category_count[]=$row_category_count["COUNT(category)"];
            
            echo "<tr>
                    <td>$category_name[$i]</td>
                    <td>$category_count[$i]</td>
                    
                    </tr>";  
        
                    $i++;
        }

    echo"</table>";                    
    ?>
    </center>