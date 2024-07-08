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
		
	 
		if (empty($_GET['eid'])){
		}elseif(!isset($_GET['eid']) || $_GET['eid'] == NULL){
			echo 'Something went to wrong';
		}else{
				$eid= $_GET['eid'];
				$eiderr= preg_replace("/[^0-9a-zA-Z]/", "", $eid);
				$editID = $eiderr;
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
                        <h5> Product Opening Balance</h5>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-4">
							<div style="border: 2px solid #eee; padding: 10px;">  
							
							
							
							<?php 
								if (isset($_POST["submit"])) {
									$opening_date       = $fm->validation($_POST['opening_date']);
									$product_code       = $fm->validation($_POST['product_code']);
									$product_name       = $fm->validation($_POST['product_name']);
									$catagory           = $fm->validation($_POST['catagory']);                              
									$sub_cat            = $fm->validation($_POST['sub_cat']);                                
									$location           = $fm->validation($_POST['location']);                                
									$op_stock           = $fm->validation($_POST['op_stock']);                                
									$purchase_price     = $fm->validation($_POST['purchase_price']); 

									$opening_date       = mysqli_real_escape_string($db->link, $opening_date);
									$product_code       = mysqli_real_escape_string($db->link, $product_code);
									$product_name       = mysqli_real_escape_string($db->link, $product_name);
									$catagory           = mysqli_real_escape_string($db->link, $catagory);                       
									$sub_cat            = mysqli_real_escape_string($db->link, $sub_cat);                       
									$location           = mysqli_real_escape_string($db->link, $location);                       
									$op_stock           = mysqli_real_escape_string($db->link, $op_stock);  
									
									// Check if the combination already exists
									$checkQuery = "SELECT * FROM stock_product WHERE product_code = '$product_code' 
													AND catogry_id = '$catagory' AND sub_cat_id = '$sub_cat' AND location = '$location'";
									$checkResult = $db->select($checkQuery);

									if ($checkResult->num_rows == 0) { // Combination doesn't exist, insert new row
									
										//Stock Table Entry 
										$stockQuery = "INSERT INTO `stock_product`(`product_code`, `catogry_id`, `sub_cat_id`, `location`, 
														`stock_quantity`, `purches_price`, `price`, `saler_id`, `status_id`, `date`)
														VALUES('$product_code', '$catagory', '$sub_cat', '$location', '$op_stock', 
														'$purchase_price', '0', '0', '0', '$opening_date')";
														
										//Transection Table Entry 
										$trasection = "INSERT INTO `product_transection`(`product_code`, `catogry_id`, `sub_cat_id`, `location`, `quntity`, `purches_price`, 
														`sale_price`, `saler_id`, `status_id`, `trans_type`, `create_date`, `update_date`)
														VALUES('$product_code', '$catagory', '$sub_cat', '$location', '$op_stock', 
														'$purchase_price', '0', '0', '0', 'Opening', '$opening_date', '0')";

														
									$results = $db->insert($stockQuery); 
									$results = $db->insert($trasection); 
									if ($results == true) { 
											?>
										<script> alert("Product Added Successfully") </script>
												<?php  
													}
												} else { // Combination already exists
										?>
								<script> alert("Product code already exists.") </script>
								<?php } } ?>
								
								
								<?php 
								if (isset($_POST["update"])) {
									$opening_date       = $fm->validation($_POST['opening_date']);
									$product_code       = $fm->validation($_POST['product_code']);
									$product_name       = $fm->validation($_POST['product_name']);
									$catagory           = $fm->validation($_POST['catagory']);                              
									$sub_cat            = $fm->validation($_POST['sub_cat']);                                
									$location           = $fm->validation($_POST['location']);                                
									$op_stock           = $fm->validation($_POST['op_stock']);                                
									$purchase_price     = $fm->validation($_POST['purchase_price']); 

									$opening_date       = mysqli_real_escape_string($db->link, $opening_date);
									$product_code       = mysqli_real_escape_string($db->link, $product_code);
									$product_name       = mysqli_real_escape_string($db->link, $product_name);
									$catagory           = mysqli_real_escape_string($db->link, $catagory);                       
									$sub_cat            = mysqli_real_escape_string($db->link, $sub_cat);                       
									$location           = mysqli_real_escape_string($db->link, $location);                       
									$op_stock           = mysqli_real_escape_string($db->link, $op_stock);  
									
									  
										//Stock Table Entry 
										$stockQuery = "Update `stock_product` set
										`product_code` 		='$product_code',
										`catogry_id`		='$catagory', 
										`sub_cat_id`		='$sub_cat',
										`location` 			='$location',
										`stock_quantity` 	='$op_stock', 
										`purches_price` 	='$purchase_price', 
										`price` 			='0', 
										`saler_id`			='0', 
										`status_id`			='0', 
										`date`				='$opening_date'
										where id			='$editID'"; 
										
									
										//Transection Table Entry 
										$trasection = "Update `product_transection` set
										`product_code`		='$product_code', 
										`catogry_id`		='$catagory', 
										`sub_cat_id`		='$sub_cat', 
										`location`			='$location', 
										`quntity`			='$op_stock', 
										`purches_price`		='$purchase_price',
										`sale_price` 		='0', 
										`saler_id`			='0', 
										`status_id`			='0', 
										`trans_type`		='Opening', 
										`update_date`		='$opening_date'
										 where 	`product_code`='$product_code' and `catogry_id`='$catagory' and
										 `location`='$location' and `trans_type`='Opening'"; 
										 
										 $results = $db->update($stockQuery); 
										 $results = $db->update($trasection); 
									 
									
									if ($results == true) { 
											?>
										<script> alert("Stock Update Successfully") </script>
												<?php   
												} else { // Combination already exists
										?>
								<?php } } ?> 
								
								
								 <div class="from_border" style="text-align:left">


								<?php if($editID==false){ ?>
								 <a href="product_list.php" class="btn btn-sm btn-danger"> Return </a>  
								  <form action="" method ="post" enctype=""> 
									<div class="col-xs-12">
										<label for="ex2" style="font-weight:bold;"> Product Name. <span style="color:red">*</span></label>
										
										<?php
										$query ="SELECT * FROM product_table where id=$rid"; 
										$results = $db->select($query); 
											if ($results){ 
										 while ($rs = $results->fetch_assoc()) {  
										?> 	
										<input class="form-control" id="ex2" type="hidden" name="product_code" value="<?php echo $rs['product_code']; ?>" required>
										<input class="form-control" id="ex2" type="hidden" name="catagory" value="<?php echo $rs['product_cat_id']; ?>" required>
										<input class="form-control" id="ex2" type="hidden" name="sub_cat" value="<?php echo $rs['sub_cat_id']; ?>" required> 
										<input class="form-control" id="ex2" type="text" value="<?php echo $rs['product_name']; ?>" disabled>
										
										<?php }} ?>
										
										
									</div> 
									  <div class="col-xs-12">
										<div class="form-group">
										  <label style="font-weight:bold;" >Location </label>
										  <div class="select2-purple">
											<select class="select2" name="location" multiple="multiple" 
											data-placeholder="Type Location Name" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
											
											
											
											  
											 <?php		
												$query="SELECT * FROM product_location";
												$results=$db->select($query);
												$id=0; 
												if ($results){	
												?>
												
												<?php
												while($brid=$results->fetch_assoc()){
												$id++; 
												
												?>
											  <option value="<?php echo $brid['id'];?> " >
											  
											<?php echo $brid['name']; ?>
											  
											  </option>
												<?php } ?>
												<?php } ?>
											  
											  
											</select>
										  </div>
										</div>
										<!-- /.form-group -->
									  </div>  
											
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Opening Stock:</label>
											<input class="form-control" id="ex2" type="number" name="op_stock" value="0" >
										</div>	
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Purchase Price:</label>
											<input class="form-control" id="ex2" type="number" name="purchase_price" placeholder="500" >
										</div>	
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Opening Date:</label>
											<input class="form-control" id="ex2" type="date" name="opening_date" value="2024-01-31">

										</div>											
									  
									 <div class="col-xs-3 margin_top">	
										</br> 
										<input class=" btn btn-primary" id="ex2" name="submit" type="submit" value="Add Product">
									 </div> 		 
								 </form> 

								<?php }else{ 
								
										$query1 ="SELECT * FROM stock_product where id=$editID"; 
										$results1 = $db->select($query1); 
										if ($results1){ 
										 while ($rs1 = $results1->fetch_assoc()) { 
								 ?>
								
								
								
								<form action="" method ="post" enctype=""> 
									<div class="col-xs-12">
										<label for="ex2" style="font-weight:bold;"> Product Name. <span style="color:red">*</span></label>
										
										 
										<input class="form-control" id="ex2" type="hidden" name="product_code" value="<?php echo $rs1['product_code']; ?>" required>
										<input class="form-control" id="ex2" type="hidden" name="catagory" value="<?php echo $rs1['catogry_id']; ?>" required>
										<input class="form-control" id="ex2" type="hidden" name="sub_cat" value="<?php echo $rs1['sub_cat_id']; ?>" required> 
										<?php
											$productname=$rs1['product_code']; 
											$pro_name = $db->select("SELECT * FROM product_table where product_code='$productname'")->fetch_assoc()['product_name'];  
											 
										?>
										<input class="form-control" id="ex2" type="text" value="<?php echo $pro_name ?>" disabled>
									 
										
									</div> 
									  <div class="col-xs-12">
										<div class="form-group">
										  <label style="font-weight:bold;" >Location </label>
										  <div class="select2-purple">
											<select class="select2" name="location" multiple="multiple" 
											data-placeholder="Type Location Name" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
											
											<!--Selected Product for edit--> 
											 <option value="<?php echo $rs1['location'];?> " selected> 
												<?php   
												$location= $rs1['location']; 
												$location_name = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name']; 
												echo $location_name; 
												?> 
											 </option>  
											 	<!--Selected Product for edit--> 
											 
											 
											 <?php		
												$query="SELECT * FROM product_location";
												$results=$db->select($query);
												$id=0; 
												if ($results){	
												?>
												
												<?php
												while($brid=$results->fetch_assoc()){
												$id++; 
												
												?>
											  <option value="<?php echo $brid['id'];?> " >
											  
											<?php echo $brid['name']; ?>
											  
											  </option>
												<?php } ?>
												<?php } ?>
											  
											  
											</select>
										  </div>
										</div>
										<!-- /.form-group -->
									  </div>  
											
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Opening Stock:</label>
											<input class="form-control" id="ex2" type="number" name="op_stock" value="<?php echo $rs1['stock_quantity']; ?>" >
										</div>	
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Purchase Price:</label>
											<input class="form-control" id="ex2" type="number" name="purchase_price" value="<?php echo $rs1['purches_price']; ?>" >
										</div>	
										<div class="col-xs-6">
											<label for="ex2" style="font-weight:bold;">Opening Date:</label>
											<input class="form-control" id="ex2" type="date" name="opening_date" value="<?php echo $rs1['date']; ?>">

										</div>											
									  
									 <div class="col-xs-3 margin_top">	
										</br> 
										<input class=" btn btn-primary" id="ex2" name="update" type="submit" value="Update Info">
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
                                        <th>Catagory</th> 
                                        <th>Sub Catagory</th>  
                                        <th>Location</th>  
                                        <th>Opening</th>  
                                        <th>Purchase Price</th> 
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                 
								    <?php	 
									$query1="SELECT * FROM stock_product ORDER BY id DESC";
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
											<td>
											<?php  
											$product_code=$rs['product_code'];
											$product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];  
												echo $product_coderes;  
											
											?> 
											</td>
											<td>
											<?php  
											$productid=$rs['catogry_id'];
											$cat_name = $db->select("SELECT * FROM product_catagory where id='$productid'")->fetch_assoc()['name'];  
											echo $cat_name; 
											
											?> 
											</td> 
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
											$location=$rs['location'];
											if ($location==true){
											$locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];  
												echo $locationres;  
											}
											?>
											</td>
											<td>
											<?php  
											  echo $rs['stock_quantity']; 
											?> 
											</td>
											<td>
											<?php  
											  echo $rs['purches_price']; 
											?> 
											</td>
											
											 
											<td>    
											<a href="product_opening.php?eid='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-primary">Edit</a>  
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

