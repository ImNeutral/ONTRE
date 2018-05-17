<?php  require_once('../../includes/initialize.php');  ?>


<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}
?>
<?php 
	$message = "";
	$message_error = "";
	 
	
	if(isset($_POST['submit'])){
		/*$sql = "SELECT * FROM librarian ";
		$sql .= " WHERE username='" . $database->escape_value($college->abbreviation);
		$sql .= "' AND password='"  .  $database->escape_value($_POST['old_password']) . "'";
		$account_exists = Librarian::find_by_sql($sql); 
		*/
		if($librarian->password == $_POST['old_password']){ 
			if(($_POST['new_password1'] == $_POST['new_password2']) && ($_POST['new_password2'] == $_POST['old_password'])){ 
				$message_error = "No changes was made!";
			} elseif($_POST['new_password1'] == $_POST['new_password2']){  
			
				$sql = "UPDATE librarian ";	
				$sql .= "SET password='" . $database->escape_value($_POST['new_password1']);
				$sql .= "' WHERE username='" . $database->escape_value($librarian->username) . "'";
				
				if($database->query($sql)){
					$message = "Password successfully changed!";
				} else { 
					$message_error = "Failed to change password!";
				} 
				
			} else { 
				$message_error = "New password do not match!";
			}
		} else { 
			$message_error = "Invalid old password!";
		}
	} 
?>

<?php include("admin_header.php"); ?>
















			
			<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
					<img src="../img/MSU_logo.png" alt="MSU Logo" />

					<!-- search form -->
					<br /><br />
                    <!-- /.search form -->
                    
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="#">
                                <i href="" class="fa fa-book"></i> <span>Manage Thesis</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="add_thesis.php"><i class="fa fa-angle-double-right"></i> Add New Thesis</a></li>
                                <li><a href="index.php"><i class="fa fa-angle-double-right"></i> List All Thesis</a></li>
                    		</ul>
                        </li>
                        <li class="">
                            <a href="add_AuthorAdviser.php">
                                <i class="fa fa-user"></i> <span>Add Adviser</span> 
                            </a> 
                        </li>
                        <li class="">
                            <a href="add_category.php">
                                <i class="fa fa-folder"></i> <span>Add Category</span> 
                            </a> 
                        </li>
                        <li class="active">
                            <a >
                                <i class="fa fa-wrench"></i> <span>Change Account Password</span> 
                            </a> 
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>














 

        <aside class="right-side">
			<!-- Content Header (Page header) -->
			<section class="content-header"> 
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-wrench"></i> Account Password</a></li>
					<li class="active">Change</li>
				</ol>
			</section>

			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			<section class="content">
 
				<div class="col-md-8" style="margin-left:16%;">
					<div class="box box-info"> 
						<div class="box-header">
							<i class="glyphicon glyphicon-wrench"> </i> 
							<h3 class="box-title"> Change Account Password</h3>
						</div><!-- /.box-header -->
				
						<div class="box-body"> 
						
							<?php if((isset($message) && strlen($message) > 1) || (isset($message_error) && strlen($message_error) > 1)): ?> 
								<br />
								<div class="alert alert-<?php echo strlen($message_error)>1 ? "danger":"info" ?> alert-dismissable">
									<i class="fa fa-<?php echo strlen($message_error)>1 ? "warning":"check" ?>"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo strlen($message_error)>1 ? $message_error : $message; ?>
								</div>
							<?php endif; ?>
							
							
							<form action="change_password.php" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" value="<?php echo $college->abbreviation; ?>" disabled/>
								</div>  
								 
								<div class="form-group">
									<label>Old Password</label>
									<input type="password" name="old_password" class="form-control" placeholder="Enter Old Password"/> 
								</div> 
								
								<div class="form-group"> 
									<label>New Password</label>
									<input type="password" name="new_password1" class="form-control" placeholder="Enter new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
									<label></label>
									<input type="password" name="new_password2" class="form-control" placeholder="Confirm new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
								</div> 
								
								<div class="box-footer" > 
									<button type="submit" name="submit" class="btn btn-primary" style="margin-left:80%;">Submit</button>
								</div> 
							</form>
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 
				 
				 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
      
<?php include("admin_footer.php"); ?>