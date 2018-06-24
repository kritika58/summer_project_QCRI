<?php
function form3() {
	include 'dbconnection.php';
    if(isset($_POST['apply'])){
        $selected_country = $_POST['country'];
        $selected_category = $_POST['category'];
        $sql = "SELECT * FROM news_arabic WHERE country_code='".$selected_country."' AND Category='".$selected_category."' ";
        $result1 = $conn->query($sql);
        echo ''.mysqli_num_rows($result1);
    
    echo "<ul  class='nav nav-pills nav-stacked'>";		
        $i=0;
        while ($row = $result1->fetch_array(MYSQLI_ASSOC))
        {
            $uname[]=$row["user_name"];
            $id[]=$row["user_id"];
            $img[]=$row["user_profile_image_url"];
        echo "<li>";
        echo "<span><input type=\"checkbox\" name=\"check_list1[]\" value=$uname[$i]>
        <a href=\"display.php?id=$id[$i]?>\">$uname[$i]</span>
        <img align=\"right\" style=\"width: 40px; height:40px;\" src=$img[$i]>
        </a>
    </li>";  
    $i++;
    }
    echo "</ul>";
echo "<br>";
    }
}