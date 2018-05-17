<?php include("public_header.php"); ?>
        <aside class="">
			<!-- Content Header (Page header) -->
			<section class="content-header"> 
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i> ONTRE</a></li>
					<li class="active">Home</li>
				</ol>
			</section>

			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			<section class="content">
				<div class="col-md-3" >
					<div class="box box-info">
						<div class="box-header">
							<i class="fa fa-search"> </i> 
							<h3 class="box-title"> Search By Category</h3>
						</div><!-- /.box-header --> 
				
						<div class="box-body"> 
							<!-- search form -->
							<form action="#" method="get" class="sidebar-form" style="width:80%; margin-left:9%;"> 
								<div class="input-group" >
									<input type="text" name="search_text" class="form-control" placeholder="Search Category Name"/>
									<span class="input-group-btn">
										<button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</form>
							<!-- /.search form -->  
								
							<br />
						 
							<form action="index.php" method="POST"  style="width:80%; margin-left:9%;">
								<!-- text input --> 
									
									<div class="input-group input-group-sm">
										<select name="year" class="form-control" style="text-align:center;font-size:108%;">
											<option selected disabled>-- Search By Year --</option>
											<option>2010</option>
											<option>2011</option>
											<option>2013</option>
											<option>2014</option>
											<option>2015</option>
										</select>
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button">Go!</button>
										</span>
									</div><!-- /input-group -->
									 
							</form>
							<br />
							<ol style="margin-left:10%;font-size:110%;">
								<a href="#"><li>A Category 1</li></a>
								<a href="#"><li>First Category</li></a>
								<a href="#"><li>The Category</li></a>
								<a href="#"><li>My Category</li></a>
								<a href="#"><li>Cat 1</li></a>
							</ol>
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 
 
 
				<div class="col-md-9" >
					<div class="box box-info">
						<div class="box-header">
							<i class="glyphicon glyphicon-list"> </i> 
							<h3 class="box-title"> Theses List</h3>
						</div>
						<!-- /.box-header -->
				
						<div class="box-body"> 
						
						
						
						
						</div><!-- /.box-body -->
					
					</div><!-- /.box -->
				</div><!-- /.col --> 
				 
				
			</section><!-- /.content --> 
        </aside><!-- /.right-side -->
      
<?php include("public_footer.php"); ?>