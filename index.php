<?php 
include('inc/sales_index_header.php'); 
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
                        <h5>Welcome To Yarn & Cotton Management System</h5>
                    </div>
                    <div class='card-body text-center' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
					<div class="col-md-4">
                        <div class="text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/acquisition.png" height="80px" width="80px"><br>
                            <h4> <a href="daily_search.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
							   Daily Sheet</a></h4>  
                        </div>                        
                    </div> 
					<div class="col-md-4">
                        <div class=" text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/budget.png" height="80px" width="80px"><br>
                            <h4> <a href="ledger_search.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';"> 
								Ledger Reports
							</a> </h4>  
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class="text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/acquisition.png" height="80px" width="80px"><br>
                            <h4> <a href="mills_trial_balance.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
							   Mills Reports</a></h4>  
                        </div>                        
                    </div> 
					<div class="col-md-4">
                        <div class="text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/acquisition.png" height="80px" width="80px"><br>
                            <h4> <a href="home_trail_balance.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
							   Trial Balance</a></h4>  
                        </div>                        
                    </div>  
                     
					<div class="col-md-4">
                        <div class=" text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/budget.png" height="80px" width="80px"><br>
                            <h4> <a href="product_stock.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';"> 
								Stock Reports
							</a> </h4>  
                        </div>                        
                    </div>	
					<div class="col-md-4">

                        <div class=" text-center panel_body box-shadow-main-panel-inside main_bg " >
                            <img src="images/sales.png" height="80px" width="80px"><br>
							<h4> 
							
							<a href="bank_trial_balance.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
    
								Banks Reports
							</a>
							</h4>   
                        </div>                        
                    </div> 	
					<div class="col-md-4">
                        <div class=" text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/budget.png" height="80px" width="80px"><br>
                            <h4> <a href="product_sales.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';"> 
								Sales & Purchase Reports
							</a> </h4>  
                        </div>                        
                    </div> 
						
					<!--
					<div class="col-md-4">
                        <div class=" text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/budget.png" height="80px" width="80px"><br>
							
							<h4> <a href="balance_sheet.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
    
								Balance Sheet(Construction) 
							</a> </h4> 
                        </div>                        
                    </div>--> 
					<div class="col-md-4">
                        <div class=" text-center panel_body main_bg box-shadow-main-panel-inside" >
                            <img src="images/db.png" height="80px" width="80px"><br>
                            <h4> <a href="mail-backup.php" style="text-decoration:none; color:#000; padding:5px; background-color:transparent;" 
							   onmouseover="this.style.backgroundColor='#1175B9'; this.style.color='#ffff';" 
							   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';"> 
								Backup DB 
							</a> </h4>  
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
