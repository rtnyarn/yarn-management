<?php include('inc/sales_index_header.php'); ?>
<?php

$value2 = '';

// Query to fetch the last inserted invoice number
$query = "SELECT invoice_no FROM sales_invoice ORDER BY invoice_no DESC LIMIT 1";
$stmt = $db->select($query);

// Check if the query execution was successful
if ($stmt !== false) {
    // Check if rows were returned
    if (mysqli_num_rows($stmt) > 0) {
        $row = mysqli_fetch_assoc($stmt);
        $value2 = $row['invoice_no'];

        // Check if the value is not NULL
        if ($value2 !== null) {
			$numeric_part = (int) preg_replace('/[^0-9]/', '', $value2);  
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
					<h6 class="text-left">  Sales Panel || Sales Register || Sale ID:-<?php  
					echo $Inv; 
					?><h6>							 
                    </div>
                    <div class='card-body' style="min-height:600px;">
               
										<?php 
										if(isset($_POST["addProdduct"])) {
											$invoice_no			=$_POST["invoice_no"];
											$cus_code 			=$_POST["cus_code"];							
											$product_id 		=$_POST["product_id"];
											$qty	  			=$_POST["qty"];
											$price  			=$_POST["price"];	
											$stock  			=$_POST["stock"]; 
											
											$total				=$qty*$price;								
											$grand_total		=$total -($total*($discount/100));
											
											//total Price sum with discount for discount amount 
											$discount1		 	=$total+($total*($discount/100));
											$discount_amount	=$discount1-$total; 
											
											$total=$qty*$price;
											
											$querystock="SELECT * FROM stock_product where product_code='$product_id' ";
											$resultsstock=$db->select($querystock);															
											if ($resultsstock){
												while($stcok=$resultsstock->fetch_assoc()){
													$stock	=$stcok['stock_quantity'];
													$sale_price	=$stcok['price'];
													if ($stock>$qty){
														$invq="INSERT INTO `temp_sales_register2`
														(`sales_invoice`, `suppliar_id`, `product_code`, `cat_id`, `sub_cat`, `location`, `qty`, `price`, `total`) 
															VALUES ('$Inv','$cus_code','$product_id','$qty', '$price', '$grand_total')";
															$db->insert($invq);
													}else{
														echo "<script type='text/javascript'>alert('Product Not Available')</script>";  
													}
												}
											}
											
										}
										//End temp_sales_table
										if (isset($_POST["submit"])){  
										
											$cus_code 			=$_POST["cus_code"];
											$date  				=$_POST["date"]; 
											$payment_status		=$_POST["payment_status"];
											$note				=$_POST["narration"];
											$labor_bill			=$_POST["labor_bill"];
											
											$invsubtqy="select SUM(total) as total_amount FROM temp_sales_register where invoice_id='$Inv'";
											$totalRes=$db->select($invsubtqy);						
											if ($totalRes){	
												while($invqtytotal=$totalRes->fetch_assoc()){				
													$grand_total1=$invqtytotal['total_amount'];
													$grand_total2=$grand_total1+$labor_bill; 
													
													$query1="INSERT INTO `sales_invoice`(
													`invoice_no`, `customer_id`, `sales_total`, `narration`, `payment_status`, `date`, `updated`, `saller_id`) 
													values('$Inv','$cus_code','$grand_total2', '$note','$payment_status','$date','0000-00-00','00')";
													
													
													$results=$db->insert($query1);  
													 
													//select product from temp_sales_register 
													$product_query="SELECT * FROM temp_sales_register where invoice_id='$value'";
													$pro_r=$db->select($product_query);
													$id=0; 
													if ($pro_r==true){	
														while($pro_res=$pro_r->fetch_assoc()){
															$id++; 
															
															$invoice_id		=$pro_res['invoice_id'];											
															$product_code	=$pro_res['product_code'];
															$quantity		=$pro_res['quantity'];		
															$unite_price	=$pro_res['unite_price'];											
															$discount		=$pro_res['discount'];											
														
															$product_transection="INSERT INTO `product_transection2`(`invoice_no`, `product_code`, `catogry_id`, 
															`sub_cat_id`, `location`, `quntity`, `purches_price`, `sale_price`, `saler_id`, `status_id`, `trans_type`,
															`create_date`, `update_date`) VALUES 
															('$value','$product_code', '$cat_id',
															'$sub_cat','$location','$qty', '$purchase_price', '$selling_price', 
															'0','Purchase','$date','0000-00-00')"; 
															$results=$db->insert($product_transection);  
																		/*
															$invq="INSERT INTO `daily_transection2`(`lederid`, `narration`, `recive_amount`, `expense_amount`, `date`, `Directsales`, 
															`daily_sheet_date`, `create_at`, `op_balance`, `op_id`) 
															VALUES ('$invoice_id','Sales','$product_code','$quantity','$unite_price','0', '$discount')";
															$db->insert($invq);*/
															
															/*//update product stock
															$lstpro=$db->select("SELECT `stock_quantity` FROM `stock_product` WHERE `product_code`='$product_code'");
															$lastdata=$lstpro->fetch_assoc()["stock_quantity"];
															$newqty=$lastdata-$quantity;
															$db->update("UPDATE `stock_product` SET `stock_quantity`='$newqty' WHERE `product_code`='$product_code'");*/
														}
														/*//Delete temporary Table Data 
														$deltemqery="DELETE FROM temp_sales_register where invoice_id=$value";
														$delq=$db->delete($deltemqery);*/
														
													} 
													
														if ($results==true){?>   
														<script> alert("Product Sales Succesfully completed.") </script> 
													<?php 
													} 
												} 
											}  
										} 
										
										?>
										<div class="row">
											<div class="col-md-4 ">
												<div style="background:#ffff; border-radius:5px; padding:10px;">
													<h4 class="bg_main" style="padding:5px; border-radius:5px;"> Add Product</h4> 
														
														<form action="" method ="post" enctype="">
															<div class="form-group">
																<div id="filterDate2">
																	<!-- Datepicker as text field -->   
																	<div class="input-group input-group-sm mb-3">
										 
																		<?php
																			$date = ($result = $db->select("SELECT Date FROM date_entry ORDER BY id DESC LIMIT 1"))->num_rows > 0 ?
																			$result->fetch_assoc()['Date'] : null;
																		?>
																		<span class="input-group-text" id="inputGroup-sizing-sm">Entry Date</span>
																		<input type="text" class="form-control" name="date" value="<?php echo $date ?>">
																		<span class="input-group-text" id="inputGroup-sizing-sm">Sheet Date</span>
																		<?php
																			$dailydate = ($result = $db->select("SELECT daily_sheet_date FROM date_entry ORDER BY id DESC LIMIT 1"))->num_rows > 0 ?
																			$result->fetch_assoc()['daily_sheet_date'] : null;
																		?>
																		<input type="text" class="form-control" name="dailydate" value="<?php echo $dailydate ?>">
																	
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
															<label style="font-weight:bold;">Customer Name</label> 
													
														<div class="select2-purple">

															<select class="select2 form-control" name="cus_code" multiple="multiple" 
															data-placeholder="Type Customer A/C" data-dropdown-css-class="select2-purple"required>
															
															<?php		
																$queryin="SELECT * FROM temp_sales_register order by id DESC limit 1";
																$results1=$db->select($queryin); 
																if ($results1==true){ 
																while($tem_res=$results1->fetch_assoc()){														
																	$cus_code=$tem_res['customer_code'];
																	
																		if($cus_code==true){
																				$query="SELECT * FROM customers where ac='$cus_code'";
																				$results=$db->select($query); 
																					if ($results){
																							while($dis=$results->fetch_assoc()){?>
																							<option value="<?php echo $dis['ac'];?> " selected>
															
																								<?php echo $dis['ac'].' '.$dis['first_name'].' '.$dis['last_name'];?>
																									
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
													
																						<?php echo $dis22['ac'].' '.$dis22['first_name'].' '.$dis22['last_name'];?>
																							
																					</option> 
																		<?php 
																		}
																	}
																}
																?>  
															
															</select>									
															</div> 
														</div> 
														<?php		
															$query="SELECT * FROM product_table";
															$results=$db->select($query);
															$id=0; 
															if ($results){ 
															$oppro="";
																while($dis=$results->fetch_assoc()){
																$id++;  
																$prcode=$dis['product_code']; 
																	$querystock="SELECT * FROM stock_product where product_code=$prcode";
																	$resultsstock=$db->select($querystock);															
																	if ($resultsstock){
																	
																		while($stcok=$resultsstock->fetch_assoc()){
																			$stockproduct=$stcok['stock_quantity'];
																			if($stockproduct){
																			$oppro.="<option value='".$dis['product_code']."'>".
																			$dis['product_code'].'-'.$dis['product_name'].'-Stock-'.$stcok['stock_quantity']."</option>";
																			}
																		}
																	}
																}
															}
															?>	
														
														<div class="form-group">	
															<label style="font-weight:bold;">Product Code</label>												
															<select class="select2 form-control" name="product_id" multiple="multiple" 
															data-placeholder="Type Product Code" onchange="getprice(this.value)" data-dropdown-css-class="select2-purple"> 
																<?php echo $oppro; ?> 																
															</select>
														</div> 
													
														<div class="form-group">
															<label style="font-weight:bold;">Quantity</label>
															<input type="number" name="qty" class="form-control" placeholder="Quantity" id="email" > 
														</div> 
														<div class="form-group">
														<label style="font-weight:bold;">Unite Price</label>
														<input type="number" name="price" class="form-control" placeholder="Enter Price" id="price" > 
														</div>
														
														<div class="form-group">
															<label style="font-weight:bold;">Discount (%)</label>
															<input type="number" name="discount" class="form-control" value="0"placeholder="Discount" id="email" > 
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
																<th width="15%">Qty(Bales/Bag)</th>								
																<th width="15%">Price</th> 
																<th width="15%">Total</th>
																<th width="15%">Action</th>
															</tr>
														</thead>
														<tbody>	
															<?php		
															$queryte="SELECT * FROM temp_sales_register";
															$resultste=$db->select($queryte);
															$id=0; 
															if ($resultste){	
																while($temres=$resultste->fetch_assoc()){
																	$id++; 
															?>
															
															
															<tr style="background:#71B0D3; color:#fff">		
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
																<td> <?php echo $temres['quantity'];?>	</td>
																<td> <?php echo number_format((float)$temres['unite_price'], 2, '.', ','); ?></td>
																<td>
																	<?php 
																			echo number_format((float)$temres['total'], 2, '.', ',');													
																	?> 
																</td>
																<td>
																<?php 
																	$delqty=$_GET['qtydel']; 
																	
																	if ($delqty==true) {
																		$delqtyq="DELETE FROM temp_sales_register where id=$delqty";
																		$resqtyd=$db->delete($delqtyq);
																		if($resqtyd==true){
																			echo "<script type='text/javascript'>window.location='sales_index_register.php'; </script>"; 
																		}
																		
																	}
																?>
																	<a href="sales_index_register.php?qtydel='<?php echo $temres['id'];?>'" style="text-decoration:none; font-size:16px;"> 
																	<i class="fa fa-trash" style="background:none; font-size:30px; color:#fff;"></i></a>
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
															$totalquery="select SUM(total) as qtytotal
															FROM temp_sales_register";
															$totalRes=$db->select($totalquery);						
															if ($totalRes){	
																while($qtytotal=$totalRes->fetch_assoc()){				
																	$qtytotalshow=$qtytotal['qtytotal'];
																	
															?>
															<tr>
																<td class="text-right" colspan="4">Total=</td>
																<td id="totalColumn"> 
																<input type="hidden" name="sales_total" class="form-control" value="<?php echo $qtytotalshow; ?>" />
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
																var qtyTotal = parseFloat('<?php echo $qtytotalshow; ?>') || 0;
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
													text-align:left; min-height:100px; position:absolute; padding: 20px; width:100%; margin-left:-10px;" >
													
														<div class="form-group " style=" text-align:left; float:left">
															<label > Narration: </label> <br>
															<textarea placeholder="Write your narration" name="narration" rows="4" cols="50" class="form-control" > </textarea>
														</div>
														<div style="float:right"> 
															<div class="form-group">
																<label > Payment Status</label>
																<select name="payment_status" class="form-select form-control " style="width:150px; margin-right:20px;">
																<option value="Paid">Paid</option> 
																<option value="Unpaid">Unpaid</option> 
																</select>
															</div>
														</div> 
														<input type="submit" name="submit" class="btn "style="background:#1175B9; color:#fff; margin-top:150px; margin-left:-430px;"  value="submit" />
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
function getprice(str) { 
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById("price").innerHTML = this.responseText;
	}
	};
	xhttp.open("GET", "get_product_price.php?id="+str, true);
	xhttp.open("GET", "get_product_stock.php?id="+str, true);
	xhttp.send();
	} 
</script>
<?php include('inc/footer.php'); ?>
