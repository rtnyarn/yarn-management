<?php 
include('inc/sales_index_header.php'); 
?>

<?php 
		if (empty($_GET['id'])){
		}elseif(!isset($_GET['id']) || $_GET['id'] == NULL){
			echo 'Something went to wrong';
		}else{
				$tid= $_GET['id'];
				$id= preg_replace("/[^0-9a-zA-Z]/", "", $tid);
				$rid = $id;
		}
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
                        <h5><i class="fa fa-users" style="color:#000;"> </i> Update Supplier Information</h5> 
                    </div>
                    <div class='card-body' style="min-height:600px;"> 

                    <?php 
								if(isset($_POST["submit"])){
								
								$ac					=$fm->validation($_POST['ac']);
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
							
					
									
								$query="UPDATE suppliar SET 
									Suppliar_ac			='$ac', 
									Company_name		='$Company_name', 
									Contact_person		='$Contact_person', 
									Contact_number		='$Contact_number', 
									Address				='$Address',
									status				='$status'					
									where 			id	=$rid";
									
									$results=$db->update($query);								
									if($results==true){
										?>
										<h3 class='bg_main text-center text-success' >
                                        Update Update Succesfully</h3> 
									<?php 
									}else{
										echo"You should be checked again";
									}
								}
							?>
			
							<?php
							$query ="SELECT * FROM suppliar where id=$rid";
							   
							$results = $db->select($query);

							if ($results){?>
							<?php while ($rs = $results->fetch_assoc()) {

							?> 


						<form action="" method="post" enctype="">			
                              <div class="row"> 
							         <div class="col-xs-6 col-6"">
										<label for="ex2">Suppliar A/C: <span style="color:red">*</span></label>
										<input class="form-control" id="ex2" type="text" name="ac" value="<?php echo $rs['Suppliar_ac']; ?>" required >
									</div>
									
									<div class="col-xs-6 col-6">
										<label for="ex2">Company Name: <span style="color:red">*</span></label>
										<input class="form-control" id="ex2" type="text" name="Company_name" value="<?php echo $rs['Company_name'];?>" required>
									</div> 
									
									<div class="col-xs-6 col-6"">
										<label for="ex2">Contact Person: <span style="color:red">*</span></label>
										<input class="form-control" id="ex2" type="text" name="Contact_person" value="<?php echo $rs['Contact_person'];?>" required>
									</div>
									
									<div class="col-xs-6 col-6"">
										<label for="ex2">Contact Number:<span style="color:red">*</span> </label>
										<input class="form-control" id="ex2" type="text" name="Contact_number" value="<?php echo $rs['Contact_number'];?>" required>
									</div>						  
								 
								  <div class="col-xs-12">
									<label for="ex2">Address </label>
									<textarea class="form-control" id="ex2" rows="10" name="Address" type="text"><?php echo $rs['Address'];?> </textarea> 
								  </div>
								  
								<div class="col-xs-12 margin_top">							
									<div class="form-check-inline">
									  <label class="form-check-label"> 
										<input type="radio" class="form-check-input" name="status" value="1" checked> Active 
										<input type="radio" class="form-check-input" name="status" value="0" > Inactive 
									  </label>
									</div>
								 </div> 
								 
								 <div class="col-xs-6 margin_top">							
									<input class="btn btn-sm btn-info btn-bg" id="ex2" type="submit" name="submit" value="Update Info">
								 </div>						 
                            </div> 
                        </form>  

                        <?php } ?>
				    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('inc/footer.php'); 
?>
