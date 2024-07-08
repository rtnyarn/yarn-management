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
                        <h5>Create Chart Of Accounts Group </h5> 
                    </div>
                    <div class='card-body' style="min-height:600px; "> 


                    <?php 
							if(isset($_POST["submit"])){  
								$name				=$fm->validation($_POST['name']); 
								$name				=mysqli_real_escape_string($db->link,$name);  
								$query ="INSERT INTO `ch_group`
								(`name`) 
								VALUES ('$name')";
								$results=$db->insert($query);  
								if($results==true){
										?>  
										<script> 
										
										 swal({
										  title: " Success",
										  text: "",
										  icon: "success",
										});
										window.location.href = 'create_group.php';
										
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
								
							if(isset($_POST["edit"])){  
								$name				=$fm->validation($_POST['name']); 
								$name				=mysqli_real_escape_string($db->link,$name);  
								
								$query ="UPDATE `ch_group` SET
								`name`	='$name'
								where id='$rid'";
								$results=$db->update($query);
								
								if($results==true){
										?>  
										<script> 
										
										 swal({
										  title: " Update Success",
										  text: "",
										  icon: "success",
										});
										window.location.href = 'create_group.php';
										
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
						
						
							
							<?php 
					  
								if ($rid==true){
									$query="SELECT * from ch_group where id='$rid'";
									$query_res=$db->select($query); 
									if($query_res==true){
										while($res=$query_res->fetch_assoc()){
									
				
								?>	
							 <form action="" method="post">			
								<div class="row">  
									<div class="col-xs-12 col-md-12">   
										<div class="col-sm-3 input-group input-group-sm">					
											<span class="input-group-text" id="inputGroup-sizing-sm">Group Name</span>
											<input type="text" class="form-control" aria-label="Sizing example input" 
											aria-describedby="inputGroup-sizing-sm" placeholder="Ex: 50,000" id="amount" name="name"  value="<?php echo $res['name']; ?>">
											<input class="btn btn-info btn-bg" id="ex2" type="submit" name="edit" value="update"> 
										</div> 
									</div> 
								</div>
							</form>  
							
							<?php } } }else{ ?>
							
							<form action="" method="post">			
								<div class="row">  
									<div class="col-xs-12 col-md-12">
										
										<div class="col-sm-3 input-group input-group-sm">					
											<span class="input-group-text" id="inputGroup-sizing-sm">Group Name</span>
											<input type="text" class="form-control" aria-label="Sizing example input" 
											aria-describedby="inputGroup-sizing-sm" placeholder="Ex. Bank" id="amount" name="name"  placeholder="Group Name">
											<input class="btn btn-info btn-bg" id="ex2" type="submit" name="submit" value="create Group"> 
										</div> 
										
									</div> 
									<div class="col-xs-6 col-md-12 "> 
										<br>
										
									</div>
								</div>
							</form>  
							
							<?php }?>	

							
							<table id="example" class=" table-striped table-bordered" style="width:100%">
                            <thead>
									<tr class="bg-light">
                                         <th>SL.No</th>		
										 <th>Group Name</th> 
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                 
								    <?php 
									
									$query1="SELECT * FROM ch_group"; 									
									$results1=$db->select($query1);
								 
									if ($results1){	 
									while($rs=$results1->fetch_assoc()){
								 				
									?>
										<tr>
											<td><?php echo $rs['id'];?> </td> 
											<td><?php echo $rs['name'];?> </td>  
											<td>
											<a href="create_group.php?id='<?php echo $rs['id']; ?>'" class=" btn btn-sm btn_print" 
											style="background: transparent; color:green; font-weight:bold;">Edit</a>
											
											 
											</td>  
										</tr>	
									<?php }}else{?>
									 
								
							 
									<div class="bg-info">
										 <p style='text-align:center; text-white'>No Data Found!</p> 
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
