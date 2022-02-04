<?php  
 $connect = mysqli_connect("localhost", "root", "", "medical");  
 if(isset($_POST["submit"]))  
 {  
      if(!empty($_POST["search"]))  
      {  
           $query = str_replace(" ", "+", $_POST["search"]);  
           header("location:hosp.php?search=" . $query);  
      }  
 }
 ?>
<?php
$http_client_ip = getenv('HTTP_CLIENT_IP');
$http_x_forwarded_for = getenv('HTTP_X_FORWARDED_FOR');
$remote_addr = getenv('REMOTE_ADDR');
if(!empty($http_client_ip)){
	$ip_address = $http_client_ip;
}else if(!empty($http_x_forwarded_for)){
	$ip_address = $http_x_forwarded_for;
}else{
	$ip_address = $remote_addr;
}
//echo $ip_address.'<br/>';
//$ip_parts = explode('.', $ip_address);
$ip_parts = explode('.', "41.204.187.5");
$ip_number = ((256*256*256*$ip_parts[0])+ (256*256*$ip_parts[1])+ (256*$ip_parts[2])+ $ip_parts[3]);
//echo $ip_number.'<br/>';
$query = "SELECT * FROM kenya WHERE ip_from <'$ip_number' AND ip_to > '$ip_number'";
$location_result=mysqli_query($connect, $query);
if(mysqli_num_rows($location_result)==1){
	while($row_location = mysqli_fetch_array($location_result)){
		?>
		<br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center">View Nearby Hospitals</h3><br />  
                <form method="post">  
                     <label>Your Location is</label>  
                     <input type="text" name="search" class="form-control" value="<?php echo $row_location['city_name']; ?>" />  
                     <br />  
                     <input type="submit" name="submit" class="btn btn-info" value="View Nearby Hospitals" />  
                </form>  <?php
	//echo '<tr><td>'.$row_location["city_name"].'</td><td><br />'.$row_location["country_name"].'</td></tr>';
}
}
else
{
	 //echo 'Invalid Location';
 }
						  

					 ?>
					 
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>HELTH CARE APP</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
             
                <div class="container" style="width:700px;">  
                     <table class="table table-bordered">  
                     <?php  
                     if(isset($_GET["search"]))  
                     {  
                          $condition = '';  
                          $query = explode(" ", $_GET["search"]);  
                          foreach($query as $text)  
                          {  
                               $condition = "location LIKE '%".mysqli_real_escape_string($connect, $text)."%' OR ";  
                          }  
                          $condition = substr($condition, 0, -4);  
                          $sql_query = "SELECT * FROM hospital WHERE " . $condition;  
                          $result = mysqli_query($connect, $sql_query);
						  if(mysqli_num_rows($result)>0)
						  {
							  echo '<tr><th>Hospital Name </th><th>Address</th><th>Working Hours</th></tr>';
						  }
						 
						  if(mysqli_num_rows($result)>0)
						  {
							  while($row = mysqli_fetch_assoc($result))
							  {
								  echo '<tr><td>'.$row["name"].'</td><td>'.$row["address"].'</td><td>'.$row["workinghrs"].'</td></tr>';
							  }
						  }
						  else
						  {
							  echo '<label>No Hospitals in your Location</label>';
						  }
                                              }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  