<?php  require_once('../../includes/initialize.php');  ?>


<?php 
	if(!$session->is_logged_in()) {
	  redirect_to("login.php");
	}
	//$sql = "SELECT * FROM thesis ORDER BY date_posted DESC";
	$theses = Thesis::find_by_college_id($librarian->college_id);
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
                                <li class="active"><a ><i class="fa fa-angle-double-right"></i> List All Thesis</a></li>
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
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
















        <aside class="right-side">
			<!-- Content Header (Page header) -->
			<section class="content-header"> 
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Manage Theses</a></li>
					<li class="active">List Theses</li>
				</ol>
			</section>

			<!-- ---------------------------------------------------------------------- Main content  ----------------------------->
			 
			
			<section class="content">

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">List of <?php echo $college->abbreviation; ?> Theses</h3>                                    
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="width:5%;">#</th>
									<th style="width:20%;">Title</th>
									<th style="width:38%;">Abstract</th>
									<th style="width:15%;" >Date Posted</th>
									<th style="width:12%;">Thesis Status</th>
									<th style="width:10%;">PDF Status</th> 
									<th hidden>PDF Status</th> 
									<th></th> 
								</tr>
							</thead>
							<tbody>  
								<?php 
									$count = 1;
									foreach($theses as $thesis): ?>
								<tr>
									<td><?php echo $count++ ; ?></td>
									<td><?php echo $thesis->title ;?></td>
									<td><?php echo $thesis->abstract ;?></td>
									<td><?php echo $thesis->date_format() ;?></td>
									<td class="text-<?php echo $thesis->thesis_status==1 ? 'light-blue">Available' : 'red">Unavailable' ;?></td>
									<td class="text-<?php echo $thesis->pdf_status==1 ? 'light-blue">Available' : 'red">Unavailable' ;?></td>
									<td> <a href="edit_thesis.php?id=<?php echo $thesis->id; ?>" class="glyphicon glyphicon-edit">Edit</a> </td>
									<td hidden> <?php 
									$sql = "SELECT * FROM adviser WHERE id=" . $thesis->adviser_id ;
									$adviser = array_shift(Adviser::find_by_sql($sql));
									echo $adviser->fullname;
												?> </td>
								</tr>  
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<th> </th> 
									<th> </th> 
									<th> </th> 
									<th> </th> 
									<th> </th> 
									<th> </th> 
								</tr>
							</tfoot>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				
				
		

			</section><!-- /.content -->
        </aside><!-- /.right-side -->
      
<?php include("admin_footer.php"); ?>