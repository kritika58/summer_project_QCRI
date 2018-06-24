<?php
include 'dbconnection.php';
$sql="SELECT * FROM tweets WHERE screen_name='BBCArabic'";
$result = mysqli_query($conn,$sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) { 
        echo $row['screen_name'].'<br>';
        echo '<br>';
        echo $row['tweet'].'<br>';
        echo '<br>';
    }
}

?>