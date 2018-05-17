<?php  require_once('../../includes/initialize.php');  ?> 

<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}   
?>

<?php  
	if(isset($_POST['submit_adviser'])){
		$adviser = new Adviser();
		$adviser->fullname = $database->escape_value(ucwords(implode(" " ,trim_explode($_POST['adviser_name']))));
		$adviser->dept_id = $database->escape_value($_POST['adviser_dept']); 

		if(!$adviser->exists($adviser->fullname, $adviser->dept_id ) && $adviser->save()){
			$adviser_message = "New Adviser Successfully Added";
		} else {
			$adviser_message = "Adviser's name with same department already exists.";
			$adviser_error = "1";
		}
	}
	if(isset($_POST['submit_author'])){
		$author = new Author();
		$author->fullname = $database->escape_value(ucwords(implode(" " ,trim_explode($_POST['author_name']))));
		$author->dept_id = $database->escape_value($_POST['author_dept']); 
		
		if(!$author->exists($author->fullname, $author->dept_id ) && $author->save()){
			$author_message =  "New Author Successfully Added";
		} else {
			$author_message = "Author's name with same department already exists.";
			$author_error = "1";
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
                        <li class="active">
                            <a >
                                <i class="fa fa-user"></i> <span>Add Adviser</span> 
                            </a> 
                        </li>
                        <li class="">
                            <a href="add_category.php">
                                <i class="fa fa-folder"></i> <span>Add Category</span> 
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
					<li><a href="#"><i class="fa fa-book"></i> Adviser</a></li>
					<li class="active">Add</li>
				</ol>
			</section>
			 
			

			<?php if(0):?>				
			<section class="content">
 
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-plus"></i>
							<i class="glyphicon glyphicon-user"></i>
							<h3 class="box-title"> Add Author</h3>
						</div><!-- /.box-header -->
						<div class="box-body"> 
							<?php if(isset($author_message) && strlen($author_message) > 1): ?> 
								<br />
								<div class="alert alert-<?php echo isset($author_error) ? "danger" :"info" ?> alert-dismissable">
									<i class="fa fa-<?php echo isset($author_error) ? "info" :"check" ?>"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo $author_message; ?>
								</div>
							<?php endif; ?>
			
							<form action="add_AuthorAdviser.php" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="author_name" class="form-control"  placeholder="FirstName MidName LastName" pattern="[A-Za-z ]{6,}" title="Please don't put any special characters on the name and it's at least 6 letters long" required/>
								</div>
 
								<div class="form-group">
									<label>Department</label>
									<select class="form-control" name="author_dept" style="text-align:center;" required>
										<option selected disabled>-- Please Select A Department --</option> 
										<?php   
										foreach($departments as $department){
											echo "<option value='{$department->id}'>{$department->name}</option>";
										}	 
										?>
									</select>
								</div> 
								 
								<div class="box-footer" > 
									<button type="submit" name="submit_author" class="btn btn-primary" >Submit</button>
								</div> 
							</form>
						</div><!-- /.box-body -->


					
					</div><!-- /.box -->
				</div><!-- /.col --> 
				<?php endif; ?>



				<br /><br />
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
				<div class="col-md-8" style="margin-left:3%;">
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-plus"></i>
							<i class="glyphicon glyphicon-user"></i>
							<h3 class="box-title"> Add Adviser</h3>
						</div><!-- /.box-header -->
				
						<div class="box-body">  
							<?php if(isset($adviser_message) && strlen($adviser_message) > 1): ?> 
								<br />
								<div class="alert alert-<?php echo isset($adviser_error) ? "danger" :"info" ?> alert-dismissable">
									<i class="fa fa-<?php echo isset($adviser_error) ? "info" :"check" ?>"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo $adviser_message; ?>
								</div>
							<?php endif; ?>

							<form action="add_AuthorAdviser.php" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Fullname</label>
									<input type="text" name="adviser_name" class="form-control" placeholder="FirstName MidName LastName" pattern="[A-Za-z ]{6,}" title="Please don't put any special characters on the name and it's at least 6 letters long" required/>
								</div>
 
								<div class="form-group">
									<label>Department</label>
									<select class="form-control" name="adviser_dept" style="text-align:center;" required>
										<option selected disabled>-- Please Select A Department --</option> 
										<?php  
										foreach($departments as $department){
											echo "<option value='{$department->id}'>{$department->name}</option>";
										}	 
										?>
									</select>
								</div> 
								 
								<div class="box-footer"> 
									<a href="index.php"><button type="button" class="btn btn-primary" style="margin-left:65%;">< Cancel</button></a>
									<button type="submit" name="submit_adviser" class="btn btn-primary" style="margin-left:5%;">Submit</button>
								</div> 
							</form>
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 

				 <div class="col-md-3">
					<div class="box box-danger">
						<div class="box-header">
							<i class="fa fa-bullhorn"></i>
							<h3 class="box-title">Reminder</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<div class="callout callout-danger">
 
								<p>
								Please be careful with every letters of the adviser's name because that will not be alterable after adding.	
								</p>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
                </div><!-- /.col --> 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
      
<?php include("admin_footer.php"); ?>