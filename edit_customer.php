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
                        <h5><i class="fa fa-users" style="color:#000;"> </i> Update Customer Info</h5> 
                    </div>
                    <div class='card-body' style="min-height:600px;"> 
                    <?php 
								if(isset($_POST["submit"])){
									
									$ac					=$fm->validation($_POST['ac']);
									$first_name			=$fm->validation($_POST['first_name']);
									$last_name			=$fm->validation($_POST['last_name']);
									$mobile_number		=$fm->validation($_POST['mobile_number']);
									$membership_date	=$fm->validation($_POST['membership_date']);														
									$Company_name		=$fm->validation($_POST['Company_name']);
									$Address			=$fm->validation($_POST['Address']);											
									$status				=$fm->validation($_POST['status']);
							
									
									
									$ac					=mysqli_real_escape_string($db->link,$ac);
									$first_name			=mysqli_real_escape_string($db->link,$first_name);
									$last_name			=mysqli_real_escape_string($db->link,$last_name);
									$mobile_number		=mysqli_real_escape_string($db->link,$mobile_number);						
									$membership_date	=mysqli_real_escape_string($db->link,$membership_date);
									$Company_name		=mysqli_real_escape_string($db->link,$Company_name);
									$Address			=mysqli_real_escape_string($db->link,$Address);						
									$status				=mysqli_real_escape_string($db->link,$status); 
							
									$query="UPDATE customers SET 
										ac				='$ac', 
										first_name		='$first_name', 
										last_name		='$last_name', 
										mobile_number	='$mobile_number',
										Address			='$Address',
										Company_name	='$Company_name',
										membership_date	='$membership_date',
										status			='$status'					
										where 			id=$rid";								
										$results=$db->update($query);
										
										if($results==true){
											echo"<p class='text-center text-success' style='font-size:18px;'>Customers Information Update Succesfully</p>";
										}else{
											echo"You should be checked again";
										}
									}
							?>
				
							<?php
								$query ="SELECT * FROM customers where id=$rid";
								   
								$results = $db->select($query);

								if ($results){?>
								<?php while ($rs = $results->fetch_assoc()) {

								?>

						<form action="" method="post" enctype="">			
                              <div class="row"> 
                              <div class="col-xs-12 col-md-6">
									<label for="ex2">Customer A/C: <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="ac" value="<?php echo $rs['ac']; ?>" required >
								  </div>	
								  <div class="col-xs-12 col-md-6">
									<label for="ex2">First Name <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="first_name"value="<?php echo $rs['first_name']; ?>" required>
								  </div>
								  <div class="col-xs-12 col-md-6">
									<label for="ex3">Last Name <span style="color:red">*</span></label>
									<input class="form-control" id="ex3" type="text" name="last_name" value="<?php echo $rs['last_name']; ?>" required>
								  </div>
								  <div class="col-xs-12 col-md-6">
									<label for="ex2">Mobile Number <span style="color:red">*</span> </label>
									<input class="form-control" id="ex2" type="text" name="mobile_number" value="<?php echo $rs['mobile_number']; ?>" required>
								  </div>							 
								  <div class="col-xs-12 col-md-6" >
									<label for="ex2">Membership Date <span style="color:red">*</span></label>									
									  <div class="form-group">
										<div id="filterDate2">
											<!-- Datepicker as text field -->         
										  <div class="input-group date" data-date-format="dd.mm.yyyy">
											<input  type="text" class="form-control" name="membership_date" value="<?php echo $rs['membership_date'];?>" >
											<div class="input-group-addon" >
											  <span class="glyphicon glyphicon-th"></span>
											</div>
										  </div>										  
										  <script type="text/javascript">										  
										   $('.input-group.date').datepicker({format: "dd.mm.yyyy"}); 
										  </script>
										</div>    
									  </div>															
								  </div>
									<div class="col-xs-12 col-md-6">
									<label for="ex2">Company Name <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="Company_name" value="<?php echo $rs['Company_name'];?> " required>
								  </div>
								  
							  <div class="col-xs-12 col-md-12">
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
								 <div class="col-xs-6 ">
                                    <br> 							
									<input class=" btn btn-sm btn-info btn-bg" id="ex2" type="submit" name="submit" value="Update Info">
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
