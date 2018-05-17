<?php  require_once('../includes/initialize.php');  ?>

<?php 

	$sql = "SELECT * FROM thesis ORDER BY date_posted DESC";
	$theses = Thesis::find_by_sql($sql);
	 
?>
<?php 

	if(isset($_GET["search_submit"]) && strlen($_GET["search_text"]) > 0){  
	
		$theses = Thesis::search_thesis($_GET["search_text"]); 
		 
	} 
	
	if(isset($_GET['cat_id'])){
		//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th 
		//INNER JOIN category_thesis cth ON th.id=cth.thesis_id WHERE cth.category_id=5015
		$theses = Thesis::find_by_category_id($_GET['cat_id']);
	}
	
//	$theses = array_unique($theses);
//dont forget to clean the last list of theses
?>


<?php include("public_header.php"); ?>

        <aside class=""> 
			<section class="content-header"> 
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i> ONTRE</a></li>
					<li class="active">Home</li>
				</ol>
			</section>

			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			<section class="content"> 
									
 
				<div class="col-md-3" style="width:21%;">
					<div class="box" >
						<div class="box-header">                                   
						</div><!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="example1" class="table" style="font-family: Source Sans Pro,sans-serif;">
								<thead>
									<tr> 
										<th class="text-light-blue">Categories</th> 
									</tr>
								</thead>
								<tbody > 
									<?php foreach($categories as $category): ?>
									<tr> 
										<td><a href="?cat_id=<?php echo $category->id; ?>" style="color:black;">&nbsp&nbsp<?php echo $category->name; ?></td> </a>
									</tr>  
									<?php endforeach; ?>
								</tbody> 
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
				
				<div class="col-md-9" >
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-list"> </i> 
							<h3 class="box-title"> Thesis List</h3>
					
							<!-- search form -->
							<form action="#" method="GET" class="sidebar-form" style="margin-left:60%;"> 
								<div class="input-group">
									<input type="text" name="search_text" class="form-control" placeholder="Search By Title, Keyword, Adviser, Author..."/>
									<span class="input-group-btn">
										<button type="submit" name="search_submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
							<!-- /.search form --> 
						</div>
						<!-- /.box-header -->
						
						<div class="box-body">  
							
                                                
												
							<?php  
							foreach($theses as $thesis): ?>
								<?php if($thesis->thesis_status): ?>
								<div class="box box-solid">
									<div class="box-header">
										<i class="fa fa-book text-light-blue"></i>
										<h3 class="box-title text-light-blue"><?php echo $thesis->title ;?></h3>
									</div><!-- /.box-header -->
									<div class="box-body">
										<dl class="dl-horizontal">
											<dt>Description:</dt>
											<dd><?php echo $thesis->abstract ;?></dd>
											
											<dt>Adviser: </dt>
											<?php 
											$thes_adviser = Adviser::find_by_id($thesis->adviser_id);
											echo "<dd>Prof. $thes_adviser->fullname</dd>"; 
											?>
											<dt>Author:</dt>
											<?php 
											//SELECT a.fullname FROM author a inner join author_thesis at 
											//on at.author_id=a.id WHERE at.thesis_id=2015008
											$sql = "SELECT a.fullname FROM author a inner join author_thesis at ";
											$sql .= "ON at.author_id=a.id ";
											$sql .= "WHERE at.thesis_id=" . $database->escape_value($thesis->id);
											$authors = Author::find_by_sql($sql);
											foreach($authors as $author){
												echo "<dd>{$author->fullname}</dd>";
											}
											?> 
											
											<dt>Date Added:</dt>
											<dd><?php echo $thesis->public_date_format() ;?></dd>
											<?php if($thesis->pdf_status): ?> 
											<a href="#" style="margin-left:60%; "><img src="img/pdf_img.png" alt="PDF File" height="42" width="42"></a>
											<?php endif; ?>
										
										</dl>
									</div><!-- /.box-body -->
								</div><!-- /.box -->		
								<?php endif; ?>
							<?php endforeach; ?> 
							<!-- every one button is equal to 4% margin left -->
							<div class="btn-group" style="margin-left:64%;">
								<button type="button" class="btn btn-info" >← Previous</button>
								<button type="button" class="btn btn-info"  style="background-color:#357CA5;">1</button>
								<button type="button" class="btn btn-info">2</button>
								<button type="button" class="btn btn-info">3</button>
								<button type="button" class="btn btn-info">4</button>
								<button type="button" class="btn btn-info">5</button> 
								<button type="button" class="btn btn-info disabled">Next →</button>
							</div>
	 
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 
				 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
      
<?php include("public_footer.php"); ?>