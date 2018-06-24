<?php
					echo "in form 4";
					if(isset($_POST['submit1'])){//to run PHP script on submit
						if(!empty($_POST['check_list1'])){
					// Loop to store and display values of individual checked checkbox.
							foreach($_POST['check_list1'] as $selected){
								echo $selected."</br>";
					}
				}
			}
	?>