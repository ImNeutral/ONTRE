<?php  require_once('../../includes/initialize.php');  ?>


<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}   
	
	
	
?>
<?php 
	if(isset($_POST['submit'])){
				    
		$thesis = new Thesis();
		
		$title = $database->escape_value($_POST["title"]);
		$thesis->title = implode(" " ,trim_explode($title));
		
		$thesis->abstract = $database->escape_value($_POST["abstract"]);
		$thesis->adviser_id = $database->escape_value($_POST["adviser_id"]);
		$thesis->type = $database->escape_value($_POST["type"]);
		$thesis->thesis_status = $database->escape_value($_POST["thesis_status"]);
		$thesis->pdf_status = $database->escape_value($_POST["pdf_status"]);
		//pdf_status
		//$thesis->file_upload = $_FILE["file_upload"];
		//$thesis->keywords = $_POST["keywords"];
		//$thesis->author_id = array($_POST["author_id"]);
		//$thesis->category = array($_POST["category_id"]); 
		$sql = "SELECT * FROM thesis where title='" . $thesis->title . "'";
		$thesis_exists = $database->query($sql);
		if(mysql_fetch_array($thesis_exists)){
			$error_message="Thesis title already exists.";
		}
		else{ 
			if( $_FILES['file_upload']['type'] == "application/pdf" ){
				if($thesis->attach_file($_FILES['file_upload']) && $thesis->save()){
					$sql = "SELECT max(id) FROM thesis";
					$max_thesis_id = array_shift(mysql_fetch_array($database->query($sql)));  
					
					$sql = "UPDATE thesis set date_posted='" . date("Y-m-d H:i:s");
					$sql .= "' WHERE id=" . $max_thesis_id;
					$database->query($sql);
					
					$message = "Thesis Successfully Added!"; 
					
					$authors = $_POST['author_name'];
					$departments = $_POST['author_dept_id'];

					$categories = array_unique($_POST['category_id']); 
					$keywords = trim_explode(ucwords($_POST["keywords"]));
					

					foreach($authors as $author){
						$author = trim_explode(ucwords($author));
						$department = $database->escape_value(array_shift($departments));
						$author = array_shift($author);
					

						$is_duplicate = Author::is_duplicate($author, $max_thesis_id);
					
						if(!$is_duplicate){	
					
							$author_exists = Author::author_exists($author, $department);
							if(isset($author_exists)){
								
								$sql = "INSERT INTO author_thesis values(null, '{$database->escape_value($author_exists->id)}' , {$max_thesis_id} )";
								$database->query($sql);

							} else {
								$sql = "INSERT INTO author values(null, '{$database->escape_value($author)}' , {$department} )";
								$database->query($sql);


								$sql = "SELECT max(id) FROM author";
								$max_author_id = array_shift(mysql_fetch_array($database->query($sql)));  
						
								$sql = "INSERT INTO author_thesis values(null, '{$database->escape_value($max_author_id)}' , {$max_thesis_id} )";
								$database->query($sql);	
							}

							
						}
					}
					
					foreach($categories as $category){
						$category_exists = Category::find_by_id($category);
						if(isset($category_exists)){
							//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
							$sql = "INSERT INTO category_thesis values(null, '{$database->escape_value($category_exists->id)}' , {$max_thesis_id} )";
							$database->query($sql);
						}
					}
					
					foreach($keywords as $keyword){ 
						$sql = "SELECT * FROM keyword ";
						$sql .= "WHERE keyword='{$keyword}'";
						$keyword_exists = array_shift(Keyword::find_by_sql($sql));
						if(isset($keyword_exists)){
							//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
							$sql = "INSERT INTO keyword_thesis values(null, '{$database->escape_value($keyword_exists->id)}' , {$max_thesis_id} )";
							$database->query($sql); 
						} else { 
							$sql = "INSERT INTO keyword VALUES(null, '{$database->escape_value($keyword)}')";
							if($database->query($sql)){
								//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
								$keyword_id = "(SELECT MAX(id) FROM keyword)";
								$sql = "INSERT INTO keyword_thesis values(null, {$keyword_id}, {$max_thesis_id})";
								$database->query($sql);
							}
						}
					}
					
					
					
					// title,  abstract, keywords, adviser_id, author_id, type, category_id, thesis_status, pdf_status
					unset($_POST['title']);
					unset($_POST['abstract']);
					unset($_POST['keywords']);
					unset($_POST['adviser_id']);
					unset($_POST['author_id']);
					unset($_POST['type']);
					unset($_POST['category_id']);
					unset($_POST['thesis_status']);
					unset($_POST['pdf_status']);
					
					
					
				} else {
					$message = join("<br />", $thesis->errors);
				}
			} else {
				$error_message = "The file is not a valid PDF file. Please be careful when uploading the thesis document. ";
			} 
		} 
	} 
?> 

<?php include("admin_header.php"); ?>
    
    	<style>
			.new_author_entry {
				box-shadow: none;
				height: 34px;
				padding: 6px 12px;
				font-size: 14px;
				line-height: 1.42857;
				color: #555;
				vertical-align: middle;
				background-color: #FFF;
				background-image: none;
				border: 1px solid #CCC;
			}
		</style>




		<!-- author clone trick >_< Sucks! -->
		<div class="form-group"  id="add_author" hidden>
			<input type="text" name="author_name[]" class="new_author_entry" pattern="[A-Za-z ]{6,}" title="Please don't put any special characters on the name and it's at least 6 letters long." style="width:60%;" placeholder="FirstName MidName LastName" required/>

			<select name="author_dept_id[]" class="new_author_entry" style="width:39%;text-align:center;" required>
				<option selected disabled>-- Please Select A Department --</option> 
				<?php  
				foreach($departments as $department){
					echo "<option value='{$department->id}' ";
					echo (isset($d_id) && $department->id==$d_id) ? "selected" : "";	
					echo ">{$department->name}</option>";
				}	 
				?>						
			</select>
		</div> 


    



    
    

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
                        <li class="treeview active">
                            <a href="#">
                                <i href="" class="fa fa-book"></i> <span>Manage Thesis</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a ><i class="fa fa-angle-double-right"></i> Add New Thesis</a></li>
                                <li><a href="index.php"><i class="fa fa-angle-double-right"></i> List All Thesis</a></li>
                    		</ul>
                        </li>
                        <li class="">
                            <a href="add_AuthorAdviser.php">
                                <i class="fa fa-user"></i> <span>Add Author/Adviser</span> 
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
					<li><a href="#"><i class="fa fa-book"></i> Manage Theses</a></li>
					<li class="active">Add Thesis</li>
				</ol>
			</section>

			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			<section class="content">
 
				<div class="col-md-9">
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-plus"></i>
							<h3 class="box-title"> Add Thesis</h3>
						</div><!-- /.box-header -->
				
						<div class="box-body">
						
							<?php if(isset($message) && strlen($message) > 1): ?> 
								<br />
								<div class="alert alert-info alert-dismissable">
									<i class="fa fa-check"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo $message; ?>
								</div>
							<?php endif; ?>
							<?php if(isset($error_message)): ?> 
								<br />
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo $error_message; ?>
								</div>
							<?php endif; ?>
							
							<form action="add_thesis.php" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="title" class="form-control" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>" placeholder="Enter Title ..." required/>
								</div>
								
								<!-- textarea -->
								<div class="form-group">
									<label>Abstract</label>
									<textarea name="abstract" class="form-control" maxlength="350" rows="4" placeholder="Enter Abstract up to 350 characters long..." required><?php if(isset($_POST['abstract'])){echo $_POST['abstract'];} ?></textarea>
								</div> 

								<!-- textarea -->
								<div class="form-group">
									<label>Keywords</label>
									<textarea name="keywords" class="form-control" rows="1" placeholder="Enter Keywords Separated By Comma..."><?php if(isset($_POST['keywords'])){echo $_POST['keywords'];} ?></textarea>
								</div>  


								<label>Upload File</label>
								<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
								<input type="file" name="file_upload" class="btn btn-default btn-flat" required/><br />
								

								<div class="form-group">
									<label>Adviser</label>
									<select class="form-control" name="adviser_id"  style="text-align:center;" required>
										<option selected disabled>-- Please Select Adviser --</option>
										<?php 
										$ad_id =  0;
										if(isset($_POST['adviser_id'])){ 
											$ad_id = $_POST['adviser_id'];
										}
										foreach($advisers as $adviser){
											$adviser_dept = Department::find_by_id($adviser->dept_id);
											echo "<option value='{$adviser->id}'";
											if($ad_id == $adviser->id) { echo " selected ";}
											echo ">Prof. {$adviser->fullname}&nbsp&nbsp&nbsp";
											echo strlen($adviser_dept->abbreviation)>0? "($adviser_dept->abbreviation)" : "";
											echo "</option>";
										}	 
										?>
									</select>
								</div> 




								   

								<!--   
								<label>Author</label>
								<div class="form-group" id="add_author" >
									<select class="form-control" name="author_id[]"  style="text-align:center;" required>
										<option selected disabled>-- Please Select Author --</option>
										<?php
										$a_id =  0;
										$author_id_list = array(); 
										if(isset($_POST['author_id'])){
											$author_id_list = $_POST['author_id'];
											$a_id = array_shift($author_id_list);
										}
										$authors = Author::find_by_college_id($librarian->college_id);
										foreach($authors as $author){
											echo "<option value='{$author->id}'";
											if($a_id == $author->id){
												echo " selected ";
											}
											echo ">{$author->fullname}</option>";
										}	 
										?>
									</select>
								</div> 

								-->






 
								<?php
									$a_name =  "";
									$author_name_list = array(); 
									if(isset($_POST['author_name'])){
										$author_name_list = $_POST['author_name'];
										$a_name = array_shift($author_name_list);
									}
									$d_id =  0;
									$dept_id_list = array(); 
									if(isset($_POST['author_dept_id'])){
										$dept_id_list = $_POST['author_dept_id'];
										$d_id = array_shift($dept_id_list);
									}

								?>

								<!-- author entry-->
								<label>Author</label>
								<div class="form-group"  id="add_author2" >
									<input type="text" name="author_name[]" class="new_author_entry" pattern="[A-Za-z ]{6,}" title="Please don't put any special characters on the name and it's at least 6 letters long." style="width:60%;" placeholder="FirstName MidName LastName" value='<?php echo isset($a_name)? $a_name : ""; ?>' required/>

									<select name="author_dept_id[]" class="new_author_entry" style="width:39%;text-align:center;" required>
										<option selected disabled>-- Please Select A Department --</option> 
										<?php  
										$departments = Department::by_college_id();
										foreach($departments as $department){
											echo "<option value='{$department->id}' ";
											echo (isset($d_id) && $department->id==$d_id) ? "selected" : "";	
											echo ">{$department->name}</option>";
										}	 
										?>						
									</select>
								</div> 

 

 




								<!-- additional author -->
								<div id="authors">    
								<?php foreach($author_name_list as $a_name): 
									$d_id = array_shift($dept_id_list);
								?>
	
									<div class="form-group"  id="add_author" >
										<input type="text" name="author_name[]" class="new_author_entry" pattern="[A-Za-z ]{6,}" title="Please don't put any special characters on the name and it's at least 6 letters long." style="width:60%;" placeholder="FirstName MidName LastName" value='<?php echo isset($a_name)? $a_name : ""; ?>' required/>

										<select name="author_dept_id[]" class="new_author_entry" style="width:39%;text-align:center;" required>
											<option selected disabled>-- Please Select A Department --</option> 
											<?php  
											$departments = Department::by_college_id();
											foreach($departments as $department){
												echo "<option value='{$department->id}' ";
												echo (isset($d_id) && $department->id==$d_id) ? "selected" : "";	
												echo ">{$department->name}</option>";
											}	 
											?>						
										</select>
									</div> 
 										
								<?php endforeach; ?>


								
								</div>  
								<input id="add_author_field" type="button" class="btn btn-primary btn-flat glyphicon" value=" + "></input>
								<input id="remove_author_field" type="button" class="btn btn-danger btn-flat glyphicon" value=" - "></input>
								&nbsp&nbsp 


								<!--
								<input id="add_author_entry" type="button" class="btn btn-primary btn-flat glyphicon" style="width:8%;" value=" +Others "></input>
								-->

								<br /><br /><br />  
								<!-- /Additional -->

								<div class="form-group">
									<label>Thesis Type: &nbsp&nbsp&nbsp</label> 	
									<label>
										<input type="radio" name="type" value="thesis" class="minimal" checked/>
										Thesis
									</label>
									<label>
										<input type="radio" name="type" value="capstone" class="minimal" <?php if(isset($_POST['type']) && $_POST['type']=="capstone"){echo " checked ";} ?>/>                                                    
										Capstone
									</label>
 								</div> 
  
								<label>Category</label>
								<div class="form-group"  id="add_category" >
									<select class="form-control" name="category_id[]"  style="text-align:center;" required>
										<option selected disabled>-- Please Select Category --</option> 
										<?php 
										$cat_id =  0;
										$category_id_list = array(); 
										if(isset($_POST['category_id'])){
											$category_id_list = $_POST['category_id'];
											$cat_id = array_shift($category_id_list);
										}
										$categories = Category::find_all();
										foreach($categories as $category){
											echo "<option value='{$category->id}'";
											if($cat_id == $category->id) {echo " selected ";}
											echo ">{$category->name}</option>";
										}	 
										?>
									</select>
								</div>
								<!-- additional Category --> 
								<div id="categories">    
								<?php foreach($category_id_list as $cat_id): ?>
									<div class="form-group"  id="add_category" >
										<select class="form-control" name="category_id[]"  style="text-align:center;" required>
											<option selected disabled>-- Please Select Category --</option> 
											<?php 
											$categories = Category::find_all();
											foreach($categories as $category){
												echo "<option value='{$category->id}'";
												if($cat_id == $category->id) {echo " selected ";}
												echo ">{$category->name}</option>";
											}	 
											?>
										</select>
									</div>
								<?php endforeach; ?>
								</div> 

								<input type="button" class="btn btn-primary btn-flat glyphicon" id="add_category_field"  value=" + "></input>
								<input type="button" class="btn btn-danger btn-flat glyphicon" id="remove_category_field" value=" - "></input> <br /><br /><br />  
								<!-- /Additional --> 
								
								<div class="form-group">
									<label>Thesis Status: &nbsp&nbsp&nbsp</label> 	
									<label>
										<input type="radio" name="thesis_status" value="1" class="minimal" checked/>
										Available to public
									</label>
									<label>
										<input type="radio" name="thesis_status" value="0" class="minimal" <?php if(isset($_POST['thesis_status']) && $_POST['thesis_status']=="0"){echo " checked ";} ?>/>                                                    
										Hide from public
									</label>
 								</div>
								
								<div class="form-group">
									<label>PDF Status: &nbsp&nbsp&nbsp</label> 	
									<label>
										<input type="radio" name="pdf_status" value="1" class="minimal" checked/>
										Available to public
									</label>
									<label>
										<input type="radio" name="pdf_status" value="0" class="minimal" <?php if(isset($_POST['pdf_status']) && $_POST['pdf_status']=="0"){echo " checked ";} ?>/>                                                    
										Hide from public
									</label>
 								</div>
								 
								<div class="box-footer" >   
									<button type="submit" name="submit" class="btn btn-primary" style="margin-left:80%;">Submit</button>
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
								If the Adviser is new and is not on the list. Please add him/her on the 
								<a href="add_AuthorAdviser.php">Add Adviser</a> page. Thankyou!
								</p>
								<br />  
								<p>
								Every Keyword you've separated by comma will be threaten as one separate keyword. Be sure to separate every keyword by comma.
								</p>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
                </div><!-- /.col --> 
				
				</section><!-- /.content -->
        </aside><!-- /.right-side --> 
		 
<?php include("admin_footer.php"); ?>


