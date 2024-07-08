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

<?php 
if (isset($_POST['submit'])){	
		$from 	= $_POST['from'];  
	} else{
		echo"No Data Found";
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
                        <h4> Stock Reports</h4>
                    </div>
                    <div class='card-body ' style="min-height:600px; padding-bottom:100px;">
                      <div style="border: 2px solid #eee; padding: 10px;" width="300px;">  
							<form action="" method="post"> 
							<div class="row align-items-center g-2">  
								<div class="input-group input-group-sm mb-3">  
									<span class="input-group-text" id="inputGroup-sizing-sm">Select Date</span>
									<input type="date" class="form-control" name="from" value="<?php echo $from; ?>" required>  
									<button type="submit" name="submit" class="btn btn-primary btn-sm"> View </button>                                                
								</div>   
							</div>
						</form>
						</div>
                    <div class="row align-items-start" > 
						<div class="col-md-12 text-center">
						
							<?php 
							
							if ($from !=null) { 
							
							
							?> 
							<table class=" table-bordered" style="width:100%; font-size: 18px;">
							  
							  
							  
							  
							  
							
								<thead>
							<!-- Test -->
									
								</thead>
								<tbody>
								
								
									<?php
							$queryCat = "SELECT * FROM product_catagory";
							$resultsCat = $db->select($queryCat);

							if ($resultsCat) {
								while ($CatRes = $resultsCat->fetch_assoc()) {
									$CatId = $CatRes['id'];
							?>
									<tr class="bg-success text-white" >
										<td colspan="9" style="font-weight:bold; font-size: 24px">
											<?php echo $CatRes['name'].' Date: '.$from; ?>
										</td>
									</tr>
									<tr class="bg-light" > 
                                        <th width="250px;">Name</th>
                                        <th width="100px;">Godown No</th>
										<th>Opening </th> 
										<th>Import</th>                       
										<th>Sales</th> 
										<th>Closing <br>Stock</th>      										
										<th width="180px;">Availabel Stock<br> Upto: <?php echo date('Y-m-d');?></th>      										
										<th>Total</th>  
										<th>Action </th>   
									</tr>

								<?php
									$query1 = "SELECT DISTINCT sub_cat_id 
											   FROM stock_product 
											   WHERE catogry_id = '$CatId' 
												 AND stock_quantity IS NOT NULL";

									$results1 = $db->select($query1);
									$id=0; 
									if ($results1) {
										while ($subCatRes = $results1->fetch_assoc()) {
											$subCatId = $subCatRes['sub_cat_id'];
											
											// Calculate total stock quantity for sub_cat_id
											$totalStockQuery = "SELECT SUM(stock_quantity) AS total_stock 
																FROM stock_product 
																WHERE catogry_id = '$CatId' 
																  AND sub_cat_id = '$subCatId' 
																  AND stock_quantity IS NOT NULL";

											$totalStockResult = $db->select($totalStockQuery);
											$totalStock = $totalStockResult->fetch_assoc()['total_stock'];

											// Count occurrences of sub_cat_id
											$countQuery = "SELECT COUNT(*) AS count 
														   FROM stock_product 
														   WHERE catogry_id = '$CatId' 
															 AND sub_cat_id = '$subCatId' 
															 AND stock_quantity IS NOT NULL";

											$countResult = $db->select($countQuery);
											$rowCount = $countResult->fetch_assoc()['count'];

											// Fetch and display data for the first row
											$firstRowQuery = "SELECT * 
															  FROM stock_product 
															  WHERE catogry_id = '$CatId' 
																AND sub_cat_id = '$subCatId' 
																AND stock_quantity IS NOT NULL 
															  ORDER BY sub_cat_id DESC, CAST(stock_quantity AS SIGNED)
															  LIMIT 1";

											$firstRowResult = $db->select($firstRowQuery);
											$firstRow = $firstRowResult->fetch_assoc();
								?>
											<tr>
											   
												<td style="text-align:left;">
													<?php
													$product_code = $firstRow['product_code'];
													$product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];
													echo $product_coderes;
													?>
												</td> 
												
												<td><?php
													$location = $firstRow['location'];
													$locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];
													echo $locationres;
												?></td>
												<td>													
													<?php
													$product_code_opening = $firstRow['product_code'];
													$location_opening = $firstRow['location']; 
													$previousDay = date('Y-m-d', strtotime($from . ' - 1 day')); 

													// Opening Quantity Query
													$opquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS op_qty FROM product_transection 
																			WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			AND product_code = '$product_code_opening' 
																			AND location = '$location_opening' 
																			AND trans_type = 'Opening'")->fetch_assoc(); 

													// Purchase Quantity Query
													$imquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS import_qty FROM product_transection 
																			WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			AND product_code = '$product_code_opening' 
																			AND location = '$location_opening' 
																			AND trans_type = 'Purchase'")->fetch_assoc();

													// Sales Quantity Query
													$salquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS sales_qty FROM product_transection 
																			 WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			 AND product_code = '$product_code_opening' 
																			 AND location = '$location_opening' 
																			 AND trans_type = 'Sales'")->fetch_assoc();
																			 
													// Extract values from queries
													$op = $opquery['op_qty'];                      
													$im = $imquery['import_qty'];
													$sal = $salquery['sales_qty']; 

													// Calculate opening balance without using max function
													$prop = max(0, $op + $im - $sal); 
													echo $prop;
													?> 
												</td>
												
													<!-- Import report form product_transection  -->
												<?php
												$product_codeim = $firstRow['product_code'];
												$locationim = $firstRow['location'];
												$importquery = "SELECT SUM(quntity) AS total_import FROM product_transection 
												WHERE product_code = '$product_codeim' and location='$locationim' 
												AND create_date = '$from' AND trans_type='Purchase'"; 
												$importres = $db->select($importquery); 
												if ($importres) {
													while ($imres = $importres->fetch_assoc()) { 
														 $quantity_import=$imres['total_import'];
													
														if($quantity_import !=null){?>
														
															<td class="bg-warning"> <?php echo $quantity_import; ?> </td>
														
														<?php }else{ ?> 
															<td> <?php echo '0'; ?></td>
														<?php 
														}
													 
													}
												} 													 
												
												?>
												
												
												<?php
													$product_codeim = $firstRow['product_code'];
													$locationim = $firstRow['location'];
													$importquery = "SELECT SUM(quntity) AS total_import FROM product_transection 
													WHERE product_code = '$product_codeim' and location='$locationim' 
													AND create_date = '$from' AND trans_type='Sales'"; 
													$importres = $db->select($importquery); 
													if ($importres) {
														while ($imres = $importres->fetch_assoc()) { 
															 $quantity_import=$imres['total_import'];
														
															if($quantity_import !=null){?>
																<td class="bg-success" style="color:#fff; font-weight:bold;"> <?php echo $quantity_import; ?></td> 
															<?php }else{ ?>
																<td> <?php echo '0'; ?></td>
															<?php
															}
														}
													} 													 
													
													?>
												
												
												<td>
												<?php
												$product_code_closing = $firstRow['product_code'];
												$location_closing = $firstRow['location']; 

												// Opening Quantity Query
												$opqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS op_qty FROM product_transection 
																		WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		AND product_code = '$product_code_closing' 
																		AND location = '$location_closing' 
																		AND trans_type = 'Opening'")->fetch_assoc(); 

												// Purchase Quantity Query
												$imqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS import_qty FROM product_transection 
																		WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		AND product_code = '$product_code_closing' 
																		AND location = '$location_closing' 
																		AND trans_type = 'Purchase'")->fetch_assoc();

												// Sales Quantity Query
												$salqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS sales_qty FROM product_transection 
																		 WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		 AND product_code = '$product_code_closing' 
																		 AND location = '$location_closing' 
																		 AND trans_type = 'Sales'")->fetch_assoc();
																		 
												// Extract values from queries
												$opc = $opqueryc['op_qty'];                      
												$imc = $imqueryc['import_qty'];
												$salc = $salqueryc['sales_qty']; 

												// Calculate closing without using max function
												$closing = max(0, $opc + $imc - $salc); 
												echo $closing;
												?>



												</td>
												<td><?php echo $firstRow['stock_quantity'];   ?></td>
												<td class="font-weight-bold" rowspan="<?php echo $rowCount; ?>">
													<?php echo $totalStock; // Display total stock ?>
												</td>
												<td class="font-weight-bold">
													<a href="product_stock_details.php?id='<?php echo $firstRow['product_code']; ?>'" class="btn btn-info btn-sm"> History </a>
												</td>
											</tr>

											<?php
											// Fetch and display data for the remaining rows
											$remainingRowsQuery = "SELECT * 
																   FROM stock_product 
																   WHERE catogry_id = '$CatId' 
																	 AND sub_cat_id = '$subCatId' 
																	 AND stock_quantity IS NOT NULL 
																   ORDER BY sub_cat_id DESC, CAST(stock_quantity AS SIGNED)
																   LIMIT 1, " . ($rowCount - 1);

											$remainingRowsResult = $db->select($remainingRowsQuery);

											while ($rs = $remainingRowsResult->fetch_assoc()) {
												
											?>
												<tr>
													 
													<td style="text-align:left;">
														<?php
														$product_code = $rs['product_code'];
														$product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];
														echo $product_coderes;
														?>
													</td>
													 <td><?php 
													 
													 $location = $rs['location'];
													  $locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];
													echo $locationres;
													 ?></td>
													<td>													
													<?php
													$product_code_opening = $rs['product_code'];
													$location_opening = $rs['location']; 
													$previousDay = date('Y-m-d', strtotime($from . ' - 1 day')); 

													// Opening Quantity Query
													$opquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS op_qty FROM product_transection 
																			WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			AND product_code = '$product_code_opening' 
																			AND location = '$location_opening' 
																			AND trans_type = 'Opening'")->fetch_assoc(); 

													// Purchase Quantity Query
													$imquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS import_qty FROM product_transection 
																			WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			AND product_code = '$product_code_opening' 
																			AND location = '$location_opening' 
																			AND trans_type = 'Purchase'")->fetch_assoc();

													// Sales Quantity Query
													$salquery = $db->select("SELECT COALESCE(SUM(quntity), 0) AS sales_qty FROM product_transection 
																			 WHERE create_date BETWEEN '2000-01-01' AND '$previousDay' 
																			 AND product_code = '$product_code_opening' 
																			 AND location = '$location_opening' 
																			 AND trans_type = 'Sales'")->fetch_assoc();
																			 
													// Extract values from queries
													$op = $opquery['op_qty'];                      
													$im = $imquery['import_qty'];
													$sal = $salquery['sales_qty']; 

													// Calculate opening balance without using max function
													$prop = max(0, $op + $im - $sal); 
													echo $prop;
													?> 

												</td>
													
													<!-- Import report form product_transection  -->
												<?php
												$product_codeim = $rs['product_code'];
												$locationim = $rs['location'];
												$importquery = "SELECT SUM(quntity) AS total_import FROM product_transection 
												WHERE product_code = '$product_codeim' and location='$locationim' 
												AND create_date = '$from' AND trans_type='Purchase'"; 
												$importres = $db->select($importquery); 
												if ($importres) {
													while ($imres = $importres->fetch_assoc()) { 
														 $quantity_import=$imres['total_import'];
													
														if($quantity_import !=null){?>
														
															<td class="bg-warning"> <?php echo $quantity_import; ?> </td>
														
														<?php }else{ ?>
															 <td> <?php echo '0'; ?> </td>
														<?php
														}
													 
													}
												} 													 
												
												?>
												
											 
												<?php
													$product_codeim = $rs['product_code'];
													$locationim = $rs['location'];
													$importquery = "SELECT SUM(quntity) AS total_import FROM product_transection 
													WHERE product_code = '$product_codeim' and location='$locationim' 
													AND create_date = '$from' AND trans_type='Sales'"; 
													$importres = $db->select($importquery); 
													if ($importres) {
														while ($imres = $importres->fetch_assoc()) { 
															 $quantity_import=$imres['total_import'];
														
															if($quantity_import !=null){ ?>
																 <td class="bg-success" style="color:#fff; font-weight:bold;"> <?php echo $quantity_import; ?> </td>
															<?php }else{?>
																 <td> <?php echo '0'; ?> </td>
															<?php
															}
														}
													} 													 
													
													?>
												 
													 <td>
												<?php
												$product_code_closing = $rs['product_code'];
												$location_closing = $rs['location']; 

												// Opening Quantity Query
												$opqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS op_qty FROM product_transection 
																		WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		AND product_code = '$product_code_closing' 
																		AND location = '$location_closing' 
																		AND trans_type = 'Opening'")->fetch_assoc(); 

												// Purchase Quantity Query
												$imqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS import_qty FROM product_transection 
																		WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		AND product_code = '$product_code_closing' 
																		AND location = '$location_closing' 
																		AND trans_type = 'Purchase'")->fetch_assoc();

												// Sales Quantity Query
												$salqueryc = $db->select("SELECT COALESCE(SUM(quntity), 0) AS sales_qty FROM product_transection 
																		 WHERE create_date BETWEEN '2000-01-01' AND '$from' 
																		 AND product_code = '$product_code_closing' 
																		 AND location = '$location_closing' 
																		 AND trans_type = 'Sales'")->fetch_assoc();
																		 
												// Extract values from queries
												$opc = $opqueryc['op_qty'];                      
												$imc = $imqueryc['import_qty'];
												$salc = $salqueryc['sales_qty']; 

												// Calculate closing without using max function
												$closing = max(0, $opc + $imc - $salc); 
												echo $closing;
												?> 
												</td>
													 <td><?php echo $rs['stock_quantity']; ?></td>
													<td class="font-weight-bold">
														<a href="product_stock_details.php?id='<?php echo $rs['product_code']; ?>'" class="btn btn-info btn-sm"> History </a>
													</td>
												</tr>
											<?php
											}
										}
									} else {
											?>
										<div class="bg-danger">
											<p style='text-align:center;'>No Data Found!</p>
										</div>
								<?php
									}
								}
							}
							?>




								</tbody>   
							
							
                            </table>
							<?php } else{ ?> 
								
								<h3> Please Select Date to get data </h3> 
							
							<?php } ?>
							
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

