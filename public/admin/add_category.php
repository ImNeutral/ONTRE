<?php  require_once('../../includes/initialize.php');  ?> 

<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}  
	
	
?>

<?php  
	if(isset($_POST['submit_category'])){ 
		$category = $database->escape_value(ucwords(implode(" " ,trim_explode($_POST['category_name']))));
		$description = $database->escape_value(implode(" " ,trim_explode($_POST['description'])));
		$sql = "SELECT * FROM category WHERE name='$category'";
		if(!mysql_fetch_array($database->query($sql))){
			$sql = "INSERT INTO category VALUES(null, '";
			$sql .= $category . "', '" . $description . "')";
			if($database->query($sql)){ 
				$adviser_message = "New category was successfully added.";
			}
		} else {
			$adviser_message = "Category Already Exists!";
			$adviser_error = '1';
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
                        <li class="active">
                            <a >
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
					<li><a href="#"><i class="fa fa-book"></i> Category</a></li>
					<li class="active">Add</li>
				</ol>
			</section>
			 
			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			<section class="content">
 
				 
				
				<div class="col-md-8">
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-folder-open"></i> 
							<h3 class="box-title">&nbspAdd Category</h3>
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

							<form action="add_category.php" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Category Name</label>
									<input type="text" name="category_name" class="form-control" placeholder="Category name..." required/>
								</div>
 
								<!-- textarea -->
								<div class="form-group">
									<label>Description</label>
									<textarea name="description" class="form-control" rows="2" placeholder="Enter description..." ></textarea>
								</div> 
								 
								<div class="box-footer"  >
									<a href="index.php"><button type="button" class="btn btn-primary" style="margin-left:65%;">< Cancel</button></a>
									<button type="submit" name="submit_category" class="btn btn-primary" style="margin-left:5%;">Submit ></button>
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
								<h4>
								Please be sure when you add a category because after you submit it,
								it will never be alterable or deletable.
								</h4> 
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
                </div><!-- /.col -->  
				 
				 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
      
<?php include("admin_footer.php"); ?>