<?php 
include('inc/sales_index_header.php');
error_reporting(0);
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
                        <h5>Daily Sheet </h5>
                    </div>
					
				
                    <div class='card-body' style="min-height:600px;">
                        
                    <div class="row align-items-start" >  
						<div class="col-md-12">
							<table id="# example" class=" table-striped table-bordered" style="width:100%; border: 2px;">
                            <thead>
									<tr class="text-white bg-info">
                                        <th>Entry Date</th>	
                                        <th>Sheet Date</th>	
                                        <th>Client Name</th>
										 <th>Narration</th>
                                        <th>Debit/Recive </th>
                                        <th>Credit/Payment</th>
                                        <th>Balance</th> 
									</tr>
								</thead>
								<tbody>
								
								
								<tr class=" bg-warning" style="text-align:right; 
									font-weight:bold; ">
								 
									<td colspan="6">Opening Balance=</td> 
									  
									<td>
									<?php
										$dateSelect = $db->select("SELECT * FROM date_entry ORDER BY id DESC LIMIT 1")->fetch_assoc()['Date']; 

										$Opquery = "SELECT CONCAT(SUM(recive_amount - expense_amount)) AS opbalance
													FROM daily_transection 
													WHERE date BETWEEN '2000-01-01' AND DATE_SUB('$dateSelect', INTERVAL 1 DAY)
													AND Directsales != 1 and op_id !=1";

										$getOp = $db->select($Opquery);  

										if ($getOp) {
											while ($oprs = $getOp->fetch_assoc()) {
												$balance = $oprs['opbalance'];
												$formattedBalance = number_format($balance, 2); // Adjust the decimal places as needed

												echo $formattedBalance ? $formattedBalance : '0';
											}
										}
										?>  
									</td> 
								</tr>
                                 
								    <?php										
									$dateSelect = $db->select("SELECT * FROM date_entry ORDER BY id DESC LIMIT 1")->fetch_assoc()['Date']; 
									
									$query="SELECT * FROM daily_transection where date='$dateSelect' order by id ASC"; 
									
									$results=$db->select($query);
									$id=0; 
									if ($results){	
									?>
									<?php
									while($rs=$results->fetch_assoc()){
									$id++; 						
									?> 
									
									<tr >
											<td style="width:100px; padding:2px;"><?php echo $rs['date'];?> </td> 											
											<td  style="width:100px; padding:2px;"><?php echo $rs['daily_sheet_date'];?> </td> 											
											<td> 
											<?php  
											$ledger_id=$rs['lederid'];
											$Party = $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['first_name'] . ' ' . $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['last_name'];

											echo $Party; 
											
											?> 
											
											
											
											</td> 
											<td><?php echo $rs['narration'];?> </td> 
											<td style="text-align:right; padding:5px;"><?php echo number_format($rs['recive_amount'],2);?> </td> 
											<td style="text-align:right; padding:5px;"><?php echo number_format($rs['expense_amount'],2);?> </td> 
											<td style="text-align:right; padding:5px; font-weight:bold; ">
											 <?php
												$Directsales = $rs['Directsales'];
												$debit = $rs['recive_amount'];
												$credit = $rs['expense_amount'];

												 if ($Directsales == 1) {
													// If Directsales is 1, show 0 in the balance column
													echo 0;
												} else {
													$balance +=$debit - $credit;
													echo number_format($balance,2);
												}
												
												// Save the balance for each row in the $balances array
												$balances[] = $balance;
												?> 
											</td>  
											 
										</tr>	
									<?php }}else{?>
									 
								
							 
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p> 
									</div> 
									<?php }?>
								</tbody>
								<tfoot class="bg-light"> 
								<tr class=" bg-warning" style="text-align:right; font-weight:bold; ">
									
									<td colspan="6">Closing Balance=</td> 
									<td><?php 
										// Display closing balance (last element of $balances array)
										if (!empty($balances)) {
											$closingBalance = end($balances);
											echo number_format($closingBalance,2);
										} 
										?>
									</td> 
									   
									 
								</tr>
								</tfoot>
                            </table>
							
						</div>
 
                    </div>
                </div>
            </div>
        </div>
		
    </div>
</div>

 
 


<?php 
include('inc/footer.php'); 
?>
