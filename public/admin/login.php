<?php  

require_once('../../includes/initialize.php'); 

if($session->is_logged_in()) {
  redirect_to("index.php");
}

if(isset($_POST['submit'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$found_librarian = Librarian::authenticate($username, $password);

	if( $found_librarian) {
		$session->login($found_librarian); 
		redirect_to("index.php");
	} else {
		$message = "Username/Password combination incorrect.";
	}
} else {
	$username = "";
	$password = "";
	$message  = "";
}
 
?>




<!DOCTYPE html>
<html   style="background-image:url('../img/blur-background09.jpg'); background-repeat: no-repeat; ">
    <head>
        <meta charset="UTF-8">
        <title>ONTRE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-image:url('../img/blur-background09.jpg'); background-repeat: no-repeat; ">  
	
        <div class="form-box" id="login-box" >
            <div class="header">ONTRE Sign In</div>
            <form action="#" method="post">
                <div class="body bg-gray">
					<?php if(isset($message) && strlen($message) > 1): ?> 
						<br />
						<div class="alert alert-danger alert-dismissable">
							<i class="fa fa-ban"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $message; ?>
						</div>
					<?php endif; ?>
									
					<div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" 
										value="<?php if(isset($username)){echo $username;} ?>" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" name="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="#">Forgot Password? Go to ISD</a></p> 
                </div>
            </form>
 
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>