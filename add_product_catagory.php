<?php 
include('inc/sales_index_header.php'); 
?>
<?php 
		if (empty($_GET['id'])){
		}elseif(!isset($_GET['id']) || $_GET['id'] == NULL){
			echo 'Something went to wrong';
		}else{
				$tid= $_GET['id'];
				$id= preg_replace("/[^0-9a-zA-Z]/", "", $tid);
				$rid = $id;
		}
?>

<?php
		if(isset($_GET['delid'])){
				$delteach =$_GET['delid'];	
		
			if ($delteach==true){
				$query ="DELETE FROM product_catagory WHERE id=$delteach";
				$del =$db->delete($query);

				if($del){
					echo "<script> alert ('Catagory delete Successfully') </script>";
					echo "<script> window:location ='add_product_catagory.php'; </script>";
				} else {
					echo "Data not Delete";
				}
			}
		}

		?>
<div class='dashboard'>    
    
    <?php  include('inc/sales_side_bar.php'); ?>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
	<div class='dashboard-content'>
		<div class='container'>
			<div class='card'>
                    <div class='card-header'>
                        <h5>Products Catagory </h5>
                    </div>
                <div class='card-body text-center' style="min-height:600px;">
                    <div class='row' >
						<div class='col-md-6' > 
								<div class="mx-auto" style="max-width:500px; box-shaddow:0px 2px 2px 0px">
								<?php 
										if(isset($_POST['submit'])){
											$cat_name=$_POST['cat_name'];
											
											$query="INSERT INTO product_catagory(name) values ('$cat_name')";
											$results=$db->insert($query);
											if($results==true){
												?> 
											<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert">&times;</button>
											  <strong>Catagory Added Successfully</strong>  
											</div>
											<?php 
										}else{
											?> 
											<div class="alert alert-danger">
											  <strong>Somthing Problem</strong>  
											</div>
											<?php 
										}
									}
								?>									
								<?php 
									if(isset($_POST['submitedit'])){
										$cat_name=$_POST['cat_name'];									
										$query="UPDATE product_catagory SET 
										name='$cat_name' 
										where id=$rid";
										$results=$db->update($query);
										if($results==true){
											?> 
											<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert">&times;</button>
											  <strong>Catagory Update Successfully</strong>  
											</div>
											<?php 
										}else{
											?> 
											<div class="alert alert-danger">
											  <strong>Somthing Problem</strong>  
											</div>
											<?php 
										}
									}						
								?>
							
								<div style="background:#fff;  "> 
										
											<?php
												if($rid==true){
											?>
									<form action="" method="post">
									<div class="form-row">
										<div class="col-sm-12 col-md-12"> 
										<?php
											$query="SELECT * From product_catagory where id=$rid";
											$results=$db->select($query);
											$id=0; 
											if($results==true){
												while($rse=$results->fetch_assoc()){
												$id++; 
										?> 
											<div class="col-sm-12 col-md-12"> 
												<div class="input-group">
													<input type="text" name="cat_name" value="<?php echo $rse['name']; ?>" class="form-control" placeholder="Search">
													<div class="input-group-btn">
													  <button type="submit" name="submitedit" class="btn btn-success btn_color btn-bg" type="submit">
														<i class="fas fa-plus"></i> Update Catagory
													  </button>
													</div>
												</div>
											</div>
										
										 <?php } }?>
										</div> 
												<?php }else{?> 
										<form action="" method="post">									
											<div class="col-sm-12 col-md-12"> 
												<div class="input-group">
													<input type="text" name="cat_name" class="form-control" placeholder="Enter catagory name" required>
													<div class="input-group-btn">
													  <button type="submit" name="submit" class="btn btn-success btn_color btn-bg" type="submit">
														<i class="fas fa-plus"></i> Add Catagory
													  </button>
													</div>
												</div>
											</div>
										</form> 
										
														<?php } ?> 
														<br /> 
														<hr />
										</div> 
														
										<table id="example" class=" table-striped table-bordered" style="width:100%">
											<thead>
												<tr>
													<th>s.L No</th> 
													<th>Name</th> 
													<th>Action</th> 
												</tr>
											</thead>
											<tbody>
											<?php
												$query="SELECT * From product_catagory";
												$results=$db->select($query);
												$id=0; 
												if($results==true){
													while($rs=$results->fetch_assoc()){
													$id++; 
											?> 
												 <tr class="unread">
												  <td class="inbox-small-cells">
													  <?php echo $id; ?>
												  </td>
												  <td class="inbox-small-cells"> <?php echo$rs['name']; ?></td>  
												  <td ><a href="add_product_catagory.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-success btn-bg"><i class="fas fa-edit"></i></a> <a href="add_product_catagory.php?delid='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td> 
											  </tr> 
											  <?php } }?>
											</tbody>
											<tfoot>
												
											</tfoot>
										</table>
									
								</div>  
						</div>
						<div class="col-md-6">
						
							<?php 
										if(isset($_POST['sub_submit'])){ 
											$cat_name			=$fm->validation($_POST['cat_name']);
											$main_cat			=$fm->validation($_POST['main_cat']); 
											
											$cat_name			=mysqli_real_escape_string($db->link,$cat_name);
											$main_cat			=mysqli_real_escape_string($db->link,$main_cat);
											
											
											$query1="INSERT INTO `sub_catagory`(`sub_cat_name`, `main_cat_id`) VALUES
											('$cat_name','$main_cat')";
											$results1=$db->insert($query1);
											if($results1==true){
												?> 
											<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert">&times;</button>
											  <strong>Sub Catagory Added Successfully</strong>  
											</div>
											<?php 
										}else{
											?> 
											<div class="alert alert-danger">
											  <strong>Somthing Problem</strong>  
											</div>
											<?php 
										}
									}
								?>									
								<?php 
									if(isset($_POST['submitedit'])){
										$cat_name=$_POST['cat_name'];									
										$query="UPDATE product_catagory SET 
										name='$cat_name' 
										where id=$rid";
										$results=$db->update($query);
										if($results==true){
											?> 
											<div class="alert alert-success alert-dismissible">
												<button type="button" class="close" data-dismiss="alert">&times;</button>
											  <strong>Catagory Update Successfully</strong>  
											</div>
											<?php 
										}else{
											?> 
											<div class="alert alert-danger">
											  <strong>Somthing Problem</strong>  
											</div>
											<?php 
										}
									}						
								?>
							
								<div style="background:#fff;  "> 
										
											<?php
												if($rid==true){
											?>
									<form action="" method="post">
									<div class="form-row">
										<div class="col-sm-12 col-md-12"> 
										<?php
											$query="SELECT * From product_catagory where id=$rid";
											$results=$db->select($query);
											$id=0; 
											if($results==true){
												while($rse=$results->fetch_assoc()){
												$id++; 
										?> 
											<div class="col-sm-12 col-md-12"> 
												<div class="input-group">
													<input type="text" name="cat_name" value="<?php echo $rse['name']; ?>" class="form-control" placeholder="Search">
													<div class="input-group-btn">
													  <button type="submit" name="submitedit" class="btn btn-success btn_color btn-bg" type="submit">
														<i class="fas fa-plus"></i> Update Catagory
													  </button>
													</div>
												</div>
											</div>
										
										 <?php } }?>
										</div> 
												<?php }else{?> 
										<form action="" method="post">	
											<div class="col-xs-12">  
												<select class="form-control" name="main_cat" required>
													<option value=""selected disabled>Select Main Catagory</option>
													<?php
														$catquery="SELECT * From product_catagory";
														$catres=$db->select($query); 
														if($catres==true){
															while($cat=$catres->fetch_assoc()){
													?> 
													<option value="<?php echo $cat['id'];?>"> <?php echo $cat['name'];?> </option>
													
													<?php }}?> 
												
												</select>
											</div>											
											<div class="col-sm-12 col-md-12"> 
												<div class="input-group">
												
													<input type="text" name="cat_name" class="form-control" placeholder="Enter catagory name" required>
													<div class="input-group-btn">
													  <button type="submit" name="sub_submit" class="btn btn-success btn_color btn-bg" type="submit">
														<i class="fas fa-plus"></i> Add
													  </button>
													</div>
												</div>
											</div>
										</form> 
										
														<?php } ?> 
														<br /> 
														<hr />
										</div> 
							<table id="example" class=" table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>s.L No</th> 
										<th>Sub Catagory</th> 
										<th>Catagory</th> 
										<th>Action</th> 
									</tr>
								</thead>
								<tbody>
								<?php
									$query="SELECT * From sub_catagory";
									$results=$db->select($query);
									$id=0; 
									if($results==true){
										while($rs=$results->fetch_assoc()){
										$id++; 
								?> 
									 <tr class="unread">
									  <td class="inbox-small-cells">
										  <?php echo $id; ?>
									  </td>
									  <td class="inbox-small-cells"> <?php echo$rs['sub_cat_name']; ?></td>  
									  <td class="inbox-small-cells"> 
										<?php  
										$main_cat=$rs['main_cat_id'];
										$main_cat_name = $db->select("SELECT * FROM product_catagory where id='$main_cat'")->fetch_assoc()['name']; 

										echo $main_cat_name; 
										
										?>  
									 
									  </td>  
									  <td ><a href="add_product_catagory.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-success btn-bg"><i class="fas fa-edit"></i></a> <a href="add_product_catagory.php?delid='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td> 
								  </tr> 
								  <?php } }?>
								</tbody>
								<tfoot>
									
								</tfoot>
							</table>
						</div> 
							
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<?php 
include('inc/footer_sales_history.php'); 
?>
