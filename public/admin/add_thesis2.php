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
					$authors = array_unique($_POST['author_id']);
					$categories = array_unique($_POST['category_id']); 
					$keywords = trim_explode(ucwords($_POST["keywords"]));
					
					foreach($authors as $author){
						$author_exists = Author::find_by_id($author);
						if(isset($author_exists)){
							// sql = select max(id) from thesis
							// insert into Author values (null, $author_exists->id, sql);id
							//author_id
							//thesis_id
							//$thesis_id =  "(SELECT MAX(id) FROM thesis)"; 
							$sql = "INSERT INTO author_thesis values(null, '{$database->escape_value($author_exists->id)}' , {$max_thesis_id} )";
							$database->query($sql);
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
				$error_message = "The file is not a valid PDF file. Please be careful with uploading the thesis document because it is not alterable after submit. ";
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
	
	
	
	

								<!-- author entry-->
								<div class="form-group" style="width:100%;"  id="add_author" >
									<input type="text" name="author_name[]" class="new_author_entry" style="width:60%;" pattern="[A-Za-z]{3,}" placeholder="FirstName MidName LastName" required/>

									<select name="author_dept[]" class="new_author_entry" style="width:39%;text-align:center;" required>
										<option selected disabled>-- Please Select A Department --</option> 						
									</select>
								</div> 
								
	
	
	
	
	
								<!-- additional author -->
								<div id="authors">    
									<?php foreach($author_id_list as $a_id): ?> 
										<select class="form-control" name="author_id[]"  style="text-align:center;" required>
											<option selected disabled>-- Please Select Author --</option>
											<?php 
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
									<?php endforeach; ?>
								</div>  
								<input id="add_author_field" type="button" class="btn btn-primary btn-flat glyphicon" value=" + "></input>
								<input id="remove_author_field" type="button" class="btn btn-danger btn-flat glyphicon" value=" - "></input> <br /><br /><br />  
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
								<h4>Please read before you add a Thesis.</h4>
								<p>
								If the Authors and Advisers are new and are not on the list. Please add them on the 
								<a href="add_AuthorAdviser.php">Add Author/Adviser</a> page. Thankyou!
								</p>
								<br />
								<p>
								If the thesis has already been added, the PDF file will never be altered.
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