<?php include('inc/sales_index_history.php'); ?>
 
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
					    <h6 class="text-left">  Opening Balance List<h6>							 
                    </div>
                    
             
                    <div class='card-body' style="min-height:600px;">
                        <div class="row"> 
                            <div class="col-md-12">
                            <table id="example" class="table table-hover table-striped" style="width:100%">
                            <thead>
									<tr class="bg-light">
                                        <th>A/C</th>								
                                        <th>Name</th> 
                                        <th>Opening Balance</th>                                        
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php	
								$query1 = "SELECT * FROM daily_transection where narration='Opening Balance'";

								$results1=$db->select($query1);
								if ($results1){ 
								while($rs1=$results1->fetch_assoc()){  
									  
									 
								?>
								<tr>
									<td><?php echo $rs1['lederid']; ?></td>							
									<td>
									<?php 
										$ac=$rs1['lederid'];
									
										$query="SELECT * FROM customers where ac='$ac' and status='1'   ";
										$results=$db->select($query);
										if ($results){
										while($rs=$results->fetch_assoc()){
									
											echo $rs['first_name'].' '.$rs['last_name'].' '.$rs['Address']; 
										
											}
										}

									?>
									</td>
									<td><?php echo $rs1['op_balance']; ?></td>    
									
									<td> 
									<a href="edit_opening.php?id='<?php echo $rs1['id']; ?>'" class="btn btn_color">Edit</a>| 
									</td> 
								</tr>	
								<?php }} ?>
							 
								
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
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>



 
<?php include('inc/footer_sales_history.php'); ?>
