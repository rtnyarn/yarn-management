<?php include('inc/sales_index_header.php');
	
 ?>
<?php

$value2 = '';

// Query to fetch the last inserted invoice number
$query = "SELECT invoice_no FROM sales_invoice2 ORDER BY invoice_no DESC LIMIT 1";
$stmt = $db->select($query);

// Check if the query execution was successful
if ($stmt !== false) {
    // Check if rows were returned
    if (mysqli_num_rows($stmt) > 0) {
        $row = mysqli_fetch_assoc($stmt);
        $value2 = $row['invoice_no'];
		$numeric_part = (int) preg_replace('/[^0-9]/', '', $value2); 

        // Check if the value is not NULL
        if ($numeric_part !== null) { 
            $value2 = $numeric_part + 1; // Incrementing numeric part
            $value = $value2;
			$type='SA';
			$Inv=$type.'-'.$value;
        } else {
            // If the value is NULL, set the initial value to 10001
            $value = 1001;
			$type='SA';
			$Inv=$type.'-'.$value;
        }
    } else {
        // If no rows found, set the initial value to 10001
        $value = 1001;
		$type='SA';
		$Inv=$type.'-'.$value;
    }
} else {
    // Display the MySQL error message
    echo "Query failed. Error: " . mysqli_error($db->link);
    // Set the initial value to 10001 as a fallback
    $value = 1001;
	$type='SA';
	$Inv=$type.'-'.$value; 
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
                    <div class='card-header text-center'>
					<h6 class="text-left">  Sales Panel || Sales Register || Sales ID:-<?php echo $Inv?> <h6>							 
                    </div>
                    <div class='card-body' style="min-height:600px;">
                    <?php 
							if(isset($_POST["addProdduct"])) {   
								$supp_code 			=$fm->validation($_POST["supp_code"]);							
								$product_id 		=$fm->validation($_POST["product_id"]); 
								$cat_id  			=$fm->validation($_POST["cat_id"]);	
								$sub_cat  			=$fm->validation($_POST["sub_cat"]);	
								$location  			=$fm->validation($_POST["location"]);	
								$qty	  			=$fm->validation($_POST["qty"]); 
								$purchase_price  	=$fm->validation($_POST["purchase_price"]); 
								$sell_price  		=$fm->validation($_POST["sell_price"]);	  
   
								$supp_code 			=mysqli_real_escape_string($db->link,$supp_code);
								$product_id 		=mysqli_real_escape_string($db->link,$product_id);
								$cat_id  			=mysqli_real_escape_string($db->link,$cat_id);
								$sub_cat  			=mysqli_real_escape_string($db->link,$sub_cat);
								$location  			=mysqli_real_escape_string($db->link,$location);
								$qty	  			=mysqli_real_escape_string($db->link,$qty);
							
								$sell_price  		=mysqli_real_escape_string($db->link,$sell_price);
							
								$total		=$qty*$sell_price;		
								
								$querystock="SELECT * FROM stock_product where product_code='$product_id' and location='$location' ";
									$resultsstock=$db->select($querystock);															
									if ($resultsstock){
										while($stcok=$resultsstock->fetch_assoc()){
											$stock	=$stcok['stock_quantity'];
											$sale_price	=$stcok['price'];
											if ($stock >= $qty){
												$invq="INSERT INTO `temp_sales_register2`
												(`sales_invoice`, `suppliar_id`, `product_code`, `cat_id`, 
												`sub_cat`, `location`, `qty`, `price`, `total`) 
												VALUES ('$Inv','$supp_code','$product_id','$cat_id','$sub_cat',
												'$location','$qty','$sell_price', '$total')";
												 $db->insert($invq);
											}else{
												echo "<script type='text/javascript'>alert('Product Not Available')</script>";  
											}
										}
									}
																
							}
							//End temp_sales_table
							
							
							
							
							if (isset($_POST["submit"])){ 
							
								$invoice_no			=$fm->validation($_POST["invoice_no"]);
								$customer_id 		=$fm->validation($_POST["supp_code"]);	 
								$note				=$fm->validation($_POST["narration"]);
								$payment_status		=$fm->validation($_POST["payment_status"]);	
								$date  				=$fm->validation($_POST["date"]);
								$labor_bill			=$fm->validation($_POST["labor_bill"]);
								
								
								

								
								$invoice_no			=mysqli_real_escape_string($db->link,$invoice_no);								
								$customer_id		=mysqli_real_escape_string($db->link,$customer_id);								
								$note				=mysqli_real_escape_string($db->link,$note);								
								$payment_status		=mysqli_real_escape_string($db->link,$payment_status);								
								$labor_bill  		=mysqli_real_escape_string($db->link,$labor_bill);								
								$date  				=mysqli_real_escape_string($db->link,$date);								
							
								
								
									//purchase_invoice Table 
									$qry="select SUM(total) as total_amount FROM temp_sales_register2 where sales_invoice='$Inv'";
									$totalRes=$db->select($qry);						
									if ($totalRes){	
										while($invqtytotal=$totalRes->fetch_assoc()){			
										
											$sales_total		=$invqtytotal['total_amount']; 
											$grand_total2		=$sales_total+$labor_bill; 

											
											$query1="INSERT INTO `sales_invoice2`(`invoice_no`, `customer`, `sales_total`, `narration`, 
											`payment_status`, `date`, `updated`, `user_id`, `reciept_cat`) 
											values('$Inv','$customer_id','$grand_total2',
											'$note','$payment_status','$date','0000-00-00','0','0')"; 
											
											$results=$db->insert($query1);  
									
																			
										//select product from temp_sales_register 								
										$product_query="SELECT * FROM temp_sales_register2 where sales_invoice='$Inv'";
										$pro_r=$db->select($product_query);
										$id=0; 
										if ($pro_r==true){	
											while($pro_res=$pro_r->fetch_assoc()){
												$id++; 
												
												$purchase_invoice	=$pro_res['sales_invoice']; 
												$suppliar_id		=$pro_res['suppliar_id']; 
												$product_code		=$pro_res['product_code'];
												$cat_id				=$pro_res['cat_id'];
												$sub_cat			=$pro_res['sub_cat'];
												$location			=$pro_res['location'];
												$qty				=$pro_res['qty'];	
												$purchase_price		=$pro_res['purchase_price']; 
												$sale_price			=$pro_res['price'];	 
												
											
												$product_transection="INSERT INTO `product_transection`(`invoice_no`, `product_code`, `catogry_id`, 
												`sub_cat_id`, `location`, `quntity`, `purches_price`, `sale_price`, `saler_id`, `status_id`, `trans_type`,
												`create_date`, `update_date`) VALUES 
												('$Inv','$product_code', '$cat_id',	'$sub_cat','$location','$qty', '$purchase_price', '$sale_price', 
												'0','1','Sales','$date','0000-00-00')"; 
												$results=$db->insert($product_transection);
												 
												//update product stock
												$lstpro=$db->select("SELECT `stock_quantity` FROM `stock_product` WHERE `product_code`='$product_code'
												and `location`='$location'");
												
												$lastdata=$lstpro->fetch_assoc()["stock_quantity"];
												$newqty=$lastdata-$qty;
												$db->update("UPDATE `stock_product` SET `stock_quantity`='$newqty' WHERE `product_code`='$product_code' 
												and  `location`='$location'");
												
												
											 }
											 
											//Delete temporary Table Data 
											$deltemqery="DELETE FROM temp_sales_register2 ";
											$delq=$db->delete($deltemqery); 
											
										}
										 
										if ($results==true){?>  
							 
														
											<script> alert("Product Sales Succesfully.") </script>
											<script type='text/javascript'>window.location='sales_index_register.php'; </script>	
															
																
												 
											<?php 
										} 
									}
								} 
							} 
							
							?>
										<div class="row">
											<div class="col-md-4 ">
												<div style="background:#ffff; border-radius:5px; padding:10px;"> 
														<form action="" method ="post" enctype="">
															<div class="form-group">
																<div id="filterDate2">
																	<!-- Datepicker as text field -->   
																	<div class="input-group date" data-date-format="dd.mm.yyyy"> 

																	<?php
																		$date = ($result = $db->select("SELECT Date FROM date_entry ORDER BY id DESC LIMIT 1"))->num_rows > 0 ?
																			$result->fetch_assoc()['Date'] : null;
																		?>
																		<input type="text" class="form-control" name="date" value="<?php echo $date ?>">


																		<div class="input-group-addon" >
																		<span class="glyphicon glyphicon-th"></span>
																		</div>
																	</div> 
																</div>    
															</div> 
														<script>
															$( '#single-select-field' ).select2( {
																theme: "bootstrap-5",
																width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
																placeholder: $( this ).data( 'placeholder' ),
															} );
														</script>
									 
														<div class="form-group">												
															<input type="hidden" class="form-control" name="invoice_no" value="<?php echo $value?>"  READONLY />
														</div>							  
                                          
										
											<div class="form-group">
												<div class="col-xs-12">
													<label>Ledger Name</label>
												  <div class="select2-purple">

													<select class="select2 form-control" name="supp_code" multiple="multiple" 
													data-placeholder="Type Suppliar A/C" data-dropdown-css-class="select2-purple"required>
													
													<?php		
														$queryin="SELECT * FROM temp_sales_register2 order by id DESC limit 1";
														$results1=$db->select($queryin); 
														if ($results1==true){ 
														while($tem_res=$results1->fetch_assoc()){														
															$suppliar_id=$tem_res['suppliar_id'];
															
																if($suppliar_id==true){
																		$query="SELECT * FROM customers where ac='$suppliar_id'";
																		$results=$db->select($query); 
																			if ($results){
																					while($dis=$results->fetch_assoc()){?>
																					  <option value="<?php echo $dis['ac'];?> " selected>
													  
																						<?php echo $dis['first_name'].'-'.$dis['last_name'];?>
																							
																					</option>
																					
																		<?php 
																		}
																	}
																}
															}
														}else{ 
															$query22="SELECT * FROM customers";
																$results22=$db->select($query22); 
																	if ($results22){
																			while($dis22=$results22->fetch_assoc()){?>
																			  <option value="<?php echo $dis22['ac'];?> ">
											  
																				<?php echo $dis22['first_name'].'-'.$dis22['last_name'].'-'.$dis22['Address'];?>
																					
																			</option> 
																<?php 
																}
															}
														}
														?>  
													  
													</select>									
													</div> 
												</div> 
											</div> 
											<div class="form-group">
											  <label>Select Product.</label>
											  <div class="select2-purple">
											 
												<select class="select2" name="product_id" multiple="multiple" 
												data-placeholder="Type Product Code" onchange="GetProductCode(this.value)" data-dropdown-css-class="select2-purple" style="width: 100%;" >
												  
												  <?php		
												  //product stock table  to get only opening product list 
													$query1="SELECT DISTINCT product_code FROM stock_product";
													$results1=$db->select($query1); 
													if ($results1){ 
														while($product1=$results1->fetch_assoc()){  
															$prcode = $product1['product_code'];  
															$stock_quantity = $product1['stock_quantity'];  														
															//product  table 
															$query="SELECT * FROM product_table where product_code='$prcode'";
															$results=$db->select($query); 
															if ($results){ 
															while($product=$results->fetch_assoc()){  
															?>
															  <option value="<?php echo $product['product_code'];?> " > 
																<?php echo $product['product_code'].'-'.$product['product_name'].'-'.$stock_quantity;?> 
															  </option>
												  
												<?php }}}} ?>
												 
												  
												  
												</select>
											  </div>
											</div>
											 <div class="col-12 col-sm-12">
												<div class="form-group">
												  <label>Select Catagory.</label>
												  <div class="select2-purple">
													<select class="select2" name="cat_id" id="cat_id" multiple="multiple" 
													data-placeholder="Type Catagory Name" data-dropdown-css-class="select2-purple" style="width: 100%;" >
													  
													  <?php		
														$query="SELECT * FROM product_catagory";
														$results=$db->select($query);
														$id=0; 
														if ($results){	
														?>
														
														<?php
														while($cat=$results->fetch_assoc()){
														$id++; 
														
														?>
													  <option value="<?php echo $cat['id'];?> " >
													  
													<?php echo $cat['name'];?>
													  
													  </option>
														<?php } ?>
														<?php } ?>
													  
													  
													</select>
													
												  </div>
												</div>
												<!-- /.form-group -->
											</div> 
											 <div class="col-12 col-sm-12">
												<div class="form-group">
												  <label>Sub Catagory.</label>
												  <div class="select2-purple">
													<select class="select2" name="sub_cat" id="sub_cat" multiple="multiple" 
													data-placeholder="Type Sub Catagory" data-dropdown-css-class="select2-purple" 
													style="width: 100%;">
													  												  
													</select>
													
												  </div>
												</div>
												<!-- /.form-group -->
											</div>
											<div class="col-12 col-sm-12">
												<div class="form-group">
												  <label>location</label>
												   <div class="select2-purple">
													<select class="select2" name="location" id="location" multiple="multiple" 
													data-placeholder="Type location Name" data-dropdown-css-class="select2-purple" style="width: 100%;" >
													   
													  
													  
													</select>
												  </div>
												</div>
												<!-- /.form-group -->						
											</div>
                                            <div class="row">							
                                                <div class="col-6 col-md-6 col-xs-6">
                                                    <label>Quantity:</label>
                                                    <input type="number" name="qty" class="form-control" placeholder="Quantity" id="email" >
                                                </div>  
                                             
                                                <div class="col-6 col-md-6 col-xs-6">
                                                <label>Price:</label>
                                                <input type="text" name="sell_price" class="form-control" value="0" Price" id="email" >
                                                </div>
                                            </div>   
												<input type="submit" name="addProdduct" class="btn btn_color" style="background:#1175B9; 
												color:#fff; margin-top:10px;" value="Add Product" />
													
												</div>		
											</div>
											

											<div class="col-md-8">
												<div style="background:#eee;box-shadow: 0px 2px 2px 0px;  border-radius:5px; padding:10px; position:relative;">
													<h4>  Selected Product List</h4> 
													
													<table class="table table-bordered " id="invoiceTable">
														<thead>
															<tr style="background:#1175B9; color:#fff">										
															<th width="5%">S.L</th>
                                                            <th width="32%">Item</th>
                                                            <th width="15%">Qty</th>
                                                            <th width="15%">Price</th>			
                                                            <th width="15%">Total </th>													
                                                            <th width="15%">Action</th>
															</tr>
														</thead>
														<tbody>	
                                                        <?php		
												$queryte="SELECT * FROM temp_sales_register2";
												$resultste=$db->select($queryte);
												$id=0; 
												if ($resultste){	
													while($temres=$resultste->fetch_assoc()){
														$id++; 
												?>
												
												
												<tr class="bg-warning">		
													<td> <?php echo $id;?>  </td> 
													<td><?php 
													
													$pro_id=$temres['product_code'];
													$queryte1="SELECT * FROM product_table WHERE product_code='$pro_id'";
													$resultste1=$db->select($queryte1); 
													if ($resultste1){	
														while($proname=$resultste1->fetch_assoc()){
															$product=$proname['product_name'];
															echo $product;
														}
													}
													
													?>
													<input type="hidden" name="product_name[]" value="<?php 
													
													$pro_id=$temres['product_id'];
													$queryte1="SELECT * FROM product_table WHERE product_code='$pro_id'";
													$resultste1=$db->select($queryte1); 
													if ($resultste1){	
														while($proname=$resultste1->fetch_assoc()){
															$product=$proname['product_name'];
															echo $product;
														}
													}
													
													?>"/>
													</td>
													<td> <?php echo $temres['qty'];?>	</td>
													<td> <?php echo number_format((float)$temres['price'], 2, '.', ','); ?></td> 
													<td> <?php echo number_format((float)$temres['total'], 2, '.', ','); ?>	</td>
												
													<td>	
													<?php 
														$delqty=$_GET['qtydel']; 
														
														if ($delqty==true) {
															$delqtyq="DELETE FROM temp_sales_register2 where id=$delqty";
															$resqtyd=$db->delete($delqtyq);
															if($resqtyd==true){
																echo "<script type='text/javascript'>window.location='sales_index_register.php'; </script>"; 
															}
															
														}
													?>													
														<a href="sales_index_register.php?qtydel='<?php echo $temres['id'];?>'" > 
														<i class="fa fas fa-trash" style="color:red;"></i></a>
													</td>										
													
												</tr>
												
												<?php } } ?>
												<tr>
													<td colspan="4">Labour/Others Bill </td> 
													<td><input type="text" name="labor_bill" class="form-control input-sm" value="0"/></td> 
												</tr>
											</tbody>
											
											<tfoot style="background:#1175B9; color:#fff">
											 <?php		
												$totalquery="select SUM(price) as sprice, 
												SUM(total) as ptotal FROM temp_sales_register2";
												$totalRes=$db->select($totalquery);						
												if ($totalRes){	
													while($qtytotal=$totalRes->fetch_assoc()){	 
														$ptotal		=$qtytotal['ptotal'];
														
												?>
												<tr>
													 
													<td colspan="4" class="text-right">Total=</td>
												 
													
													<td id="totalColumn"> 
													<?php echo number_format((float)$ptotal, 2, '.', ',');?>
													<input type="hidden" name="purchase_total" class="form-control" value="<?php echo $ptotal ?>"/>
													</td>
													<td> </td>
													
												</tr>
												<?php }} ?> 
											</tfoot>
											
											<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
											<script>
											$(document).ready(function(){
												// Function to update total when labor_bill changes
												function updateTotal() {
													var laborBillValue = parseFloat($('[name="labor_bill"]').val()) || 0;
													var qtyTotal = parseFloat('<?php echo $ptotal; ?>') || 0;
													var newTotal = laborBillValue + qtyTotal;
													
													$('[name="sales_total"]').val(newTotal.toFixed(2));
													$('#totalColumn').text(newTotal.toFixed(2)); // Update the displayed value
													
													
												}

												// Call the function on page load
												updateTotal();

												// Attach an event listener to the labor_bill input
												$('[name="labor_bill"]').on('input', function(){
													updateTotal();
												});
											});
											</script>
									</table>									
													<div style="background:#F7F8F8; box-shadow: 0px 2px 2px 0px; 
													text-align:left; min-height:100px; position:absolute; padding: 20px; width:100%; margin-left:-10px; margin-bottom:100px;" >
													
                                                    <div class="form-group " style=" text-align:left; float:left">
                                                        <label> Narration: </label> <br>
                                                        <textarea placeholder="Write your narration" name="narration" rows="4" cols="50" class="form-control" > </textarea>
                                                    </div>
                                                    <div style="float:right">  
                                                        <div class="form-group">
                                                            <label> Payment Status</label>
                                                            <select name="payment_status" class="form-select form-control " style="width:150px; margin-right:20px;">
																<option value="1">Paid</option>
																<option value="2">Unpaid</option> 
                                                            </select>
                                                        </div>
                                                    </div> 
														<input type="submit" name="submit" class="btn btn_custom"  value="submit" />
													 </div>	
													</form>										
												</div>									
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function GetProductCode(str) { 
	  var xhttp = new XMLHttpRequest();
	  var xhttp1 = new XMLHttpRequest();
	  
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {		
		 document.getElementById("cat_id").innerHTML = this.responseText;
		  getSubcategories(str);
		  getLocation(str);
		}
	  }; 
	  xhttp.open("GET", "get_cat.php?product_code="+str, true);
	  xhttp.send();	 
	 
	}  
	
	 // Function to fetch and display subcategories
    function getSubcategories(productCode) {
        var xhttp1 = new XMLHttpRequest();

        xhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("sub_cat").innerHTML = this.responseText;
            }
        }; 

        xhttp1.open("GET", "get_subcat.php?product_code="+productCode, true);
        xhttp1.send(); 
    }
	// Function to fetch and display subcategories
    function getLocation(productCode) {
        var xhttp1 = new XMLHttpRequest();

        xhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("location").innerHTML = this.responseText;
            }
        }; 

        xhttp1.open("GET", "get_location.php?product_code="+productCode, true);
        xhttp1.send(); 
    }
</script>



<?php include('inc/footer.php'); ?>
