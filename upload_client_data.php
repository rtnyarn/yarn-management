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
                        <h5>Upload Party information</h5>
                    </div>
					 <?php 
				if(isset($_POST['submit'])){ 
				
					$filename	=$_FILES["file"]["tmp_name"];  
					if($_FILES["file"]["size"]> 0){
						$file= fopen($filename,"r");
						
						while(($column=fgetcsv($file, 10000, ",")) !== FALSE){
							
							  $query ="INSERT INTO `daily_transection`(`lederid`, `narration`, 
							  `recive_amount`, `expense_amount`, `date`, `op_balance`) values 
										('".$column[0]."','".$column[1]."','".$column[2]."','".$column[3]."',
										'".$column[4]."','".$column[5]."')"; 
								$results=$db->insert($query);	
							}  
							if ($results==true) {
								?>
								
								<div class="form-group col-md-12">  			
									<div class="row ">
									<div style="width:650px; margin:0px auto; background:#eee; border:
										3px solid #ff8800; border-radius:5px; margin-top:20px; padding:20px; ">
												<div class="bg-success" style="padding:20px; border-radius:5px;">
													<h5 class="text-white">Succesfully Upload Party information </h5>
												</div>
											</div>	
										</div>
									</div>
								
							 <?php 
							 }else {
								  echo"Failure"; 
							 }										
						}
					}
				?>
				<?php 
				if(isset($_POST['client'])){ 
				
					$filename	=$_FILES["file"]["tmp_name"];  
					if($_FILES["file"]["size"]> 0){
						$file= fopen($filename,"r");
						
						while(($column=fgetcsv($file, 10000, ",")) !== FALSE){
							
							  $query ="INSERT INTO `customers`(`ac_type`, `ac`, `first_name`, `last_name`,`Address`,`membership_date`, `status`) values 
										('".$column[0]."','".$column[1]."','".$column[2]."','".$column[3]."',
										'".$column[4]."','".$column[5]."','".$column[6]."')"; 
								$results=$db->insert($query);	
							}  
							
							
							if ($results==true) {
								?>
								
								<div class="form-group col-md-12">  			
									<div class="row ">
									<div style="width:650px; margin:0px auto; background:#eee; border:
										3px solid #ff8800; border-radius:5px; margin-top:20px; padding:20px; ">
												<div class="bg-success" style="padding:20px; border-radius:5px;">
													<h5 class="text-white">Succesfully Upload Party information </h5>
												</div>
											</div>	
										</div>
									</div>
								
							 <?php 
							 }else {
								  echo"Failure"; 
							 }										
						}
					}
				?>
                    <div class='card-body' style="min-height:600px; border: 2px #eeee; margin:0px auto;"> 
						<div class="row align-items-start" > 
							<div class="col-md-8">
								<div style="border: 2px solid #eee; padding: 10px; width:600px;">  
									<h4> Please Select Excel CSV delegete File </h4>
									<form action="" method="post" enctype="multipart/form-data"> 
										<div class="row align-items-center g-2">  
											<div class="input-group input-group-sm mb-3">   
												<input type="file" name="file" class="form-control" name="from" required>   
											</div>  
											<div class="col-auto">
												<button type="submit" name="submit" class="btn btn-primary main_btn"> Upload Daily Sheet Table  </button> 
												<button type="submit" name="client" class="btn btn-primary main_btn"> Upload Client Table  </button> 
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
