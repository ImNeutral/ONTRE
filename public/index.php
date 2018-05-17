<?php  require_once('../includes/initialize.php');  ?>

<?php  

	$sql = "SELECT * FROM thesis ORDER BY date_posted DESC";
	$theses = Thesis::find_by_sql($sql);

	$search_submit = "1";
	$search_text = "";
	
	$cat_id = 0;
	if(isset($_GET['cat_id'])){
		$cat_id = $_GET['cat_id'];
	}
	$per_page = 2;
	$count_all = 0;
?>
<?php 

	if(isset($_GET["search_submit"]) && strlen($_GET["search_text"]) > 0 && $cat_id == 0){  
		$search_submit = $_GET["search_submit"];
		$search_text = $_GET["search_text"];
		
		$theses_search = Thesis::search_thesis_cleaned($search_text); 
		
		$current_page = !empty($_GET['current_page']) ? $_GET['current_page'] : 1; 
		    
		
			
		$thesis = array();
		foreach($theses_search as $thes){
			$count_all++;
	 
			$thesis[] = $thes; 
		}
 
		
		$theses = array();
		
		for($page_thesis= $per_page*($current_page-1) ; $page_thesis < ($per_page*$current_page) && $page_thesis < $count_all; $page_thesis++){
			$theses[] = $thesis[$page_thesis]; 
		}
		 
	} 
	
	if($cat_id > 1){ 
		//SELECT th.id, th.adviser_id, th.date_posted, th.title, th.abstract, th.filename, th.type, th.thesis_status, th.pdf_status FROM thesis th 
		//INNER JOIN category_thesis cth ON th.id=cth.thesis_id WHERE cth.category_id=5015
		$theses_search = Thesis::find_by_category_id($cat_id);
		
 
		$current_page = !empty($_GET['current_page']) ? $_GET['current_page'] : 1; 
		
		
		$thesis = array();
		
		foreach($theses_search as $thes){
			$count_all++;
			  
			$thesis[] = $thes;
		}
		
		$theses = array();
		
		for($page_thesis= $per_page*($current_page-1) ; $page_thesis < ($per_page*$current_page) && $page_thesis < $count_all; $page_thesis++){
			$theses[] = $thesis[$page_thesis]; 
		}
		//$sql = "SELECT name FROM category WHERE id=" . $database->escape_value($cat_id); 
		//$search_text = mysql_fetch_array($database->query($sql))['name']; 
		 
		
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
				
				
				
				<?php if(strlen($search_text) > 0 || $cat_id > 0 ){  ?>
				
				
				
				<div class="col-md-9" >
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-list"> </i> 
							<h3 class="box-title"> Thesis List</h3>
					
							<!-- search form -->
							<form action="#" method="GET" class="sidebar-form" style="margin-left:60%;"> 
								<div class="input-group">
									<input type="hidden" name="cat_id" value="0"/>
									<input type="text" name="search_text" class="form-control"  placeholder="Search By Title, Keyword, Adviser, Author..." required/>
									<span class="input-group-btn">
										<button type="submit" name="search_submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
							<!-- /.search form --> 
						</div>
						<h4 class="text-yellow" style=" margin-left:5%;">
							<?php 
								if($cat_id > 0){
									$category_name = Category::find_by_id($cat_id);
								}
								if($count_all > 0){
									echo "Results ";
									echo ($current_page-1)*$per_page+1 . " - ";
									echo ($current_page==ceil($count_all/$per_page)) ? $count_all : $current_page*$per_page;
									echo " of about $count_all for ";
									echo ($cat_id > 0)?  "Category:  " . $category_name->name : $search_text. "."; 
								} else {
									echo "No results found.";
								}
							?>
						</h4>
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
											
											
											<a href="pdf/<?php echo $thesis->filename; ?>" target="_blank" style="margin-left:60%; "><img src="img/pdf_img.png" alt="PDF File" height="42" width="42"></a>
											<?php endif; ?>
										
										</dl>
									</div><!-- /.box-body -->
								</div><!-- /.box -->		
								<?php endif; ?>
							<?php endforeach; ?> 
							<!-- every one button is equal to 4% margin left -->
							
							<div class="btn-group" style="margin-left:<?php echo 75-(($count_all/$per_page)*4); ?>%; font-weight:bold; font-size:110%;">
								
								 <a <?php echo ($current_page==1)? ">" : 
															"href=\"?search_text=". $search_text ."&search_submit=1&current_page=" . ($current_page-1) . "&cat_id=" . $cat_id  . "\">"; ?>
										<button type="button" class="btn btn-info <?php if($current_page==1){echo "disabled";} ?>">← Previous </button></a>  
								<?php 
									for($page=1; $page <= ceil($count_all/$per_page); $page++){
										if($page!=$current_page){ echo "<a href='?search_text=" . $search_text . "&search_submit=1" . "&current_page=" . $page . "&cat_id=" . $cat_id  . "' >"; }
										else { echo "<a>";}
										echo "<button type='button' class='btn btn-info' ";
										echo ($current_page==$page) ? " style='background-color:#357CA5;' disabled>" : ">";
										echo "{$page}</button>";
										echo "</a>";
									}
								?>  
								 <a <?php echo ($current_page==ceil($count_all/$per_page) || $count_all==0)? ">" : 
															"href=\"?search_text=". $search_text ."&search_submit=1&current_page=" . ($current_page+1) . "&cat_id=" . $cat_id . "\">"; ?>
									<button type='button' class='btn btn-info <?php if($current_page==ceil($count_all/$per_page) || $count_all==0){echo "disabled";} ?>'> Next →</button></a> 
							</div>
							<div class="footer" style="text-align:center; margin-top:20px;">
										Copyright © <?php echo date("Y"); ?> Online Thesis Repository Mindanao State University 
							</div>
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 
				
				
				
				
				
				<?php } else { ?>
				
				
				
				<div class="col-md-9" >
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-list"> </i> 
							<h3 class="box-title"></h3>
					
							<!-- search form -->
							<form action="#" method="GET" class="sidebar-form" style="margin-left:60%;"> 
								<div class="input-group">
									<input type="text" name="search_text" class="form-control" placeholder="Search By Title, Keyword, Adviser, Author..." required/>
									<span class="input-group-btn">
										<button type="submit" name="search_submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
							<!-- /.search form --> 
						</div> 
						<!-- /.box-header --> 
						<div class="box-body">  
							 <div  >
                            <!-- Primary tile -->
									<div class="box box-solid bg-light-blue">
										<div class="box-header">
											<h3 class="box-title">Welcome to ONTRE</h3>
										</div>
										<div class="box-body">    
											<p style="font-size:110%;">
											This Online Thesis Repository was created in Mindanao State University - Marawi Campus.
											</p> 
											<p style="font-size:110%;">
											
											</p> 
											<p style="font-size:110%;">
											ONTRE will aid the you find the right kind of resources as basis for you own Thesis. Because being new to Thesis writing is a very challenging endeavor, thus having a good reference is very important. 
											</p> 
										</div><!-- /.box-body -->
									</div><!-- /.box -->
									<div class="footer" style="text-align:center;">
										Copyright © <?php echo date("Y"); ?> Online Thesis Repository Mindanao State University 
									</div>
								</div><!-- /.col -->			 
				
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col -->
				
				
				
				<?php } ?>
				
				 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
       
<?php include("public_footer.php"); ?>