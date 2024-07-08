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
					    <h6 class="text-left"> Purchase History<h6>							 
                    </div>
                    
             
                    <div class='card-body' style="min-height:600px;">
                        <div class="row"> 
                            <div class="col-md-12">
                            <table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="bg-light">
									    <th>Invoice No</th>
										<th>Purches Date</th>
										<th>Suppliar Name</th>																		
										<th>Sub-Total</th> 									
										<th>Discount</th> 
										<th>Grand Total</th> 										
										<th>Action</th> 
									</tr>
								</thead>
								<tbody>
								<?php
											$query="SELECT * FROM purchase_invoice order by id DESC";
											$results=$db->select($query);
											$id=0; 
											if($results==true){
												while($rs=$results->fetch_assoc()){
												$id++; 
												$suppliar_id=$rs['suppliar_id'];
										?> 							
									 <tr class="unread">								
										<td><?php echo 'PINV-'.' '.$rs['invoice_no']; ?></td>
										<td><?php echo $rs['date']; ?></td>																	
										<td>
										<?php 
										$query2="SELECT * from customers where ac='$suppliar_id'"; 
										$results2=$db->select($query2);
										
										if($results2){
											while($rs2=$results2->fetch_assoc()){
												$name=$rs2['first_name'].' '.$name=$rs2['last_name']; 
												echo $name;
											}
										}

										?>
										</td>																	
										<td>
										<?php echo $rs['purchase_subtotal']; ?>
										</td>
										<td>
										<?php echo $rs['discount_amount']; ?>
										
										</td>
										<td>
										<?php echo $rs['purchase_total']; ?>
										
										</td>										
										<td> 
											<a href="purchase_bill_details.php?inv='<?php echo $rs['invoice_no']; ?>'" class="btn btn-sm btn-success">View</a> 
											<a href="edit_product.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a> 
											<a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
										</td>
										
									</tr> 
									<?php } }?>
								</tbody>
								
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
