<?php 
include('inc/sales_index_header.php');
error_reporting(0);
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

<div class='dashboard'>    
    
    <?php  include('inc/sales_side_bar.php'); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content'>
            <div class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h5> Add New Product</h5>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-4">
							<div style="border: 2px solid #eee; padding: 10px;">  
								<?php 
									if(isset($_POST["submit"])){	 
									$product_code			=$fm->validation($_POST['product_code']);
									$product_name			=$fm->validation($_POST['product_name']);
									$catagory				=$fm->validation($_POST['catagory']);								
									$sub_cat				=$fm->validation($_POST['sub_cat']);	 
									$product_type			=$fm->validation($_POST['product_type']); 
									$status					=$fm->validation($_POST['status']); 
									
									$product_code			=mysqli_real_escape_string($db->link,$product_code);
									$product_name			=mysqli_real_escape_string($db->link,$product_name);
									$catagory				=mysqli_real_escape_string($db->link,$catagory);						
									$sub_cat				=mysqli_real_escape_string($db->link,$sub_cat);	 
									$product_type			=mysqli_real_escape_string($db->link,$product_type); 
									$status					=mysqli_real_escape_string($db->link,$status); 
									
									$query="select * from product_table where product_code='$product_code'";
									$res=$db->select($query);	
									
									if($res==!true){
										$sql ="INSERT INTO product_table(`product_code`, `product_name`, `product_cat_id`, `sub_cat_id`, `product_type`, `status`)
										values('$product_code','$product_name','$catagory','$sub_cat','$product_type','$status')"; 
										$results=$db->insert($sql); 
										if($results==true){ ?> 
											<script> alert("Product Added Successfully") </script>
										<?php  
										} 			
									}else{									
												
										?>
										
										<script> alert("Product code alreay exist.") </script>
										
										<?php
									} 
									 
								}
									if(isset($_POST["update"])){	 
									$product_code			=$fm->validation($_POST['product_code']);
									$product_name			=$fm->validation($_POST['product_name']);
									$catagory				=$fm->validation($_POST['catagory']);								
									$sub_cat				=$fm->validation($_POST['sub_cat']);
									$product_type			=$fm->validation($_POST['product_type']); 									
									$status					=$fm->validation($_POST['status']); 
									
									$product_code			=mysqli_real_escape_string($db->link,$product_code);
									$product_name			=mysqli_real_escape_string($db->link,$product_name);
									$catagory				=mysqli_real_escape_string($db->link,$catagory);						
									$sub_cat				=mysqli_real_escape_string($db->link,$sub_cat);	 
									$product_type			=mysqli_real_escape_string($db->link,$product_type); 
									$status					=mysqli_real_escape_string($db->link,$status); 
									
									
									$sql ="Update product_table SET  
									`product_code` ='$product_code', 
									`product_name` ='$product_name', 
									`product_cat_id`='$catagory', 
									`sub_cat_id` 	='$sub_cat', 
									`product_type`	='$product_type', 
									`status`		='$status'
									 where id ='$rid'"; 
									$results=$db->update($sql); 
									
									$sqlStockTable="UPDATE `stock_product` SET  
									`sub_cat_id` 	='$sub_cat' 
									 where product_code ='$product_code'"; 
									$results2=$db->update($sqlStockTable);
									
									if($results==true){ ?> 
										<script> alert("Product update Successfully") </script>
									<?php  
									} else{	 
									?> 
									<script> alert("Something is wrong") </script> 
									<?php
									} 
									 
								}									
							?>  
							
							
								 <div class="from_border" style="text-align:left">		

								<?php
								if($rid==false){ 
								?>
								 
								  <form action="" method ="post" enctype="">
								  <div class="col-xs-12">
										<label for="ex2" style="font-weight:bold;">Product Code. <span style="color:red">*</span></label>
										<?php
										$query1="SELECT * FROM product_table order by id DESC Limit 1 ";
										$res=$db->select($query1);
										$id=0; 
										if($res==true){
											while($res1=$res->fetch_assoc()){
												$id++; 
									
												$code= $res1['product_code'];
												$nextentry=$code+1; 										
												 
										?>
										<input class="form-control" id="ex2" type="number" name="product_code" value="<?php echo $nextentry;?>" readonly>
										
										<?php
											}
										}else{
											?>
										<input class="form-control" id="ex2" type="number" name="product_code" value="1001" readonly>
										
										<?php
										}
									?> 
										
									</div>
									<div class="col-xs-12">
										<label for="ex2" style="font-weight:bold;"> Product Name. <span style="color:red">*</span></label>
										<input class="form-control" id="ex2" type="text" name="product_name" Placeholder="Ex. Motor" required>
									</div>
									 
									 <div class="col-xs-12">
										<div class="form-group">
										  <label style="font-weight:bold;">Select Catagory <span style="color:red">*</span></label>
										  
										   <?php		
											$query="SELECT * FROM product_catagory";
											$results=$db->select($query);
											$oppro="";
											if ($results==true){
														while($catid=$results->fetch_assoc()){
														$oppro.="<option value='".$catid['id']."'>".$catid['name']."</option>";
												}
											} 
											?>
										  <div class="select2-purple">
											<select class="select2" name="catagory" multiple="multiple" 
											data-placeholder="Type Product Code" onchange="getId(this.value)" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
											 
											  <?php echo $oppro; ?>
											</select>
										  </div>
										</div>  
									  </div> 
									  <div class="col-xs-12">
											<label style="font-weight:bold;">Select Sub Catagory</label>
											<select class="form-select form-select-sm" name="sub_cat" id="sub_cat" aria-label=".form-select-sm example">
											   
											</select>
									  </div> 
									   <div class="col-xs-12">
											<label style="font-weight:bold;">Weight Type</label>
											<select class="form-select form-select-sm" name="product_type" aria-label=".form-select-sm example">
											<option selected>Select</option>
											<option value="1">Bales</option>
											<option value="2">Bag</option> 
											</select>
									  </div>
										<div class="col-xs-12 ">							
											<div class="form-check-inline">
											  <label class="form-check-label"> 
												<input type="radio" class="form-check-input" name="status" value="1" checked> Active 
												<input type="radio" class="form-check-input" name="status" value="0" > Inactive 
											  </label>
											</div>
										   </div>		 
										<br> 
									  
									 <div class="col-xs-3 margin_top">							
										<input class="form-control btn btn-primary" id="ex2" name="submit" type="submit" value="Add Product">
									 </div> 		 
								 </form>
									 <?php 
									
									 }else{
										$query1 ="SELECT * FROM product_table where id=$rid"; 
										$results1 = $db->select($query1); 
										if ($results1){ 
										 while ($rs1 = $results1->fetch_assoc()) { 
										 ?> 
									 
									   <form action="" method ="post">
										<div class="col-xs-12"> 
										<label for="ex2" style="font-weight:bold;">Product Code. <span style="color:red">*</span></label>
										
										<input class="form-control" id="ex2" type="number" name="product_code" value="<?php echo $rs1['product_code']; ?>" readonly>
										
									</div>
									<div class="col-xs-12">
										<label for="ex2" style="font-weight:bold;"> Product Name. <span style="color:red">*</span></label>
										<input class="form-control" id="ex2" type="text" name="product_name" value="<?php echo $rs1['product_name']; ?>" required>
									</div>
									 
									 <div class="col-xs-12">
										<div class="form-group">
										  <label style="font-weight:bold;">Select Catagory <span style="color:red">*</span></label>
										  
										   <?php		
											$query="SELECT * FROM product_catagory";
											$results=$db->select($query);
											$oppro="";
											if ($results==true){
														while($catid=$results->fetch_assoc()){
														$oppro.="<option value='".$catid['id']."'>".$catid['name']."</option>";
												}
											} 
											?>
										  <div class="select2-purple">
											<select class="select2" name="catagory" multiple="multiple" 
											data-placeholder="Type Product Code" onchange="getId(this.value)" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
												<option value="<?php echo $rs1['product_cat_id']; ?>" selected>  
													<?php  
													$productid=$rs1['product_cat_id'];
													$cat_name1 = $db->select("SELECT * FROM product_catagory where id='$productid'")->fetch_assoc()['name'];  
													echo $cat_name1; 
													?>  
												</option> 
												<?php echo $oppro; ?>
											</select>
										  </div>
										</div>  
									  </div> 
									  <div class="col-xs-12">
											<label style="font-weight:bold;">Select Sub Catagory</label>
											<select class="form-select form-select-sm" name="sub_cat" id="sub_cat" aria-label=".form-select-sm example">
												<option value="<?php echo $rs1['sub_cat_id']; ?>" selected>  
													<?php  
													$subid=$rs['sub_cat_id'];
													if (isset($subid) && !empty($subid)){
														$scat_name = $db->select("SELECT * FROM sub_catagory where id='$subid'")->fetch_assoc()['sub_cat_name'];  
													
														echo $scat_name; 
													}else{
														echo 'Not Asign'; 
													}
													?>  
												</option> 
											   
											</select>
									  </div>
									  <div class="col-xs-12">
											<label style="font-weight:bold;">Weight Type</label>
											<select class="form-select form-select-sm" name="product_type" aria-label=".form-select-sm example">
												<option value="<?php echo $rs1['product_type']; ?>" selected>  
													<?php  
														$pro_type = $rs1['product_type'];
														if (!empty($pro_type) && $pro_type == 1) {
															echo "Bales"; 
														} elseif (!empty($pro_type) && $pro_type == 2) {
															echo "Bag";  
														}
													?>

												</option> 
												<option value="1">Bales</option>
												<option value="2">Bag</option> 
											 
											</select>
									  </div>
									   
										<div class="col-xs-12 ">							
											<div class="form-check-inline">
											  <label class="form-check-label"> 
												<input type="radio" class="form-check-input" name="status" value="1" checked> Active 
												<input type="radio" class="form-check-input" name="status" value="0" > Inactive 
											  </label>
											</div>
										   </div>		 
										<br> 
									  
									 <div class="col-xs-3 margin_top">							
										<input class="form-control btn btn-primary" id="ex2" name="update" type="submit" value="Update Product">
									 </div> 		 
								 </form>
									 
									<?php }}}?> 



								 
								</div> 
								
							</div> 
						</div> 
						
						<div class="col-md-8">
							<table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
							<!-- Test -->
									<tr class="bg-light">
										<th>S.L No</th>
										<th>P.Code</th>
                                        <th>Name</th>								
                                        <th>Sub Catagory</th> 
                                        <th>Catagory</th> 
                                        <th>Weight Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                 
								    <?php		
									 
									$query1="SELECT * FROM product_table where status='1' ORDER BY id DESC";
									$results1=$db->select($query1);
									$id=0; 
									if ($results1){	
									?>
									<?php
									while($rs=$results1->fetch_assoc()){
									$id++; 						
									?> 
										<tr>
											<td><?php echo $rs['id'];?> </td> 
											<td><?php echo $rs['product_code'];?> </td> 
											<td><?php echo $rs['product_name'];?> </td>
											<td>
											<?php  
											$subid=$rs['sub_cat_id'];
											if (isset($subid) && !empty($subid)){
												$scat_name = $db->select("SELECT * FROM sub_catagory where id='$subid'")->fetch_assoc()['sub_cat_name'];  
											
												echo $scat_name; 
											}else{
												echo 'Not Asign'; 
											}
											
											?>
											</td> 
											<td>
											<?php  
											$productid=$rs['product_cat_id'];
											$cat_name = $db->select("SELECT * FROM product_catagory where id='$productid'")->fetch_assoc()['name'];  
											echo $cat_name; 
											
											?> 
											</td> 
											<td><?php 
											
											$status= $rs['status'];
											if($status=1){
												echo "<span style='color:green; font-weight: bold;'>Active<span> ";
											}else{
												echo "<span style='color:red; font-weight: bold;'>Inactive<span> ";
											}
											
											?> 
											</td> 
											<td>
											<?php  
												$pro_type = $rs['product_type'];
												if (!empty($pro_type) && $pro_type == 1) {
													echo "Bales"; 
												} elseif (!empty($pro_type) && $pro_type == 2) {
													echo "Bag";  
												}else{
													echo "Not Asign";  
												}
											?> 
											</td> 
											<td>   
											<a href="new_product.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-primary">Edit</a>
											 
											</td>  
										</tr>	
									<?php }}else{?>
									 
							 
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p> 
									</div> 
									<?php }?>
								</tbody>
								<tfoot class="bg-light"> 
								</tfoot>
                            </table>
							
						</div>
 
                    </div>
                </div>
            </div>
        </div>
		
    </div>
</div>

 
 	<script type="text/javascript">
		function getId(str) { 
		  var xhttp = new XMLHttpRequest();
		  var xhttp1 = new XMLHttpRequest();
		  
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {		
			 document.getElementById("sub_cat").innerHTML = this.responseText;
			
			}
		  }; 
		  xhttp.open("GET", "get_sub.php?id="+str, true);
		  xhttp.send();	 
		 
		}  
	 </script>


<?php 
include('inc/footer.php'); 
?>
