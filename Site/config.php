<?php
session_start();
require_once('classes/class.bots.php');
require_once('classes/class.users.php');

$Users = new Users();
$checkBots = new checkBots();
$checkBots->checkSession();

//Add user into DB

$check;
$mes;
$div;

if(isset($_POST['add_user']))
{
	if(($_POST['pw'] != "") && ($_POST['re_pw'] != ""))
	{
		if($_POST['pw'] == $_POST['re_pw'])
		{	
			$user = (isset($_SESSION['admin']) ? $_SESSION['admin']: $_SESSION['user']);
			$pas = $_POST['pw'];
			
			
			$div = $Users->changePassword($user, $pas);
		
		}
			else (($mes = "The passwords don't match!") && ($div = '<div class="alert alert-error">
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
		echo '<li><a href="panel.php">Panel</a></li>';
	}
echo '<li class="active"><a href="config.php">Config</a></li>
		<li><a href="build.php">Build</a></li>
		<li><a href="logout.php">Logout</a></li>';
		?>
	</ul>
<div class="container">	
<?php echo $div;?>
	<div class="content">
		<h3>Account Management</h3>
		<fieldset>
			<form action="" method="POST" class="well span5">
			<legend>Change Password</legend>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-tag"></i></span>
					<input type="text" name="pw" placeholder="New Password"><br/>
					</div>
					<div class="input-prepend">
					<span class="add-on"><i class="icon-tags"></i></span>
					<input type="text" name="re_pw" placeholder="Re-type New Password"><br/>
					<button name="add_user" class="btn">Change Password</button>
					</div>
					
				
			</form>
	  </fieldset>
	</div>
</div>	
	
	
</body>
</html>