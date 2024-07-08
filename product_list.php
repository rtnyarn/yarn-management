<?php 
include('inc/sales_index_header.php');
error_reporting(E_ALL);
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
                        <h5> All Product List </h5>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" >   
						<div class="col-md-12">
							<table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
							<!-- Test -->
									<tr class="bg-light">
										<th width="30px">S.L No</th>
										<th width="30px">P.Code</th>
                                        <th>Name</th>								
                                        <th>Sub Catagory</th> 
                                        <th>Catagory</th> 
                                        <th width="30px">Status</th>
                                        <th width="30px">Opening <br> Balance</th> 
									</tr>
								</thead>
								<tbody>
                                 
								    <?php		
									 
									$query1="SELECT * FROM product_table where status='1' ORDER BY id DESC";
									$results1=$db->select($query1);
									$id=0; 
									if ($results1){	
									?>
									<?php
									while($rs=$results1->fetch_assoc()){
									$id++; 						
									?> 
										<tr>
											<td><?php echo $rs['id'];?> </td> 
											<td><?php echo $rs['product_code'];?> </td> 
											<td><?php echo $rs['product_name'];?> </td>
											<td>
											<?php  
											$subid=$rs['sub_cat_id'];
											if (isset($subid) && !empty($subid)){
												$scat_name = $db->select("SELECT * FROM sub_catagory where id='$subid'")->fetch_assoc()['sub_cat_name'];  
											
												echo $scat_name; 
											}else{
												echo 'Not Asign'; 
											}
											
											?>
											</td> 
											<td>
											<?php  
											$productid=$rs['product_cat_id'];
											$cat_name = $db->select("SELECT * FROM product_catagory where id='$productid'")->fetch_assoc()['name'];  
											echo $cat_name; 
											
											?> 
											</td>  
											<td class="text-center">   
											<?php
												$product_code1 = $rs['product_code'];

												// Assuming $db->select returns a result set or false
												$result = $db->select("SELECT * FROM stock_product WHERE product_code='$product_code1'");

												if ($result !== false) {
													$row = $result->fetch_assoc();

													if (!empty($row)) {
														echo "Product Open";
													} 
												} else {
														echo "Not Open Yet";
												} 
												?>							
											</td>
											<td class="text-center">   
											 <a href="product_opening.php?id='<?php echo $rs['id']; ?>" 
											 class="btn btn-primary btn-sm">Go</a></td>								
											</td>   
										</tr>	
									<?php }}else{?>
									 
							 
									<div class="bg-danger">
										 <p style='text-align:center;'>No Members Data Found!</p> 
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

 

<?php 
include('inc/footer.php'); 
?>
