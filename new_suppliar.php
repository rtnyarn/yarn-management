<?php 
include('inc/sales_index_header.php'); 
?>

<div class='dashboard'>    
    
    <?php  include('inc/sales_side_bar.php'); ?>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content' ">
            <div class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h5><i class="fa fa-users" style="color:#000;"> </i> Add New Suppliar </h5> 
                    </div>
                    <div class='card-body' style="min-height:600px;"> 


                    <?php 
						if(isset($_POST["submit"])){
							
							$ac					=$fm->validation($_POST['AC']);
							$Company_name		=$fm->validation($_POST['Company_name']);
							$Contact_person		=$fm->validation($_POST['Contact_person']);
							$Contact_number		=$fm->validation($_POST['Contact_number']);							
							$Address			=$fm->validation($_POST['Address']);											
							$status				=$fm->validation($_POST['status']);
							
							$ac					=mysqli_real_escape_string($db->link,$ac);
							$Company_name		=mysqli_real_escape_string($db->link,$Company_name);
							$Contact_person		=mysqli_real_escape_string($db->link,$Contact_person);
							$Contact_number		=mysqli_real_escape_string($db->link,$Contact_number);							
							$Address			=mysqli_real_escape_string($db->link,$Address);
							$status				=mysqli_real_escape_string($db->link,$status);
						
							
							$chk="SELECT * FROM `suppliar` WHERE `Suppliar_ac` LIKE '%$ac%'";
							$check=$db->select($chk);
							if(($check->num_rows)>0){
								echo "<script type='text/javascript'>alert('Suplliar ID Already Exist')</script>";
							}else{
								$query="INSERT INTO suppliar(`Suppliar_ac`, `Company_name`, 
								`Contact_person`, `Contact_number`, `Address`, `Status`) values 
								
								('$ac', '$Company_name', '$Contact_person', '$Contact_number', 
								'$Address', '$status')";
								
								$results=$db->insert($query);
								
								if($results==true){
									echo"<p class='main_bg text-center' style='margin:0px auto; color:#fff;'>Suppliar Added Succesfully</p>";
								}else{
									echo"You should be checked again";
								}
							}
						}
					?>				
						<form action="" method="post" enctype="">			
		 				    <div class="row"> 
								<div class="form-group col-xs-12 col-6 col-md-6">
									<label for="ex2">Suppliar A/C: <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="AC" placeholder="Example: A001" required >
								</div>	
								<div class="form-group col-xs-12 col-6 col-md-6">
									<label for="ex2">Company Name: <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="Company_name"placeholder="Company Name" required>
								</div> 
								<div class="form-group col-xs-12 col-6 col-md-6">
									<label for="ex2">Contact Person: <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="Contact_person"placeholder="Enter Contact Person Name" required>
								</div>
								<div class="form-group col-xs-12 col-6 col-md-6">
									<label for="ex2">Contact Number:<span style="color:red">*</span> </label>
									<input class="form-control" id="ex2" type="text" name="Contact_number" placeholder="01719180080" required>
								</div>						    
								 
								<div class="form-group col-xs-12">
									<label for="ex2">Address </label>
									<textarea class="form-control" id="ex2" rows="4" name="Address" type="text"> </textarea> 
								</div>

                                <div class="form-group col-xs-3 margin_top">							
									<div class="form-check-inline">
									  <label class="form-check-label"> 
                                      <br>
										<input type="radio" class="form-check-input" name="status" value="1" checked> Active 
										<input type="radio" class="form-check-input" name="status" value="0" > Inactive 
									  </label>
									</div>
								 </div> 
								
								<div class="form-group col-xs-6 col-md-6 ">		
                                    <br>				
									<input class="btn btn-info btn-bg" id="ex2" type="submit" name="submit" value="Add Member">
                                    <input class="btn btn-danger" id="ex2" type="reset" value="Reset">
								</div>  
								
                            </div>
                        </form> 













					
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('inc/footer.php'); 
?>
