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
                        <h5>Ledger Reports </h5>
                    </div>
					
				
                    <div class='card-body' style="min-height:600px;">
                        
                    <div class="row align-items-start" >  
						<div class="col-md-12">
						
							<table id="# example" class=" table-striped table-bordered" style="width:100%; font-weight:bold; ">
									<?php		
										$query1="SELECT * FROM customers where ac='$Ledger'";
										$results1=$db->select($query1); 
											if ($results1==true){
													while($res1=$results1->fetch_assoc()){  
									?>
									
									
									<tr > 
                                        <td class="text-white bg-info" style="width:100px;">Name:</td>
										<td style="font-weight:bold; color:green;"><?php echo $Ledger.'-'.$res1['first_name'].' '.$res1['last_name'].', '.$res1['Address'];?></td> 
										
										<td class=" text-white bg-info" style="width:100px;">Ledger Type</td>	
                                        <td>
										<?php 
										
										$ledertype= $res1['ac_type'];
										$ledert = $db->select("SELECT * FROM ch_group where id='$ledertype'")->fetch_assoc()['name'];

										echo $ledert;
										 
										
										?>
										
										</td>	
									</tr>
									<tr >
                                        <td class="text-white bg-info">Duration</td>	
                                        <td style="font-weight:bold;"><?php echo $from; ?> To <?php echo $to; ?></td>	
                                      
									</tr>
									<?php }} ?>
							</table>
							<br> 							
							<table id="# example" class="table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="text-white bg-info">
                                        <th width="100px">Entry Date</th>	
                                        <th width="150px">Sheet Date</th>	 
										 <th >Narration</th>
                                        <th width="100px">Debit/Recive </th>
                                        <th width="100px">Credit/Payment</th>
                                        <th width="100px">Balance</th> 
									</tr>
								</thead>
								<tbody>
								
								
								<tr class=" bg-warning" style="text-align:right; 
									font-weight:bold; ">
								 
									<td colspan="5">Opening Balance=</td> 
									  
									<td>
									<?php 
										
										$opentryquery=$db->select("SELECT op_balance FROM daily_transection where lederid='$Ledger' and narration='Opening Balance'"); 
										$op_balance=$opentryquery->fetch_assoc()["op_balance"]; 
										
										$previousDay = date('Y-m-d', strtotime($from . ' - 1 day'));
										// Use $previousDay in your query or calculations
										$Opquery = "SELECT CONCAT(SUM(expense_amount - recive_amount )) AS opbalance
													FROM daily_transection 
													WHERE lederid = '$Ledger'
													AND date BETWEEN '2000-01-01' AND '$previousDay'";

										$getOp = $db->select($Opquery);  

										if ($getOp) {
											while ($oprs = $getOp->fetch_assoc()) { 
												
												$op_balance2 = $oprs['opbalance']; 
												$balance =$op_balance2+$op_balance;
												$formattedBalance = number_format($balance, 2); // Adjust the decimal places as needed
	
												echo $formattedBalance ? $formattedBalance : '0';
											}
										}
										?>  
									</td> 
								</tr>
                                 
								    <?php									
									
									
									$query="SELECT * FROM daily_transection where lederid='$Ledger' and date>= '$from' and date<= '$to' order by date ASC ";
									
									$results=$db->select($query);
									$id=0; 
									if ($results){	
									?>
									<?php
									while($rs=$results->fetch_assoc()){
									$id++; 						
									?> 
									
									<tr >
											<td style="width:100px;"><?php echo $rs['date'];?> </td> 											
											<td style="width:120px;"><?php echo $rs['daily_sheet_date'];?> </td>  
											<td><?php echo $rs['narration'];?> </td> 
											<td><?php echo  number_format($rs['recive_amount'],2);?> </td> 
											<td><?php echo  number_format($rs['expense_amount'],2);?> </td> 
											<td style="text-align:right; font-weight:bold; ">
											 <?php	
												$balances = []; // Initialize the $balances array											 
												$debit = $rs['recive_amount'];
												$credit = $rs['expense_amount'];
												$balance += $credit - $debit;
												echo  number_format($balance,2);
												
												// Save the balance for each row in the $balances array
												$balances[] = $balance;
												// Get the last balance from the $balances array
												$last_balance = end($balances);
												?> 
											</td>  
											 
										</tr>	
									<?php }}else{?>
									 
								
							 
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p> 
									</div> 
									<?php }?>
								</tbody>
								<tfoot class="bg-light" style="font-weight:bold; text-align:right"> 
									<tr>
										<td colspan="3" class="text-right">
										Total=
										</td> 
										<td> 
										<?php 
											$recive=recive($db,$Ledger,$from,$to); 
											echo number_format($recive,2);
										?> 
										</td> 
										<td>
										<?php 
											$payment=payment($db,$Ledger,$from,$to); 
											echo number_format($payment,2);
										?> 
										</td>
										<td>
										<?php 											
											echo number_format($last_balance,2);
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
