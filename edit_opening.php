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
         
        
        <div class='dashboard-content'>
            <div class='container'>
                <div class='card'>
                    <div class='card-header' style="background:#1175B9; color:#fff; ">
                        <h5>Update Opening Balance </h5> 
                    </div>
                    <div class='card-body' style="min-height:600px; "> 


                    <?php 
						if(isset($_POST["submit"])){
							
							
				 				
								$Opening	=$fm->validation($_POST['Opening']);
								$Opening	=mysqli_real_escape_string($db->link,$Opening); 
						
								
								$dateEntry='2023-12-31'; 
								
								$query="UPDATE daily_transection SET 							
								`date`				='$dateEntry',  
								`op_balance`		='$Opening' 
								 where 				id=$rid";	
								
								$results=$db->update($query);
						 
								
								if($results==true){
										?>  
										<script> 
										
										 swal({
										  title: "Successfully Updated",
										  text: "",
										  icon: "success",
										});
										window.location.href = 'opening_balance.php';
										
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
							?>	
						
						<div style="min-height:200px; width:50%; 
						margin:0px auto; padding: 10px; box-shadow:2px 2px 2px 2px;" > 
							<form action="" method="post">			
								<div class="row">  
									<div class="col-xs-12 col-md-12">
										<label for="ex2" style="font-weight:bold; color:green;">Opening Balance</label> 
										
										<?php
											$query ="SELECT * FROM daily_transection where id=$rid";
											   
											$results = $db->select($query);

											if ($results){?>
											<?php while ($rs = $results->fetch_assoc()) {

											?>
										<div class="col-sm-3 input-group input-group-sm">					
											<span class="input-group-text" id="inputGroup-sizing-sm">Opening Balance</span>
											<input type="text" class="form-control" aria-label="Sizing example input" 
											aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000" id="amount" name="Opening"  value="<?php echo $rs['op_balance']; ?>">
											
										</div>
										<div class="col-sm-3 input-group input-group-sm">					
												<span>Like if debit -1000 or Credit 1000 </span>
											
										</div>
											
											<?php }} ?>
										
									</div> 
									
									<div class="col-xs-6 col-md-12 "> 
										<br>
										<input class="btn btn-info btn-bg" id="ex2" type="submit" name="submit" value="Update"> 
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


<?php 
include('inc/footer.php'); 
?>
