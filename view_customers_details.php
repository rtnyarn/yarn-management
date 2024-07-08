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
                        <h5>Suppliar Profile</h5>
                    </div>
                    <div class='card-body text-center' style="min-height:600px;">
                        
                        <?php
                            $query ="SELECT * FROM customers where id=$rid";
                            
                            $results = $db->select($query);

                            if ($results){?>
                            <?php while ($rs = $results->fetch_assoc()) {

                            ?> 	
                             <div class='table-container mx-auto' style="max-width:600px; margin-top:10px; "> 
                            
                                    <i class="fa fa-user" style="font-size:100px; color:#1d1b3f;"> </i>
                                    </br> 
                                    </br> 
                                    
                                    
                                <table id="example" class=" table table-hover table-striped table-bordered table-responsive " style="width:98%;">
							
								
                                    <thead>
                                        <tr class="bg-info">																
                                            <th>Title</th>								
                                            <th>Discription</th>								
                                    
                                        </tr>
                                    </thead>
                                    <tbody>	
                                        
                                        <tr>
                                            <td>Suppliar A/C:</td>				
                                            <td><?php echo $rs['ac']; ?></td>	
                                        </tr>
                                        <tr>
                                            <td>First Name: </td>				
                                            <td><?php echo $rs['first_name']; ?></td>	
                                        </tr> 
                                        <tr>
                                            <td>Last Name: </td>				
                                            <td><?php echo $rs['last_name']; ?></td>	
                                        </tr> 
                                        <tr>
                                            <td>Company name:</td>				
                                            <td><?php echo $rs['Company_name']; ?></td>	
                                        </tr> 
                                        <tr>
                                            <td>Membership Date:</td>				
                                            <td><?php echo $rs['membership_date']; ?></td>	
                                        </tr> 
                                        
                                
                                        <tr>
                                            <td>Address: </td>				
                                            <td><?php echo $rs['Address']; ?></td>	
                                        </tr> 
                                        <tr>
                                            <td>Status: </td>				
                                            <td> 
												<?php 
													$status=$rs['status']; 
													if($status==0) {
														echo "<p style='color:red;font-weight:bold;'>Inactive</p>"; 
													}else{
														echo"<p style='color:green; font-weight:bold;'>Active</p>"; 
													}
												?>  
                                            </td>	
                                        </tr> 
                                        </tbody>
                                
                                    </table>

                                    <a href="edit_customer.php?id='<?php echo $rs['id']; ?>'" class="btn btn-sm btn-info btn-bg" 
							        id="ex2" type="submit"> <i class="fas fa-edit"></i> Edit Info </a>
                            </div> 
                        <?php }} ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('inc/footer.php'); 
?>
