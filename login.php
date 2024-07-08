<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");

$db = new Database();
$fm = new Formate();

include("lib/function.php");
include("lib/session.php");
Session::init(); 

?> 

<?php
if(Session::get('login') == true){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Yarn & Cotton Management System </title>

	<!-- Data Table-->	 
	<link rel='stylesheet' href='css/dataTables.bootstrap.min.css'> 
	<link rel='stylesheet' href='css/datatables.min.css'> 
	<link rel='stylesheet' href='css/responsive.bootstrap5.min.css'> 
	<!-- End Data Table--> 
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"  /> 
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<link href="css/mainstyle.css" rel="stylesheet"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
 </head>
<body>
<!--  Request me for a signup form or any type of help  -->


				<?php
				if($_SERVER['REQUEST_METHOD'] == 'POST') {
						$username = $fm->validation(trim($_POST['username']));
						$password = $fm->validation(trim($_POST['password']));

						$username = mysqli_real_escape_string($db->link, $username);
						$password = mysqli_real_escape_string($db->link, $password);

						$query = "SELECT * FROM admin_user WHERE username = '$username'";
						$results = $db->select($query);

						if($results != false) {
							$value = mysqli_fetch_array($results);
							$rows = mysqli_num_rows($results);
							if($rows > 0 && password_verify($password, $value['password'])) {
								// Set session variables
								Session::set("login", true);
								Session::set("username", $value['username']);
								Session::set("user_id", $value['name']);
								Session::set("first_name", $value['first_name']);
								Session::set("last_name", $value['last_name']);
								Session::set("role", $value['role']);

								// Remember Me functionality
								if(isset($_POST['remember'])) {
									// Set cookies for username and password with 30-day expiry
									setcookie('remember_username', $username, time() + (86400 * 30), '/');
									setcookie('remember_password', $password, time() + (86400 * 30), '/');
								}

								// Redirect user to index.php
								header("Location: index.php");
								exit();
							} else {
								$error = "Invalid username or password";
							}
						} else {
							$error = "No Results Found";
						}
					}
					?>

			<div class="login-form">  						
				<form action="" method="post">
					<div class="avatar">
						<image src="images/logo.png" style="width:70px; backround:#1175B9;">
					</div>
					
					<div class="form-group">
						<span style="font-weight:bold;"> Username</span>
						<input type="text" name="username"class="form-control" placeholder="Enter Username" required="required">
					</div>
					<div class="form-group">
						<span style="font-weight:bold;"> Password:</span>
						<input type="password" name="password" class="form-control" placeholder="Enter Password" required="required">
					</div>
					<div class="form-group">
						<input type="checkbox" name="remember"> Remember Me
					</div>
					<input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">              
				</form>			

			</div> 
 
<!--footer Area--> 

<div class="fixed_footer"> 
	Software Design & Developed By Ibrahim Ali
</div> 
<!--End Main Part--> 

</main> 
	<script src="js/sidebars.js"></script>
	<script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/datatables.min.js"></script>
   
    <script src="js/script.js"></script>
	
	
	<!-- Data Table 
	cdn 
	<script src='https://code.jquery.com/jquery-3.5.1.js'></script>
	
	<script src='https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js'></script>
	<script src='https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js'></script>
	<script src='https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js'></script>
	<script src='https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js'></script>
	<!--End Data Table  -->
	
	<!-- Data Table  -->
	<script src='js/jquery-3.5.1.js'></script>	
	<script src='js/jquery.dataTables.min.js'></script>
	<script src='js/dataTables.bootstrap5.min.js'></script>
	<script src='js/dataTables.responsive.min.js'></script>
	<script src='js/responsive.bootstrap5.min.js'></script>
	<!--End Data Table  -->
	
	<!-- Select2 -->
	<script src="js/select2.full.min.js"></script>
	<script>
	  $(function () {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs5').select2({
		  theme: 'bootstrap5'
		})  
		
	  })   
	</script>
   
  </body>
</html>
