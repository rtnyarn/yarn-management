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
                        <h5>Payment Reciept</h5>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-4">
							<div style="border: 2px solid #eee; padding: 10px;"> 
							
							 
									<?php
									//edit id 
									$id = "";
									if(isset($_POST["edit"])){	
										$id = $_POST['payment_id']; 
									}
									?>
									 <?php 
												if(isset($_POST["submit"])){
													
													$date 					=$fm->validation($_POST['date']); 
													$daily_sheet_date 		=$fm->validation($_POST['dailydate']); 
													$head					=$fm->validation($_POST['head_id']);							
													$narration				=$fm->validation($_POST['narration']);
													$amount					=$fm->validation($_POST['amount']); 
													$Directsales			=$fm->validation($_POST['Directsales']);
													
													$date					=mysqli_real_escape_string($db->link,$date);
													$daily_sheet_date		=mysqli_real_escape_string($db->link,$daily_sheet_date);
													$head					=mysqli_real_escape_string($db->link,$head);
													$narration				=mysqli_real_escape_string($db->link,$narration);	
													$amount					=mysqli_real_escape_string($db->link,$amount);	 
													$Directsales			=mysqli_real_escape_string($db->link,$Directsales);	 
														if (!$head || !$narration || !$amount) {
															?>
															<script>
																swal({
																	title: "Please Fill-up mandotory Field",
																	text: "",
																	icon: "error",
																});
															</script>
															<?php
														}else{ 
													
															$query ="INSERT INTO `expens`
															(`head`, `narration`, `amount`,`date`,`daily_sheet_date`,`head_id`) 
															VALUES ('$head','$narration','$amount','$date', '$daily_sheet_date', '$head')";
															$results=$db->insert($query); 
															
															
															
															$payment_reciept_id = $db->select("SELECT * FROM expens ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];  
								
															$dailyquery ="INSERT INTO `daily_transection`
															(`lederid`, `narration`, `recive_amount`,`expense_amount`, `date`, `Directsales`, `payement_receipt_id`, `daily_sheet_date`) 
															VALUES ('$head','$narration','0','$amount','$date','$Directsales','$payment_reciept_id','$daily_sheet_date')";
														
															
															$dailyquery=$db->insert($dailyquery); 
															
															if($results==true){
																?>  
																<script> 
																  swal({
																	title: "Payment Success",
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
												
												 
												if(isset($_POST["update"])){
													$date 					=$fm->validation($_POST['date']);
													$daily_sheet_date 		=$fm->validation($_POST['dailydate']); 
													$head					=$fm->validation($_POST['head_id']);							
													$narration				=$fm->validation($_POST['narration']);
													$amount					=$fm->validation($_POST['amount']);	 
													$Directsales			=$fm->validation($_POST['Directsales']);
													$id 					=$fm->validation($_POST['payment_id']);
													
													$date					=mysqli_real_escape_string($db->link,$date); 
													$daily_sheet_date		=mysqli_real_escape_string($db->link,$daily_sheet_date); 
													$head					=mysqli_real_escape_string($db->link,$head);
													$narration				=mysqli_real_escape_string($db->link,$narration);	
													$amount					=mysqli_real_escape_string($db->link,$amount);	 
													$Directsales			=mysqli_real_escape_string($db->link,$Directsales);													
													$id						=mysqli_real_escape_string($db->link,$id);									
													
													
													
														if (!$head || !$narration || !$amount) {
															?>
															<script>
																swal({
																	title: "Please Fill-up mandotory Field",
																	text: "",
																	icon: "error",
																});
															</script>
															<?php
														}else{ 
													
																	$query ="Update `expens` SET										
																	`head`		 		='$head',
																	`narration`			='$narration', 
																	`amount`			='$amount',
																	`date` 				='$date',
																	`daily_sheet_date` 	='$daily_sheet_date',
																	`head_id`			='$head'
																	
																	where id=$id";
																	
																	$results=$db->update($query); 
																	
																	
																	$query1 ="Update `daily_transection` set 
									
																	`lederid`				='$head',
																	`narration`				='$narration',
																	`expense_amount`		='$amount',
																	`date`					='$date',
																	`Directsales`			='$Directsales',
																	`daily_sheet_date`		='$daily_sheet_date'
																	 
																	 where payement_receipt_id='$id'";
																	
																	$results1=$db->update($query1); 
											
																	if($results==true){
																	 
																		?>  
																		<script> 
																		  swal({
																			title: "Payment Update Success",
																			text: "",
																			icon: "success",
																		  }).then(function() {
																			document.querySelector('.btn_print').focus();
																		  });
																		</script> 
																	<?php
																	
																	 keepid($id);
																	
																	
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
												
												//after submit update information this function will be keep id for preview data inside edit page 
												function keepid($id){ } 
												
											?>
											
											<?php
												//Delete Area 
												if(isset($_POST["delete"])){
													$id = $_POST['payment_id'];
													$query ="Delete from `expens` where id='$id'";
													$query1 ="Delete from `daily_transection` where payement_receipt_id='$id'"; 
													
													$results=$db->delete($query);
													$results1=$db->delete($query1);										
													
													 ?>
													<script> 
														swal({
														  title: "Successfully Deleted",
														  text: "",
														  icon: "success",
														});
														window.location.href = 'payment_recipt.php';
													</script> 
													
														<?php
												}
												?> 
											
											<?php
											//voucher print area 
											if(isset($_POST["print"])){	
												$id = $_POST['payment_id'];
												$url = "payment_receipt.php?spvid=$id";
												header("Location: $url");
												exit();
											}
											?>
										
											
											 
											 <?php  
												if ($id ==false){
											 ?> 
										 
											<div class="sale_entry_tickets text-left">  
											<form action="" method="post"> 
											 
											<div class="row align-items-center g-2">
											
											
												<div class="input-group input-group-sm mb-3">  
												 <span class="input-group-text" id="inputGroup-sizing-sm">Previous ID: PR-ARR-</span>
												<?php 
													$queryvou="SELECT *from expens ORDER BY id DESC LIMIT 1";
													$resultsvou=$db->select($queryvou);
													if($resultsvou==true){
													while($vid=$resultsvou->fetch_assoc()){ 
												?> 
												 <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="date" name="payment_id" value="<?php echo $vid['id']?>" />
												<?php }}?>
												</div> 
												
												<div class="input-group input-group-sm mb-3"> 
													<?php
													$date = ($result = $db->select("SELECT Date FROM date_entry ORDER BY id DESC LIMIT 1"))->num_rows> 0 ?
													$result->fetch_assoc()['Date'] : null;
													?>
													<span class="input-group-text" id="inputGroup-sizing-sm">Entry Date</span>
													<input type="text" class="form-control" name="date" value="<?php echo $date ?>"> 
													<?php
													$dailydate = ($result1 = $db->select("SELECT daily_sheet_date FROM date_entry ORDER BY id DESC LIMIT 1"))->num_rows> 0 ?
													$result1->fetch_assoc()['daily_sheet_date'] : null;
													?>
													<span class="input-group-text" id="inputGroup-sizing-sm">Sheet Date</span>
													<input type="text" class="form-control" name="dailydate" value="<?php echo $dailydate ?>">  
													
												</div> 
												 
												
												
												<?php		
													$query="SELECT * FROM customers order by id DESC";
													$results=$db->select($query); 
													$oppro2="";
														if ($results==true){
																while($dis=$results->fetch_assoc()){
																$oppro2.="<option value='".$dis['ac']."'>".$dis['ac']."-".$dis['first_name']." ".$dis['last_name'].", ".$dis['Address']."</option>";
														}
													}													
												?>
												<div class="input-group input-group-sm mb-3">  
													<select class="select2 form-control" name="head_id" multiple="multiple" 
													data-placeholder="Type Ledger Code or Name" onchange="getprice(this.value)" 
													data-dropdown-css-class="select2-purple"  required> 
														<?php echo $oppro2; ?>
													</select>	
												</div>
												<div class="input-group input-group-sm mb-3">					
													<span class="input-group-text" id="inputGroup-sizing-sm">Narration</span>
													<textarea class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" rows="5" name="narration"> </textarea> 
												</div>
												<div class="col-sm-3 input-group input-group-sm">					
													<span class="input-group-text" id="inputGroup-sizing-sm">Amount</span>
													<input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000"	id="amount" name="amount" >
												</div>
												<div class="col-sm-3 input-group input-group-sm">	
													<div class="form-check">
													  <input class="form-check-input" name="Directsales" type="checkbox" value="1" id="flexCheckChecked">
													  <label class="form-check-label" for="flexCheckChecked">
														Direct Sales 
													  </label>
													</div>	
												</div>												
												
												<div class="col-auto">
													<button type="submit" name="submit" class="btn btn-primary main_btn">Save Entry</button>
													<button type="submit" name="print" class="btn btn-primary main_btn btn_print">Print</button>
													<button type="submit" name="edit" class="btn btn-primary main_btn btn_print">Edit</button>
												</div>
											</div>
										</form>
										
										 <?php }else{  ?>
										 
										  <div class="sale_entry_tickets text-center">  
												<h5> Payement Receipt Edit</h5> 
											</div> 
											<div class="sale_entry_tickets text-left">  
										 <form action="" method="post"> 
											 
											 
											<?php 
												$queryvou="SELECT *from expens where id='$id'";
												$resultsvou=$db->select($queryvou);
												if($resultsvou==true){
												while($res=$resultsvou->fetch_assoc()){
											
											?> 
												<div class="row align-items-center g-2">
													<div class="input-group input-group-sm mb-3">
													 <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
													 <input type="date" class="form-control" aria-label="Sizing example input"
													 aria-describedby="inputGroup-sizing-sm" name="date" value="<?php echo $res['date'];?>"  />
													 <span class="input-group-text" id="inputGroup-sizing-sm">PR-ARR-</span>
													 <input type="text" class="form-control" aria-label="Sizing example input"
													 aria-describedby="inputGroup-sizing-sm" name="payment_id" value="<?php echo $res['id'];?>" />
													
													</div> 
													<div class="input-group input-group-sm mb-3">  
														<span class="input-group-text" id="inputGroup-sizing-sm">Entry Date</span>
														<input type="text" class="form-control" name="date" value="<?php echo $res['date'];?>">  
														<span class="input-group-text" id="inputGroup-sizing-sm">Sheet Date</span>
														<input type="text" class="form-control" name="dailydate" value="<?php echo $res['daily_sheet_date'];?>">  
													</div> 
												
													<?php	 
														$query="SELECT * FROM customers order by id DESC";
														$results=$db->select($query); 
														$oppro2="";
															if ($results==true){
																	while($dis=$results->fetch_assoc()){
																	$oppro2.="<option value='".$dis['ac']."'>".$dis['ac']."-".$dis['first_name']." ".$dis['last_name'].", ".$dis['Address']."</option>";
															}
														} 
													?>
												<div class="input-group input-group-sm mb-3">  
													<select class="select2 form-control" name="head_id" multiple="multiple" 
														data-placeholder="Type Head Name" onchange="getprice(this.value)" data-dropdown-css-class="select2-purple"  >
														<?php
														$head_id = $res['head_id'];
														$query2="SELECT * FROM customers where ac='$head_id'";
														$results2=$db->select($query2);
															if ($results2==true){
																	while($dis2=$results2->fetch_assoc()){
																	echo  "<option value='".$dis2['ac']."' selected>".$dis2['first_name']." ".$dis2['last_name']." ".$dis2['Address']."</option>";
																}
															}
														
														?> 
														<?php echo $oppro2; ?>
													</select>	
												</div>
												<div class="input-group input-group-sm mb-3">					
													<span class="input-group-text" id="inputGroup-sizing-sm">Narration</span>
													<textarea class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" rows="5" name="narration"><?php echo $res['narration']?></textarea> 
												</div>
												<div class="col-sm-3 input-group input-group-sm">					
													<span class="input-group-text" id="inputGroup-sizing-sm">Amount</span>
													<input type="text" class="form-control" aria-label="Sizing example input" 
													aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000" id="amount" name="amount"  value="<?php echo $res['amount']?>">
												</div>  
												
												<div class="col-sm-3 input-group input-group-sm">	
													<div class="form-check">
													  <input class="form-check-input" name="Directsales" type="checkbox" value="1" id="flexCheckChecked">
													  <label class="form-check-label" for="flexCheckChecked">
														Direct Sales 
													  </label>
													</div>	
												</div>	
												
												<div class="col-auto">
													<button type="submit" name="update" class="btn btn-primary main_btn">Update Info</button>
													<button type="submit" name="print" class="btn btn-primary main_btn btn_print">Print</button>
													<button type="submit" name="edit" class="btn btn-primary main_btn btn_print">Edit</button>
												</div>
											</div>
											
											<?php }}?>
										</form>
										 <?php } ?>
										
												
						  
								</div> 
							</div> 
						</div> 
						
						<div class="col-md-8">
							<table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="bg-light">
										<th>M.R.ID</th>
                                        <th>Entry Date</th>								
                                        <th>Sheet Date</th> 		
                                        <th>Client Name</th>
                                        <th>Narration</th>
                                        <th>Amount</th>
                                        <th style="width:100px">Action</th>
									</tr>
								</thead>
								<tbody>
                                 
								    <?php		
									$dateSelect = $db->select("SELECT * FROM date_entry ORDER BY id DESC LIMIT 1")->fetch_assoc()['Date']; 
									$query1="SELECT * FROM expens where date='$dateSelect' ORDER BY id DESC";
									$results1=$db->select($query1);
									$id=0; 
									if ($results1){	
									?>
									<?php
									while($rs=$results1->fetch_assoc()){
									$id++; 						
									?>
										<tr>
											<td>MR-<?php echo $rs['id'];?> </td> 
											<td><?php echo $rs['date'];?> </td> 
											<td><?php echo $rs['daily_sheet_date'];?> </td> 
											<td><?php 
											
												$ledger_id=$rs['head'];
												$query="SELECT * FROM customers where ac='$ledger_id'";
												$results=$db->select($query); 
												if ($results==true){
														while($res=$results->fetch_assoc()){															
														$name=$res['first_name'].' '.$res['last_name']; 
														
														echo $name; 
														
													}
												} 
											?> </td> 
											<td><?php echo $rs['narration'];?> </td> 
											<td><?php echo $rs['amount'];?> </td> 
											<td>   
											<form action="" method="post">  
											<input type="hidden" class="form-control"  name="payment_id" value="<?php echo $rs['id']?>" />
											<button type="submit" name="edit" class=" btn_print" style="color:green; font-weight:bold; margin-right:10px;">Edit</button>
											<button type="submit" name="delete" class="btn_print" style="color:red; font-weight:bold;">delete</button>
											</form> 
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
