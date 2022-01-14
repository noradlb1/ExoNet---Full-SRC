<?php
session_start();
include_once('classes/class.login.php');
if(isset($_POST['submit']))
{
	if(($_POST['user'] != "") && ($_POST['pas'] != ""))
	{
		$User = new User();
		
		$user = $_POST['user'];
		$pas = $_POST['pas'];
		
		$User->loginUser($user, $pas);
	
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>EXONET - Enslave your bots</title>
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; 
      }
      .container {
        width: 300px;
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; 
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }
	  

	  .login-form {
		margin-left: 65px;
	  }
	
	  legend {
		margin-right: -50px;
		font-weight: bold;
	  	color: #404040;
	  }

    </style>

</head>
<body>
  <div class="container">
	<img style="margin-bottom:10px;" src="img/logo.png" />
    <div class="content">
      <div class="row">
        <div class="login-form">
          <h2>Login</h2>
		  <form action="" method="POST">
            <fieldset>
              <div class="input-prepend">
				<span class="add-on"><i class="icon-user"></i></span>
				<input type="text" name="user" placeholder="Username"><br/>
				</div>
				<div class="input-prepend">
				<span class="add-on"><i class="icon-tag"></i></span>
				<input type="password" name="pas" placeholder="Password"><br/>
				</div>
				<button class="btn btn-info" type="submit" name="submit">Sign in</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div> <!-- /container -->
</body>
</html>