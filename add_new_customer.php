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
                    <div class='card-header' style="background:#1175B9; color:#fff; ">
                        <h5><i class="fa fa-users" style="color:#000;"> </i> Add New </h5> 
                    </div>
                    <div class='card-body' style="min-height:600px;"> 


                    <?php 
						if(isset($_POST["submit"])){
							
							$ac_type			=$fm->validation($_POST['ac_type']);
							$ac					=$fm->validation($_POST['ac']);
							$first_name			=$fm->validation($_POST['first_name']);
							$last_name			=$fm->validation($_POST['last_name']);
							$mobile_number		=$fm->validation($_POST['mobile_number']);
							$membership_date	=$fm->validation($_POST['membership_date']);														
							$Company_name		=$fm->validation($_POST['Company_name']);
							//opening balance 
							$debit				=$fm->validation($_POST['debit']);
							$credit				=$fm->validation($_POST['credit']);
							
							$Address			=$fm->validation($_POST['Address']);											
							$status				=$fm->validation($_POST['status']);
							
							
							
							$ac_type			=mysqli_real_escape_string($db->link,$ac_type);
							$ac					=mysqli_real_escape_string($db->link,$ac);
							$first_name			=mysqli_real_escape_string($db->link,$first_name);
							$last_name			=mysqli_real_escape_string($db->link,$last_name);
							$mobile_number		=mysqli_real_escape_string($db->link,$mobile_number);						
							$membership_date	=mysqli_real_escape_string($db->link,$membership_date);
							$Company_name		=mysqli_real_escape_string($db->link,$Company_name);
							$Address			=mysqli_real_escape_string($db->link,$Address);						
							$status				=mysqli_real_escape_string($db->link,$status);
							
							
							
							$chk="SELECT * FROM `customers` WHERE `ac` LIKE '%$ac%'";
							$check=$db->select($chk);
							if(($check->num_rows)>0){
								echo "<script type='text/javascript'>alert('A/C Already Exist')</script>";
							}else{
								$query="INSERT INTO `customers`(`ac_type`,`ac`, `first_name`, `last_name`, 
								`mobile_number`, `Address`, `Company_name`, `membership_date`, `status`)values 
								
								('$ac_type','$ac', '$first_name', '$last_name', '$mobile_number', 
								 '$Address','$Company_name','$membership_date', '$status')";
								$results=$db->insert($query);
								
								
								$dailyquery ="INSERT INTO `daily_transection`
									(`lederid`, `narration`, `recive_amount`,`expense_amount`, `date`, 
									`Directsales`, `payement_receipt_id`, `daily_sheet_date`, `op_id`) 
									VALUES ('$ac','Opening Balance','$debit','$credit','2023-12-31',
									'0','0','0','1')";  
									
								$result1=$db->insert($dailyquery);
								
								if($results==true){
										?>  
										<script> 
										  swal({
											title: "Ledger Created",
											text: "",
											icon: "success",
										  }).then(function() {
											document.querySelector('.btn_print').focus();
										  });
										</script> 
									<?php
									}else{
										?> 
										
										 <script> 
											swal({
											  title: "Something Wrong",
											  text: "",
											  icon: "error",
											});
										</script> 
									<?php
									} 
							}
						}
					?>	
						<form action="" method="post" enctype="">			
		 				    <div class="row"> 
									<div class="col-xs-12 col-md-6">
									<label for="ex2">A/C Type <span style="color:red">*</span></label>
									<select class="form-select form-select-sm" name="ac_type" aria-label=".form-select-sm example" required>
									<option value="" selected disabled>Select an option</option>
									 <?php 
									
									$query1="SELECT * FROM ch_group"; 									
									$results1=$db->select($query1);
								 
									if ($results1){	 
									while($rs=$results1->fetch_assoc()){
								 				
									?>
									<option value="<?php echo $rs['id'];?> "><?php echo $rs['name'];?> </option>
									
									<?php }} ?>
								 
								</select>

								  </div>	
								  <div class="col-xs-12 col-md-6">
									<label for="ex2">A/C: <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="ac" placeholder="Example: A001" required >
								  </div>	
								  <div class="col-xs-12 col-md-6">
									<label for="ex2">First Name <span style="color:red">*</span></label>
									<input class="form-control" id="ex2" type="text" name="first_name"placeholder="Mridha Belal" required>
								  </div>
								  <div class="col-xs-12 col-md-6">
									<label for="ex3">Last Name <span style="color:red">*</span></label>
									<input class="form-control" id="ex3" type="text" name="last_name" placeholder="Hasnain" required>
								  </div>
								  <div class="col-xs-12 col-md-6">
									<label for="ex2">Mobile Number <span style="color:red">*</span> </label>
									<input class="form-control" id="ex2" type="text" name="mobile_number" placeholder="01719180080" >
								  </div>							  
								  <div class="col-xs-12 col-md-6" >							  
									<label for="ex2">Membership Date <span style="color:red">*</span></label>									
									  <div class="form-group">
										<div id="filterDate2">
											<!-- Datepicker as text field -->         
										  <div class="input-group date" data-date-format="dd.mm.yyyy">
											<input  type="date" class="form-control" name="membership_date">
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
									<label for="ex2">Company Name </label>
									<input class="form-control" id="ex2" type="text" name="Company_name" placeholder="Knit Concern Ltd. ">
								  </div>
								   <div class="col-xs-12 col-md-6">
									<label for="ex2" style="font-weight:bold; color:green;">Opening Balance</label>
									 
									<div class="col-sm-3 input-group input-group-sm">					
										<span class="input-group-text" id="inputGroup-sizing-sm">Debit</span>
										<input type="text" class="form-control" aria-label="Sizing example input" 
										aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000" id="amount" name="debit"  value="0">
									</div>
									<div class="col-sm-3 input-group input-group-sm">					
										<span class="input-group-text" id="inputGroup-sizing-sm">Credit</span>
										<input type="text" class="form-control" aria-label="Sizing example input" 
										aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000" id="amount" name="credit"  value="0">
									</div>
								  </div>
								  <div class="col-xs-12 col-md-12">
									<label for="ex2">Address </label>
									<textarea class="form-control" id="ex2" rows="5" name="Address" type="text"> </textarea> 
								  </div>
                                  <div class="col-xs-3 ">							
									<div class="form-check-inline">
									  <label class="form-check-label"> 
										<input type="radio" class="form-check-input" name="status" value="1" checked> Active 
										<input type="radio" class="form-check-input" name="status" value="0" > Inactive 
									  </label>
									</div>
								 </div>
								 
								 <div class="col-xs-6 col-md-6 ">
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
