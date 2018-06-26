<?php
   include 'dbconnection.php';
   $sql = "SELECT * FROM news_arabic";
   $result = $conn->query($sql);
   global $my_final_sources;
   $my_final_sources=array();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>News Project</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="scroll.css">
      <link rel="stylesheet" type="text/css" href="navbar.css">
      <link rel="icon" type="image/png" href="favicon.gif">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- jQuery library -->
      <script src="libs/js/jquery.js"></script>
      <!-- bootstrap JavaScript -->
      <script src="libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="libs/js/bootstrap/docs-assets/js/holder.js"></script>
      <style>
         .heading {
         font-family: "Times New Roman", Times, serif;
         font-weight: bold;
         font-size:200%;
         float:left;
         }
         .gsize {
         font-size: 35px;
         }
         .desc {
         font-size: 20px;
         font-family: "Times New Roman", Times, serif;
         }
         .hnav {
         padding-left:0;
         margin-bottom:0;
         list-style:none
         }
         .hnav>li {
         position:relative;
         display:block
         }
         .hnav>li>a {
         position:relative;
         display:block;
         padding:10px 15px
         }
         .hnav>li>a:focus,.hnav>li>a:hover {
         text-decoration:none;
         }
         .panel-actions {
         margin-top: -20px;
         margin-bottom: 0;
         text-align: right;
         }
         .panel-actions a {
         color:#333;
         }
         .panel-fullscreen {
         display: block;
         z-index: 9999;
         position: fixed;
         width: 100%;
         height: 100%;
         top: 0;
         right: 0;
         left: 0;
         bottom: 0;
         overflow: auto;
         }
         .highlight
          {
          background: #CEDAEB;
          font-weight:bold;
          }
      </style>
      <script>
         $(document).ready(function () {
         //Toggle fullscreen
         $("#panel-fullscreen").click(function (e) {
             e.preventDefault();
             
             var $this = $(this);
         
             if ($this.children('i').hasClass('glyphicon-resize-full'))
             {
                 $this.children('i').removeClass('glyphicon-resize-full');
                 $this.children('i').addClass('glyphicon-resize-small');
             }
             else if ($this.children('i').hasClass('glyphicon-resize-small'))
             {
                 $this.children('i').removeClass('glyphicon-resize-small');
                 $this.children('i').addClass('glyphicon-resize-full');
             }
             $(this).closest('.panel').toggleClass('panel-fullscreen');
         });
         });
         
      </script>
   </head>
   <body>
      <nav class="navbar navbar-dark bg-dark justify-content-between">
         <a class="heading navbar-brand">Live News Project</a>
         <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" value="search">Search</button>
            <a class="btn btn-default my-2 my-sm-0" href="english/index.php">EN</a>
            <a class="btn btn-default my-2 my-sm-0" target="_blank" href="stats_ara.php">Statistics</a>
         </form>
      </nav>

      <div class="col-sm-3 sidenav" >
         <div style="max-height:78vh;" class= "pre-scrollable">
         <p class="desc">News<span style="float:left"><img style="width:35px;height:35px;" src="favicon.gif"></span></p>
            <ul class="nav nav-tabs">
               <li id="all" class="active"><a data-toggle="tab" href="#home">All</a></li>
               <li id="select" ><a data-toggle="tab" href="#menu1">Select</a></li>
               <li id="my_list"><a data-toggle="tab" href="#menu2">My List</a></li>
            </ul>
            <div class="tab-content">
               <div id="home" class="tab-pane fade in active">


                  <form id="form1" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                     <ul  class="desc hnav">
                        <br>
                        <center>
                           <input type="submit" class="btn btn-primary" name="select" value="Add to my list">
                        </center>
                        <br>
                        <?php
                           if ($result->num_rows > 0) {
                           // output data of each row
                               while($row = $result->fetch_assoc()) { 
                           ?>
                        <li>
                           <span><input type="checkbox" name="check_list[]" value="<?php echo $row["user_id"]?>">
                           <a href="display.php?id=<?php echo $row["user_id"]?>">
                           <?php echo $row["user_name"]?>
                           <img align="right" style="width: 40px; height:40px;" src="<?php echo $row["user_profile_image_url"]?>">
                           </span>
                           </a>
                        </li>
                        <?php
                           }}
                           ?>
                     </ul>
                  </form>
               </div>
               <div id="menu1" class="tab-pane fade msize">
                  <br>
                  <form id="form3" action="<?=$_SERVER['PHP_SELF'];?>" method="POST" >
                     <select class="form-control" name="country" required>
                     <?php 
                     $sql_country="SELECT DISTINCT country, country_code from news_arabic";
                     $result_country = $conn->query($sql_country);
                     $i=0;
                     while ($row_country = $result_country->fetch_array(MYSQLI_ASSOC))
                        {
                            $ccountry[]=$row_country["country"];
                            $ccode[]=$row_country["country_code"];
                            echo "<option value=$ccode[$i]>$ccountry[$i]</option>";  
                     $i++;
                     }                     
                     ?>                    
                     </select>
                     <br>
                     <select class="form-control" name="category" required>
                     <?php 
                     $sql_category="SELECT DISTINCT Category from news_arabic";
                     $result_category = $conn->query($sql_category);
                     $i=0;
                     while ($row_category = $result_category->fetch_array(MYSQLI_ASSOC))
                        {
                            $category[]=$row_category["Category"];
                            echo "<option value=$category[$i]>$category[$i]</option>";  
                     $i++;
                     }                     
                     ?> 
                     </select>
                     <br>
                     <center>
                        <input type="submit" name="apply" class="btn btn-primary" value="Apply">
                     </center>
                  </form>
                  <form id="form4" action="<?=$_SERVER['PHP_SELF'];?>" method="POST" >
                  <br>
                     <center>
                        <input type="submit" name="add" class="btn btn-primary" value="Add to my list">
                     </center>
                     <?php if(isset($_POST['apply'])){ ?>
                     <script>
                        $(document).ready(function() {
                        
                          $("#home").removeClass();
                          $("#menu1").removeClass();
                          $("#menu2").removeClass();
                          $("#all").removeClass();
                          $("#select").removeClass();
                          $("#my_list").removeClass();
                        
                        $("#menu1").addClass("tab-pane fade in active");
                        $("#home").addClass("tab-pane fade msize");
                        $("#menu2").addClass("tab-pane fade msize");
                        
                        $("#select").addClass("active");                
                        
                        });
                     </script>
                     <?php } ?>
                     <?php if(isset($_POST['select'])){ ?>
                     <script>
                        $(document).ready(function() {
                        
                          $("#home").removeClass();
                          $("#menu1").removeClass();
                          $("#menu2").removeClass();
                          $("#all").removeClass();
                          $("#select").removeClass();
                          $("#my_list").removeClass();
                        
                        $("#menu2").addClass("tab-pane fade in active");
                        $("#home").addClass("tab-pane fade msize");
                        $("#menu1").addClass("tab-pane fade msize");
                        
                        $("#my_list").addClass("active");                
                        
                        });
                     </script>
                     <?php } ?>
                     <?php if(isset($_POST['add'])){ ?>
                     <script>
                        $(document).ready(function() {
                        
                          $("#home").removeClass();
                          $("#menu1").removeClass();
                          $("#menu2").removeClass();
                          $("#all").removeClass();
                          $("#select").removeClass();
                          $("#my_list").removeClass();
                        
                        $("#menu2").addClass("tab-pane fade in active");
                        $("#home").addClass("tab-pane fade msize");
                        $("#menu1").addClass("tab-pane fade msize");
                        
                        $("#my_list").addClass("active");                
                        
                        });
                     </script>
                     <?php } ?>
                     <?php if(isset($_POST['delete'])){ ?>
                     <script>
                        $(document).ready(function() {
                        
                          $("#home").removeClass();
                          $("#menu1").removeClass();
                          $("#menu2").removeClass();
                          $("#all").removeClass();
                          $("#select").removeClass();
                          $("#my_list").removeClass();
                        
                        $("#menu2").addClass("tab-pane fade in active");
                        $("#home").addClass("tab-pane fade msize");
                        $("#menu1").addClass("tab-pane fade msize");
                        
                        $("#my_list").addClass("active");                
                        
                        });
                     </script>
                     <?php } ?>
                     <?php 
                        if(isset($_POST['apply'])){
                        $selected_country = $_POST['country'];
                        $selected_category = $_POST['category'];
                        $sql1 = "SELECT * FROM news_arabic WHERE country_code='".$selected_country."' AND Category='".$selected_category."' ";
                        $result1 = $conn->query($sql1);
                        //echo '<p class=\'desc\'>You have selected '.mysqli_num_rows($result1).' sources from '.$country_name.' in '.$selected_category.' category.</p>';
                        if ($result1->num_rows > 0) {
                        echo "<ul  class='desc hnav'>";		
                        $i=0;
                        while ($row1 = $result1->fetch_array(MYSQLI_ASSOC))
                        {
                            $uname[]=$row1["user_name"];
                            $id[]=$row1["user_id"];
                            $img[]=$row1["user_profile_image_url"];
                            echo "<li>";
                            echo "<span><input type=\"checkbox\" name=\"check_list1[]\" value=$id[$i]>
                            <a href=\"display.php?id=$id[$i]?>\">$uname[$i]
                            <img align=\"right\" style=\"width: 40px; height:40px;\" src=$img[$i]>
                            </span>
                            </a>
                            </li>";  
                     $i++;
                     }
                    }
                    else {
                      echo "<p class='desc'>No match found.</p>";
                    }
                     }
                     echo "</ul>";
                  ?>
                  </form>
               </div>
               <div id="menu2" class="tab-pane fade msize">
                  <br>
                  <form id="form_del" action="<?=$_SERVER['PHP_SELF'];?>" method="POST" > 
                  <?php 
                     if(isset($_POST['select'])){
                       if(!empty($_POST['check_list'])){
                         foreach($_POST['check_list'] as $selected){
                          $selected = mysqli_real_escape_string($conn,$selected);
                         $sql = "INSERT INTO my_sources_ar (us_id)
                         VALUES ('".$selected."')";
                     
                         $result = mysqli_query($conn,$sql);
                         }                
                       }
                       
                         $sql_f = "SELECT * FROM my_sources_ar,news_arabic WHERE my_sources_ar.us_id=news_arabic.user_id";
                           $result_f = mysqli_query($conn,$sql_f);
                     
                           if ($result_f->num_rows > 0) {
                             // output data of each row
                             echo "<ul  class='desc hnav'>";
                                 while($row_f = $result_f->fetch_assoc()) { 
                     
                     
                           $uname_f=$row_f["user_name"];
                           $id_f=$row_f["user_id"];
                           $img_f=$row_f["user_profile_image_url"];
                           echo "<li>";
                           echo "<span><input type=\"checkbox\" name=\"check_list_f[]\" value=$id_f checked>
                           <a href=\"display.php?id=$id_f?>\">$uname_f
                          <img align=\"right\" style=\"width: 40px; height:40px;\" src=$img_f>
                          </span>
                          </a>
                          </li>";  
                  }
                  }
                  $q1="SELECT * FROM my_sources_ar";
                  $r1= mysqli_query($conn,$q1);
                  if ($r1->num_rows >0) {
                    while ($row1= $r1->fetch_assoc()) {
                      $s_id=$row1["us_id"];
                      $q2="SELECT user_screen_name FROM news_arabic WHERE user_id='".$s_id."' ";
                      $r2= mysqli_query($conn,$q2);
                      if ($r2->num_rows >0) {
                        while ($row2=$r2->fetch_assoc()) {
                          $s_user_name= $row2["user_screen_name"];
                          $sql = "INSERT INTO ara_source_name (source_user_name,source_user_id) VALUES ('".$s_user_name."', '".$s_id."')";
                                    $result = mysqli_query($conn,$sql);
                
                        }
                      }
                
                    }
                  }
                  }
                  ?>
                  <?php 
                     if(isset($_POST['add'])){
                       if(!empty($_POST['check_list1'])){
                           foreach($_POST['check_list1'] as $selected){
                            $selected = mysqli_real_escape_string($conn,$selected);
                             $sql = "INSERT INTO my_sources_ar (us_id)
                             VALUES ('".$selected."')";
                         
                             $result = mysqli_query($conn,$sql);
                         
                         }
                           $sql_f = "SELECT * FROM my_sources_ar,news_arabic WHERE my_sources_ar.us_id=news_arabic.user_id";
                             $result_f = mysqli_query($conn,$sql_f);
                     
                             if ($result_f->num_rows > 0) {
                               // output data of each row
                               echo "<ul  class='desc hnav'>";
                                   while($row_f = $result_f->fetch_assoc()) { 
                     
                     
                             $uname_f=$row_f["user_name"];
                             $id_f=$row_f["user_id"];
                             $img_f=$row_f["user_profile_image_url"];
                             echo "<li>";
                             echo "<span><input type=\"checkbox\" name=\"check_list_f[]\" value=$id_f checked>
                             <a href=\"display.php?id=$id_f?>\">$uname_f
                            <img align=\"right\" style=\"width: 40px; height:40px;\" src=$img_f>
                            </span>
                            </a>
                            </li>";  
                  }
                  }
                  }
                  $truncate= mysqli_query($conn,"TRUNCATE TABLE ara_source_name");
                  $q1="SELECT * FROM my_sources_ar";
                  $r1= mysqli_query($conn,$q1);
                  if ($r1->num_rows >0) {
                    while ($row1= $r1->fetch_assoc()) {
                      $s_id=$row1["us_id"];
                      $q2="SELECT user_screen_name FROM news_arabic WHERE user_id='".$s_id."' ";
                      $r2= mysqli_query($conn,$q2);
                      if ($r2->num_rows >0) {
                        while ($row2=$r2->fetch_assoc()) {
                          $s_user_name= $row2["user_screen_name"];
                          $sql = "INSERT INTO ara_source_name (source_user_name,source_user_id) VALUES ('".$s_user_name."', '".$s_id."')";
                                    $result = mysqli_query($conn,$sql);
                
                        }
                      }
                
                    }
                  }
                  }
                  ?>                  
                  <br>
                  <center>
                     <input type="submit" name="delete" class="btn btn-danger" value="Delete">
                  </center>
                  </form>
                  <?php 
                     if(isset($_POST['delete'])){
                      $r= mysqli_query($conn,"TRUNCATE TABLE my_sources_ar");
                       if(!empty($_POST['check_list_f'])){                         
                           foreach($_POST['check_list_f'] as $selected){
                            $selected = mysqli_real_escape_string($conn,$selected);
                             $sql = "INSERT INTO my_sources_ar (us_id)
                             VALUES ('".$selected."')";
                         
                             $result = mysqli_query($conn,$sql);
                         
                         }
                           $sql_f = "SELECT * FROM my_sources_ar,news_arabic WHERE my_sources_ar.us_id=news_arabic.user_id";
                             $result_f = mysqli_query($conn,$sql_f);
                     
                             if ($result_f->num_rows > 0) {
                               // output data of each row
                               echo "<ul  class='desc hnav'>";
                                   while($row_f = $result_f->fetch_assoc()) { 
                     
                     
                             $uname_f=$row_f["user_name"];
                             $id_f=$row_f["user_id"];
                             $img_f=$row_f["user_profile_image_url"];
                             echo "<li>";
                             echo "<span><input type=\"checkbox\" name=\"check_list_f[]\" value=$id_f checked>
                             <a href=\"display.php?id=$id_f?>\">$uname_f
                            <img align=\"right\" style=\"width: 40px; height:40px;\" src=$img_f>
                            </span>
                            </a>
                            </li>";  
                  }
                  }
                  }
                  $truncate= mysqli_query($conn,"TRUNCATE TABLE ara_source_name");
                  $q1="SELECT * FROM my_sources_ar";
                  $r1= mysqli_query($conn,$q1);
                  if ($r1->num_rows >0) {
                    while ($row1= $r1->fetch_assoc()) {
                      $s_id=$row1["us_id"];
                      $q2="SELECT user_screen_name FROM news_arabic WHERE user_id='".$s_id."' ";
                      $r2= mysqli_query($conn,$q2);
                      if ($r2->num_rows >0) {
                        while ($row2=$r2->fetch_assoc()) {
                          $s_user_name= $row2["user_screen_name"];
                          $sql = "INSERT INTO ara_source_name (source_user_name,source_user_id) VALUES ('".$s_user_name."', '".$s_id."')";
                                    $result = mysqli_query($conn,$sql);
                
                        }
                      }
                
                    }
                  }
                  }
                  ?>
               </div>
            </div>
         </div>
         <hr>
      </div>
      <!-- PAGE CONTENT and PHP CODE WILL BE HERE -->  
      <div class="col-sm-9">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">News Feed</h3>
               <ul class="list-inline panel-actions">
                  <li><a href="#" id="panel-fullscreen" role="button" title="Toggle fullscreen">
                     <i class="glyphicon glyphicon-resize-full"></i></a>
                  </li>
               </ul>
            </div>
            <div class="panel-body">
               <!-- <a style="width:100%;background-color: gray;" href="manage.php" 
                  class="btn btn-primary btn-block" role="button">Manage Your Sources</a> -->


                <?php
                if(isset($_POST['delete'])){
                include 'tweets_custom.php';
                }
                else if(isset($_POST['select'])){
                  echo "select";
                  include 'tweets_custom.php';
                  }
                else if(isset($_POST['add'])){
                    include 'tweets_custom.php';
                    }
                    else {
                      include 'tweets.php';
                    }

                ?>
            </div>
         </div>
      </div>
      <!-- call tweets.php -->
      </div> <!-- end <div class="container"> -->	 
      </div>
   </body>
</html>