<?php
session_start();
require_once('classes/class.bots.php');
require_once('classes/class.users.php');
if(!isset($_SESSION['admin']))
{
	header('location:bots.php');
}

$Users = new Users();
$checkBots = new checkBots();
$checkBots->checkSession();


//delete users

if(isset($_POST['del_user']))
{
    foreach ($_POST as $key => $value) {
        if(strstr($key,"user_") !== false){
            $Users->delUser(str_replace("user_","",$key));
        }
    }
}

//Add user into DB

$check;
$mes;
$div;


if(isset($_POST['add_user']))
{
	if(($_POST['username'] != "") && ($_POST['password'] != "") && ($_POST['repassword'] != ""))
	{
		if($_POST['password'] == $_POST['repassword'])
		{	
			$user = $_POST['username'];
			$pas = $_POST['password'];
			
			
			$div = $Users->addUser($user, $pas);
		
		}
			else (($mes = "The user password doesn't match!") && ($div = '<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="modal"></button>
	  <h4>Warning!</h4>
	  '.$mes.'
	</div>'));
	} else (($mes = "Please check if you filled in all the fields!") && ($div = '<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert"></button>
  <h4>Warning!</h4>
  '.$mes.'
</div>'));
	
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>EXONET - Enslave your bots</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.css" /> 
	<style>
	
		.input-prepend input
		{
			margin-bottom:10px;
		}
	
		legend {
			border-bottom:3px solid;
		}
		
		.container > .content {
			padding-left:15px;
			padding-top:10px;
			background-color: #eee;
			height:auto;
			border-radius:10px;
			      -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
		}
	
		ul {
			padding-top:20px;
			padding-left:100px;
		}
		
		
		
	</style>
</head>
<body>
	<ul class="nav nav-tabs">
		<?php 
			echo '<li><a href="bots.php">Bots</a></li>';
if(isset($_SESSION['admin']))
	{
		echo '<li class="active"><a href="panel.php">Panel</a></li>';
	}
echo '<li><a href="config.php">Config</a></li>
		<li><a href="build.php">Build</a></li>
		<li><a href="logout.php">Logout</a></li>';
		?>
	</ul>
<div class="container">	
<?php echo $div;?>
	<div class="content">
		<h3>Manage Users</h3>
		<fieldset>
			<form action="" method="POST" class="well span5">
			<legend>Add user</legend>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input id="prependedInput" name="username"type="text" placeholder="Username"><br/>
					</div>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-tag"></i></span>
					<input type="text" name="password" placeholder="Password"><br/>
					</div>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-tags"></i></span>
					<input type="text" name="repassword" placeholder="Re-type Password"><br/>
					<button name="add_user" class="btn">Add user</button>
					</div>
					
				
			</form>
	  </fieldset>
	  <fieldset>
			<div class="well span5">
			<legend>Registered users</legend>
					
							<?php $Users->getUser(); ?>
						
			</div>
	  </fieldset>
	</div>
	
</div>	
	
	
</body>
</html>