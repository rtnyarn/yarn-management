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
                                        <th>A/C</th>								
										<th>Contact Person</th>								
										<th>Company</th>							
										<th>Mobile</th>
										<th>Address</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php		
									$query="SELECT * FROM suppliar where Status=1";
									$results=$db->select($query);
									$id=0; 
									if ($results){	
									?>
									<?php
									while($rs=$results->fetch_assoc()){
									$id++; 						
									?>
									<tr>
										<td><?php echo $rs['Suppliar_ac']; ?></td>							
										<td>
										<?php echo $rs['Contact_person']; ?></td>
										<td><?php echo $rs['Company_name']; ?></td>
										<td><?php echo $rs['Contact_number']; ?></td>
										<td><?php echo $rs['Address']; ?></td>
										<td>
										<?php 
											$status=$rs['Status']; 
											if($status==1) {
												echo"<p style='color:green; font-weight:bold;'>Active</p>"; 
											}else{
												echo "<p style='color:red;font-weight:bold;'>Inactive</p>"; 
											}
											?>  
										</td>
										
										<td>
										<?php 
											if($Status==1){
											
										?> 
										<a href="edit_suppliar.php?id='<?php echo $rs['id']; ?>'" class="btn btn_color">Edit</a>|
										<?php }?>
										<a href="view_suppliar_details.php?id='<?php echo $rs['id']; ?>" class="btn btn-danger">Details</a></td>								
									</tr>	
									
									<?php }?>
									<?php }else{ ?>
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p>
										 
									</div>
									
									<?php } 
									
									
									?>
									
									 
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
