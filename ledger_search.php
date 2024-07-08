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
                        <h5>Ledger Reports </h5>
                    </div>
                    <div class='card-body' style="min-height:600px; border: 2px #eeee; margin:0px auto;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-offset-8 col-md-8">
							<div style="border: 2px solid #eee; padding: 10px;"> 							
							 
											<div class="sale_entry_tickets text-left">  
											<form action="ledger.php" method="post"> 
											 
											<div class="row align-items-center g-2">	 		
												
												
												<?php		
													$query="SELECT * FROM customers";
													$results=$db->select($query); 
													$oppro2="";
														if ($results==true){
																while($dis=$results->fetch_assoc()){
																$oppro2.="<option value='".$dis['ac']."'>".$dis['first_name']." ".$dis['last_name'].",".$dis['Address']."</option>";
														}
													}													
												?>
												<div class="input-group input-group-sm mb-3">  
													<select class="select2 form-control" name="ledger" multiple="multiple" 
													data-placeholder="Type Head Name" onchange="getprice(this.value)" data-dropdown-css-class="select2-purple"  > 
														<?php echo $oppro2; ?>
													</select>	
												</div>	
												<div class="input-group input-group-sm mb-3">  
													<span class="input-group-text" id="inputGroup-sizing-sm">Form</span>
													<input type="date" class="form-control" name="from" required>   
												</div> 

												<div class="input-group input-group-sm mb-3">  
													<span class="input-group-text" id="inputGroup-sizing-sm">To</span>
													<input type="date" class="form-control" name="to" required>  
												</div>  												
												
												<div class="col-auto">
													<button type="submit" name="submit" class="btn btn-primary main_btn"> Search </button> 
												</div>
											</div>
										</form>
										
								</div> 
							</div> 
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
