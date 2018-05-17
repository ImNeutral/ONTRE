<?php  require_once('../../includes/initialize.php');  ?>


<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}
	
	$thesis = Thesis::find_by_id($_GET['id']);  
	$editable = $thesis->editable(); 
	
	$keyword = $thesis->get_all_keywords();
	$authors_id = $thesis->get_all_authors();
	$categories_id = $thesis->get_all_categories(); 
	$message="";
	  
?>

<?php


	if(isset($_POST['submit'])){
		
		$thesis->abstract = $database->escape_value($_POST["abstract"]);
		$thesis->thesis_status = $database->escape_value($_POST["thesis_status"]);
		$thesis->pdf_status = $database->escape_value($_POST["pdf_status"]);
		
		if($editable){ 
			$title = $database->escape_value($_POST["title"]);
			$thesis->title = implode(" " ,trim_explode($title));
			$thesis->adviser_id = $database->escape_value($_POST["adviser_id"]);
			$thesis->type = $database->escape_value($_POST["type"]);
		}
		//pdf_status
		//$thesis->file_upload = $_POST["file_upload"];
		//$thesis->keywords = $_POST["keywords"];
		//$thesis->author_id = array($_POST["author_id"]);
		//$thesis->category = array($_POST["category_id"]);
		$categories = array_unique($_POST['category_id']);
		$categories_id = $thesis->get_all_categories();   
		$sql = "DELETE FROM category_thesis WHERE thesis_id=" . $database->escape_value($thesis->id); 
		if((array_diff($categories,$categories_id) || array_diff($categories_id,$categories)) && $database->query($sql)){ 
			foreach($categories as $category){
				$category_exists = Category::find_by_id($category);
				if(isset($category_exists)){
					//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
					$sql = "INSERT INTO category_thesis values(null, '{$database->escape_value($category_exists->id)}' , {$thesis->id} )";
					$database->query($sql);
				}
			}
			$message = "Thesis Successfully Updated!";
		}
		
		$keywords = trim_explode(ucwords($database->escape_value($_POST["keywords"])));	
		$keyword_all = trim_explode($thesis->get_all_keywords()); 
		 
		$sql = "DELETE FROM keyword_thesis WHERE thesis_id=" . $database->escape_value($thesis->id); 
		if((array_diff($keywords, $keyword_all) || array_diff($keyword_all, $keywords)) && $database->query($sql)){  
			foreach($keywords as $keyword){ 
				if($keyword >= ' A'){
					$sql = "SELECT * FROM keyword ";
					$sql .= "WHERE keyword='{$keyword}'";
					$keyword_exists = array_shift(Keyword::find_by_sql($sql));
					if(isset($keyword_exists)){ 
						//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
						$sql = "INSERT INTO keyword_thesis values(null, '$keyword_exists->id' , {$thesis->id} )";
						$database->query($sql);
					} else {  
						$sql = "INSERT INTO keyword VALUES(null, '$keyword')";
						if($database->query($sql)){
							//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
							$keyword_id = "(SELECT MAX(id) FROM keyword)";
							$sql = "INSERT INTO keyword_thesis values(null, {$keyword_id}, {$thesis->id})";
							$database->query($sql);
						}
					}
				}
			} 
			$message = "Thesis Successfully Updated!";
		}
		 if($editable){

			$authors = array_unique($_POST['author_id']);
			$authors_id = $thesis->get_all_authors();
			
			$sql = "DELETE FROM author_thesis WHERE thesis_id=" . $database->escape_value($thesis->id); 
			if((array_diff($authors, $authors_id) || array_diff($authors_id, $authors)) && $database->query($sql)){   
				foreach($authors as $author){
					$author_exists = Author::find_by_id($author);
					if(isset($author_exists)){
						// sql = select max(id) from thesis
						// insert into Author values (null, $author_exists->id, sql);id
						//author_id
						//thesis_id
						//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
						$sql = "INSERT INTO author_thesis values(null, '{$database->escape_value($author_exists->id)}' , {$thesis->id} )";
						$database->query($sql);
					}
				}
				$message = "Thesis Successfully Updated!"; 
			}
		 }


		if($editable && !empty($_FILES['file_upload']['name']) && $_FILES['file_upload']['type'] == "application/pdf" ){
			$thesis->destroy_pdf();
			$thesis->attach_file($_FILES['file_upload']);
			$thesis->save_new_pdf();
			$thesis->update();

			$message = "Thesis Successfully Updated!"; 
		}


		
		if($thesis->update_thesis()){    
			$message = "Thesis Successfully Updated!"; 
 
		} else {
			if(!isset($message)){
				$message = join("<br />", $thesis->errors);
			}
		}	 
		
		$editable = $thesis->editable(); 
		
		$keyword = $thesis->get_all_keywords();
		$authors_id = $thesis->get_all_authors();
		$categories_id = $thesis->get_all_categories();
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
                        <li class="treeview active">
                            <a href="#">
                                <i href="" class="fa fa-book"></i> <span>Manage Thesis</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="add_thesis.php"><i class="fa fa-angle-double-right"></i> Add New Thesis</a></li>
                                <li><a href="index.php"><i class="fa fa-angle-double-right"></i> List All Thesis</a></li>
                                <li class="active"><a ><i class="fa fa-angle-double-right"></i> Edit Thesis</a></li>
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
							<i class="glyphicon glyphicon-edit"></i>
							<h3 class="box-title"> Edit Thesis</h3>
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
							
							<form action="edit_thesis.php?id=<?php echo $thesis->id; ?>" enctype="multipart/form-data" method="POST">
								<!-- text input -->
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="title" class="form-control" value="<?php echo $thesis->title; ?>" <?php if(!$editable){ echo " disabled";} ?> />
								</div>

								<!-- textarea -->
								<div class="form-group">
									<label>Abstract</label>
									<textarea name="abstract" class="form-control" maxlength="350" rows="4" placeholder="Enter Abstract up to 350 characters long..." required><?php echo $thesis->abstract; ?></textarea>
								</div> 

								<!-- textarea -->
								<div class="form-group">
									<label>Keywords</label>
									<textarea name="keywords" class="form-control" rows="1" placeholder="Enter Keywords Separated By Comma..."><?php echo $keyword; ?></textarea>
								</div>  
							
							


								<?php if($editable):?>
								<label>Replace File</label>
								<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
								<input type="file" name="file_upload" class="btn btn-default btn-flat" /><br />
								<?php endif; ?>






								<div class="form-group">
									<label>Adviser</label>
									<select class="form-control" name="adviser_id"  style="text-align:center;" <?php if(!$editable){ echo " disabled";} ?>>
										<option selected disabled>-- Please Select Adviser --</option>
										<?php 
										foreach($advisers as $adviser){
											$adviser_dept = Department::find_by_id($adviser->dept_id);
											echo "<option value='{$adviser->id}'";
											if($thesis->adviser_id==$adviser->id){
												echo " selected ";
											}
											echo ">Prof. {$adviser->fullname}&nbsp&nbsp&nbsp";
											echo strlen($adviser_dept->abbreviation)>0? "($adviser_dept->abbreviation)" : "";
											echo "</option>";
										}	 
										?>
									</select>
								</div> 
								     
								<label>Author</label>
								<div class="form-group" id="add_author" >
									<select class="form-control" name="author_id[]"  style="text-align:center;" <?php if(!$editable){ echo " disabled";} ?>>
										<option selected disabled>-- Please Select Author --</option>
										<?php 
										$author_id = array_shift($authors_id);
										$authors = Author::find_by_college_id($librarian->college_id);
										foreach($authors as $author){
											echo "<option value='{$author->id}'";
											if($author->id == $author_id){
												echo " selected ";
											}
											echo ">{$author->fullname}</option>";
										}	 
										?>
									</select>
								</div>	
								<!-- additional author -->
								<div id="authors">			
									<?php foreach($authors_id as $author_id): ?>
										<div class="form-group" id="add_author" >
											<select class="form-control" name="author_id[]"  style="text-align:center;" <?php if(!$editable){ echo " disabled";} ?>>
												<option selected disabled>-- Please Select Author --</option>
												<?php  
												$authors = Author::find_by_college_id($librarian->college_id);
												foreach($authors as $author){
													echo "<option value='{$author->id}'";
													if($author->id == $author_id){
														echo " selected ";
													}
													echo ">{$author->fullname}</option>";
												}	 
												?>
											</select>
										</div>
									<?php endforeach; ?>
								</div>  
								<input id="add_author_field" type="button" class="btn btn-primary btn-flat glyphicon" value=" + " <?php if(!$editable){ echo " disabled";} ?>></input>
								<input id="remove_author_field" type="button" class="btn btn-danger btn-flat glyphicon" value=" - " <?php if(!$editable){ echo " disabled";} ?>></input> <br /><br /><br />  
								<!-- /Additional -->

								<div class="form-group">
									<label>Thesis Type: &nbsp&nbsp&nbsp</label> 	
									<label>
										<input type="radio" name="type" value="thesis" class="minimal" checked <?php if(!$editable){ echo " disabled";} ?>/>
										Thesis
									</label>
									<label>
										<input type="radio" name="type" value="capstone" class="minimal" <?php if($thesis->type=="capstone"){ echo " checked "; } if(!$editable){ echo " disabled ";} ?>/>                                                    
										Capstone
									</label>
 								</div> 
  
								<label>Category</label>
								<div class="form-group"  id="add_category" >
									<select class="form-control" name="category_id[]"  style="text-align:center;" required>
										<option selected disabled>-- Please Select Category --</option> 
										<?php 
										/*
										$sql = "SELECt * FROM category_thesis WHERE thesis_id=" . $thesis->id;
										$old_categories = $database->query($sql);
										while($old_category = mysql_fetch_array($old_categories)){
											echo $old_category['category_id'] . "<br />";
										}*/
																				
										$categories = Category::find_all();
										$category_id = array_shift($categories_id);
										
										foreach($categories as $category){
											echo "<option value='{$category->id}'";
											if($category->id == $category_id){
												echo " selected ";
											}
											echo ">{$category->name}</option>";
										}	 
										?>
									</select>
								</div>
								<!-- additional Category --> 
								<div id="categories">    
									<?php foreach($categories_id as $category_id): ?>
										<div class="form-group"  id="add_category" >
											<select class="form-control" name="category_id[]"  style="text-align:center;" required>
												<option selected disabled>-- Please Select Category --</option> 
												<?php   
												$categories = Category::find_all();
												foreach($categories as $category){
													echo "<option value='{$category->id}'";
													if($category->id == $category_id){
														echo " selected ";
													}
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
										<input type="radio" name="thesis_status" value="0" class="minimal" <?php if(!$thesis->thesis_status){ echo "checked"; } ?>/>                                                    
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
										<input type="radio" name="pdf_status" value="0" class="minimal" <?php if(!$thesis->pdf_status){ echo "checked"; } ?>/>                                                    
										Hide from public
									</label>
 								</div> 
								
								<div class="box-footer" >   
									<a href="index.php"><button type="button" class="btn btn-primary" style="margin-left:60%;">< Back</button></a>
									<button type="submit" name="submit" class="btn btn-primary" style="margin-left:5%;">Submit ></button>
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
								<!--Edit Thesis do not allow alteration of the Thesis PDF file. If you want the PDF file to be private then hide it from public.-->
								Only Abstract, Keywords, Category, Thesis Status and PDF Status are alterable. The rest cannot be changed after 12 hours it was added.
								</p>
								<br />
								<p>
								
								</p>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
                </div><!-- /.col -->


				</section><!-- /.content -->
        </aside><!-- /.right-side -->
      
<?php include("admin_footer.php"); ?>