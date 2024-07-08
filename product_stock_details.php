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
			$product_code = $id;
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
                        <h4> Product History </h4>
                        <h5 class="text-success"> Product Name:  
						<?php  
							$product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];  
							echo $product_coderes;  
						?>  
						</h5>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-12 text-center">
							<table class=" table-striped table-bordered" style="width:100%; font-size: 18px;">
									<thead>
							<!-- Test -->
									<tr class="bg-info text-white">
										<th>S.L No</th> 
                                        <th width="250px;">Name</th>
										<th>Location</th> 
										<th>Date</th> 
                                        <th>Import</th> 
                                        <th>Sales</th>
										<th>Balance </th>  
										<th>Remark</th>  
									</tr>
								</thead>
								<tbody> 	
										<?php 
										$query1 = "SELECT * FROM product_transection WHERE product_code='$product_code'";
										$results1=$db->select($query1);
										$id=0; 
										if ($results1){	
										while($rs=$results1->fetch_assoc()){
										$id++; 	
										?>   
										<tr>
											<td><?php echo $id?> </td>  			
											<td>
											<?php  
											$product_code=$rs['product_code'];
											$product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];  
												echo $product_coderes;  
											?> 
											</td> 
											<td> 
											<?php  
											$location=$rs['location'];
											if(!empty($location)){
											$locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];  
												echo $locationres;  
											}else{
												echo"N/A";
											}
											?>
											</td>
											<td><?php echo $rs['create_date'];?> </td>  
											
											<?php  
												$trans_type = $rs['trans_type']; 
												if ($trans_type == 'Purchase'){ 
											?>
											<td class="bg-warning " style="font-weight:bold;"><?php $qty = $rs['quntity']; echo $qty; ?></td>
											<?php
												} else {
											?>
													<td>0.00</td>
											<?php
												}
											?>
 
											<?php  
												$trans_type = $rs['trans_type']; 
												if ($trans_type == 'Sales'){ 
											?>
											<td class="bg-success text-white" style="font-weight:bold;"><?php $qty = $rs['quntity']; echo $qty; ?></td>
											<?php
												} else {
											?>
													<td>0.00</td>
											<?php
												}
											?>
											
											<td class="" style="font-weight:bold;">
											<?php
											$trans_type = $rs['trans_type'];
											$debit = 0;
											$credit = 0;
											$Opening=0; 

											if ($trans_type == 'Sales') {
												$credit = $rs['quntity'];
											} elseif ($trans_type == 'Purchase') {
												$debit = $rs['quntity'];
											}elseif ($trans_type == 'Opening') {
												$Opening = $rs['quntity'];
											}
											
											$balance += $credit-$debit-$Opening;
											echo number_format($balance, 2);

											// Save the balance for each row in the $balances array
											$balances[] = $balance;
											?>
											</td>
											<td class="" style="font-weight:bold;">
											 <?php  
												$trans_type=$rs['trans_type'];  
												echo $trans_type; 
												?> 
											</td>											
										</tr>	
										<?php }}else{?>
									 
							 
										<div class="bg-danger">
											 <p style='text-align:center;'>No Data Found!</p> 
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
