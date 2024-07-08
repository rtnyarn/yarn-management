<?php include("inc/sales_index_header.php"); ?> 
		<!-- Main Area -->

		<section class="add_new_member ">
			 <div class="container">
				<div class="row">
					
					<div class="form-group from_border_3">
						<?php													
								
								if (empty($_GET['id'])){
								}elseif(!isset($_GET['id']) || $_GET['id'] == NULL){
									echo 'Something went to wrong';
								}else{
										$tid= $_GET['id'];
										$id= preg_replace("/[^0-9a-zA-Z]/", "", $tid);
										$return_id =$id;	
								}
											
								//invoice table data 						
								$kot				="";
								$invoice_no			="";
								$customer_id		="";
								$sales_total		="";
								/*$invoice_subtotal	="";
								$tax				="";
								$tax_amount			="";*/
								$discount_amount	="";
								$amount_paid 		="";
								$amount_due			="";
								$narration			="";
								$payment_method		="";
								$date				="";
								$updated 			="";
								$saller_id			="";							
								
								$queryinvoice	="SELECT *from sales_invoice where invoice_no='$return_id'";
								$queryinvoiceres=$db->select($queryinvoice);
								
								if($queryinvoiceres==true){
									while($qinvres=$queryinvoiceres->fetch_assoc()){
										
										$kot				=$qinvres['kot'];
										$invoice_no			=$qinvres['invoice_no'];
										$customer_id		=$qinvres['customer_id'];
										$sales_total		=$qinvres['sales_total'];
										/*$invoice_subtotal	=$qinvres['invoice_subtotal'];
										$tax				=$qinvres['tax'];
										$tax_amount			=$qinvres['tax_amount'];*/
										$discount_amount	=$qinvres['discount_amount'];
										$amount_paid 		=$qinvres['amount_paid'];
										$amount_due			=$qinvres['amount_due'];
										$narration			=$qinvres['narration'];
										$payment_method		=$qinvres['payment_method'];
										$date				=$qinvres['date'];
										$updated 			=$qinvres['updated'];
										$saller_id			=$qinvres['saller_id'];															
										}
									}
								
								//End invoice table data 								
																		
								$queryinvoicedetails="SELECT *from sales_details where invoice_id='$return_id'";
								$queryinvoicedetsres=$db->select($queryinvoicedetails);
								if($queryinvoicedetsres==true){
									while($qinvdetres=$queryinvoicedetsres->fetch_assoc()){										
										
										$id				=$qinvdetres['id'];
										$kot			=$qinvdetres['kot'];
										$invoice_id		=$qinvdetres['invoice_id'];
										$product_id		=$qinvdetres['product_id'];									
										$quantity		=$qinvdetres['quantity'];
										$price			=$qinvdetres['price'];
										$discount		=$qinvdetres['discount'];										
										$purchase_price	=$qinvdetres['purchase_price']; 
										$date			=$qinvdetres['date']; 
										
										$query2="INSERT INTO `return_invoice_details`(`return_invoice_id`, `kot`, `invoice_id`, 
										`product_id`, `quantity`, `price`, `discount`, `purchase_price`, `date`)
										values('$id','$kot','$invoice_id','$product_id','$quantity','$price','$discount','$purchase_price','$date')";
										$results2=$db->insert($query2); 
											
										$lstpro=$db->select("SELECT `stock_quantity` FROM `stock_product` WHERE `product_code`='$product_id'");
										$lastdata=$lstpro->fetch_assoc()["stock_quantity"];
										$newqty=$lastdata+$quantity; 										
										$db->update("UPDATE `stock_product` SET `stock_quantity`='$newqty' WHERE `product_code`='$product_id'");
										
										$delquryinvoicedel="DELETE FROM sales_details where invoice_id='$return_id'"; 
										$delres=$db->delete($delquryinvoicedel); 
									}
								
								}			
							
															
								if ($return_id==true){
								//invoice table 
									$query1="INSERT INTO `return_sales_invoice`(`kot`, `invoice_no`, `customer_id`, 
									`sales_total`, `sales_subtotal`, `tax`, `tax_amount`, `discount_amount`, `amount_paid`,
									`amount_due`, `narration`, `payment_method`, `date`, `updated`, `saller_id`)
									values('$kot','$invoice_no','$customer_id','$sales_total','0','0',
									'0','$discount_amount','$amount_paid','$amount_due','$narration','$payment_method','$date','$updated','$saller_id')";
									$results=$db->insert($query1);

									$delquryinvoice="DELETE FROM sales_invoice where invoice_no='$return_id'"; 
									$delres=$db->delete($delquryinvoice);
											
									//invoice detail table
								}else{
									echo "ID Not Valid "; 
								} 
								
							echo "<script> 
							alert('sales Return Successfully Completed');
							window:location ='sales_index_return_history.php';
							</script>";
							echo "<script>  </script>";
								
								
								
						?>

					</div> 
					
			 </div>
		</section>
			<script src="js/get_invoice.js"></script>
		<!-- End Main Area -->
		<script src="js/jquery.min.js"></script> 
	
		<script src="js/auto.js"></script>
		
<?php include("inc/footer.php"); ?> 