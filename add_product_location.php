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
				$query ="DELETE FROM product_location WHERE id=$delteach";
				$del =$db->delete($query);

				if($del){
					echo "<script> alert ('Product Location delete Successfully') </script>";
					echo "<script> window:location ='add_product_location.php'; </script>";
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
                        <h5>Products Location </h5>
                    </div>
                    <div class='card-body text-center' style="min-height:600px;">

                        <div class="mx-auto" style="max-width:500px; box-shaddow:0px 2px 2px 0px">
                        <?php 
                                if(isset($_POST['submit'])){
                                    $cat_name=$_POST['cat_name'];
                                    
                                    $query="INSERT INTO product_location(name) values ('$cat_name')";
                                    $results=$db->insert($query);
                                    if($results==true){
                                        ?> 
									<div class="alert alert-success alert-dismissible">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Location Added Successfully</strong>  
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
								$query="UPDATE product_location SET 
								name='$cat_name' 
								where id=$rid";
								$results=$db->update($query);
								if($results==true){
									?> 
									<div class="alert alert-success alert-dismissible">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Location Update Successfully</strong>  
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
											$query="SELECT * From product_location where id=$rid";
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
												<i class="fas fa-plus"></i> Update Location
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
												<i class="fas fa-plus"></i> Add Location
											  </button>
											</div>
										  </div>
									  </div>
									</form> 
									<?php } ?> 
									<br /> 
									<hr />
									
									<table id="example" class=" table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
												<th>s.L No</th> 
												<th>Location </th> 
												<th>Action</th> 
											</tr>
										</thead>
										<tbody>
										<?php
											$query="SELECT * From product_location";
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
											  <td ><a href="add_product_location.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-success btn-bg"><i class="fas fa-edit"></i></a> <a href="add_product_location.php?delid='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td> 
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
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<?php 
include('inc/footer_sales_history.php'); 
?>
