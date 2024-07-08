<?php 
include('inc/sales_index_header.php');
error_reporting(0);
?>

<?php 
if (isset($_POST['submit'])){
		$Ledger	= $_POST['ledger'];
		$from 	= $_POST['from'];
		$to 	= $_POST['to'];
	} else{
		echo"No Data Found";
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
                        <h5>Daily Sheet </h5>
                    </div>
					
				
                    <div class='card-body' style="min-height:600px;">
                        
                    <div class="row align-items-start" >  
						<div class="col-md-12"> 
							 						
							<table id="# example" class="table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="text-white bg-info">
                                        <th>Entry Date</th>	
                                        <th>Sheet Date</th>	
                                        <th width="250px">Client Name</th>
										<th width="350px">Narration</th>
                                        <th>Debit/Recive </th>
                                        <th>Credit/Payment</th>
                                        <th>Balance</th> 
                                        <th>Go</th> 
									</tr>
								</thead>
								<tbody>
								
								
								<tr class=" bg-warning" style="text-align:right; 
									font-weight:bold; ">
								 
									<td colspan="6">Opening Balance=</td> 
									  
									<td>
									<?php

										$daybookopening=23906996; 
										$previousDay = date('Y-m-d', strtotime($from . ' - 1 day'));

										// Use $previousDay in your query or calculations
										$Opquery = "SELECT CONCAT(SUM(recive_amount-expense_amount)) AS opbalance
													FROM daily_transection 
													WHERE date BETWEEN '2000-01-01' AND '$previousDay' AND Directsales != 1 ";

										$getOp = $db->select($Opquery);  

										if ($getOp) {
											while ($oprs = $getOp->fetch_assoc()) {
												$balance = $oprs['opbalance']+$daybookopening;
												 $formattedBalance = number_format($balance, 2); // Adjust the decimal places as needed

												echo $formattedBalance ? $formattedBalance : '0';
											}
										}
										?>  
									</td> 
								</tr>
                                 
								    <?php									
									
									
									$query="SELECT * FROM daily_transection where date>= '$from' and date<= '$to' and 
									 narration !='Opening Balance' order by id and date ASC";
									
									$results=$db->select($query);
									$id=0; 
									if ($results){	
									?>
									<?php
									while($rs=$results->fetch_assoc()){
									$id++; 						
									?> 
									
									
									<?php 
									//backround mark for direct sales 
									$Directsales = $rs['Directsales'];
									if($Directsales==1){
									?>
									<tr class="bg-warning">
											<td><?php echo $rs['date'];?> </td> 											
											<td><?php echo $rs['daily_sheet_date'];?> </td> 											
											<td style="font-weight:bold;"> 
											<?php  
											$ledger_id=$rs['lederid'];
											$Party = $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['first_name'] . ' ' . $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['last_name'];

											echo $Party; 
											
											?>  
											
											</td> 
											<td><?php echo $rs['narration'];?> </td> 
											<td style="font-weight:bold;"><?php echo number_format($rs['recive_amount'],2);?> </td>
											
											<td style="font-weight:bold;"><?php echo number_format($rs['expense_amount'],2);?> </td> 
											
											<td style="text-align:right; font-weight:bold; ">
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
											<td> 
											<form action="ledger.php" method="post"> 
												<input type="hidden" class="form-control" name="ledger" value="<?php echo $rs['lederid']; ?>">   
												<input type="hidden" class="form-control" name="from" value="2024-01-01">   
												<input type="hidden" class="form-control" name="to" value="<?php echo date('Y-m-d'); ?>"> 
												<button type="submit" name="submit" class="btn btn-info text-white btn-sm main_btn"> Ledger </button>
											</form>
											</td> 
											 
										</tr>

									<?php }else{?> 
									
										<tr >
											<td><?php echo $rs['date'];?> </td> 											
											<td><?php echo $rs['daily_sheet_date'];?> </td> 											
											<td style="font-weight:bold;"> 
											<?php  
											$ledger_id=$rs['lederid'];
											$Party = $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['first_name'] . ' ' . $db->select("SELECT * FROM customers where ac='$ledger_id'")->fetch_assoc()['last_name'];

											echo $Party; 
											
											?>  
											
											</td> 
											<td style="width:400px;"><?php echo $rs['narration'];?> </td> 
											<td style="font-weight:bold;"><?php echo number_format($rs['recive_amount'],2);?> </td>
											
											<td style="font-weight:bold;"><?php echo number_format($rs['expense_amount'],2);?> </td> 
											
											<td style="text-align:right; font-weight:bold; ">
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
											<td> 
												<form action="ledger.php" method="post"> 
													<input type="hidden" class="form-control" name="ledger" value="<?php echo $rs['lederid']; ?>">   
													<input type="hidden" class="form-control" name="from" value="2024-01-01">   
													<input type="hidden" class="form-control" name="to" value="<?php echo date('Y-m-d'); ?>"> 
													<button type="submit" name="submit" class="btn btn-info text-white btn-sm main_btn"> Ledger </button>
												</form>
											</td> 											
											 
										</tr>
									<?php }}}else{?>
									 
								
							 
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p> 
									</div> 
									<?php }?>
								</tbody>
								<tfoot class="bg-light"> 
									<tr class=" bg-info text-white" style="text-align:right; font-weight:bold; "> 
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
							<br>
							<br>
							<br>
							
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
