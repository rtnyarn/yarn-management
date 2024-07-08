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
                        <h5>View Traial Balance Reports </h5>
                    </div>
                    <div class='card-body' style="min-height:600px; border: 2px #eeee; margin:0px auto;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-8">
							<div style="border: 2px solid #eee; padding: 10px;">  
									<form action="trial_balance.php" method="post"> 
									 
									<div class="row align-items-center g-2">  
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

 
 


<?php 
include('inc/footer.php'); 
?>
