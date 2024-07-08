<?php include('inc/sales_index_history.php'); ?>
 
<div class='dashboard'>

    <?php  include('inc/sales_side_bar.php'); ?>   

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content' ">
            <div class='container'>
                <div class='card'>
                    <div class='card-header text-center'>
					    <h6 class="text-left">  Sales Panel || Sales Reporets<h6>							 
                    </div>
                    
             
                    <div class='card-body' style="min-height:600px;">
                        <div class="row"> 
                            <div class="col-md-12">
                            <table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="bg-light">
										<th class="text-center">INV. No.</th> 
										<th>INV. Date</th>
										<th>Customers Name</th>						
										<th>Narration</th> 
										<th>Dues Amount</th> 
										<th>Paid Amount</th> 
										<th class="ac_display">Print</th>  
										<th class="ac_display">Sales <br /> Return</th>  
										<th class="ac_display">Action</th>  
									</tr>
								</thead>
								<tbody>
									<?php 
										$query="SELECT * from sales_invoice order by invoice_no DESC"; 
										$results=$db->select($query);
										$id=0;
										if($results){
											while($rs=$results->fetch_assoc()){
											$id++; 	
											$distid=$rs['customer_id'];
										?>
									<tr>
										<td class="text-center">INV-<?php echo $rs['invoice_no']; ?></td>
										
										<td><?php echo $rs['date']; ?></td>
										
										<td><?php 
										$query2="SELECT * from customers where ac='$distid'"; 
										$results2=$db->select($query2);
										
										if($results2){
											while($rs2=$results2->fetch_assoc()){
												$name=$rs2['first_name'].' '.$rs2['last_name']; 
												echo $name;
											}
										}

										?></td>
										<td><?php echo $rs['narration']; ?></td>
										<td><?php echo number_format((float)$rs['amount_due'], 2, '.', ',')?></td>
										<td><?php echo number_format((float)$rs['amount_paid'], 2, '.', ',')?></td>
										<td class="text-center"><a href="print_bill.php?inv='<?php echo $rs['invoice_no']?>'" target="blank" class="btn btn-success btn-sm"> <i class="fas fa-print"></i> </a> </td>
										<td><a href="sales_return.php?id='<?php echo $rs['invoice_no']?>'" class="btn btn-danger btn-sm"> <i class="fas fa-undo-alt"></i> </a> </td>
										<td>
										<a href="sales_edit.php?inv='<?php echo $rs['invoice_no']?>'" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i> </a> 
										<a href="sales_return.php?id='<?php echo $rs['invoice_no']?>'" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> </a> 
										</td>
										 
									</tr>
									<?php 
										}
										}
									?>
								</tbody>
								<tfoot class="bg-light">
									<?php 
										$query="SELECT SUM(amount_due) as due, SUM(amount_paid) as paid from sales_invoice"; 
										$results=$db->select($query);
										$id=0;
										if($results){
											while($rs=$results->fetch_assoc()){
											$id++; 	
											$distid=$rs['customer_id'];
										?>
									
									<tr>
										<td class="text-center"></td>
										<td></td>
										<td></td>
										<td class="text-right">Total=</td>
										<td><?php echo number_format((float)$rs['due'], 2, '.', ',')?> Tk</td>
										<td><?php echo number_format((float)$rs['paid'], 2, '.', ',')?> Tk</td>
										<td> </td>
										 
									</tr>
											<?php 
											}
										}
									?>
								</tfoot>
                            </table>
                 
                            </div> 
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

 
<?php include('inc/footer_sales_history.php'); ?>
