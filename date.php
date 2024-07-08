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
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        <div class="col-md-4">

                        <?php
                        if(isset($_POST["submit"])) {
                            $date			=$_POST['date'];
                            $daily_sheet	=$_POST['daily_sheet'];
							
                            $invq="INSERT INTO `date_entry`(`Date`,`daily_sheet_date`) VALUES ('$date','$daily_sheet')";
							
                            $results=$db->insert($invq);
                                if($results == true){
                                    // Success popup message
                                    echo '<script>alert("Date Set Successful!");</script>'; 
                                    echo '<script>window.location.href = "sales_index_register.php";</script>';
                                    exit; // Stop further execution
                                } else {
                                 
                                    echo '<script>alert("Insertion failed. Please try again.");</script>';
                                } 
                            }
                        ?>
                            <form action="" method ="post" enctype="">
                                <div class="form-group">
                                    <div id="filterDate2">
                                       <label style="font-weight:bold; font-size:20px;"> Entry Date </label> 
                                        <div class="input-group date" data-date-format="dd.mm.yyyy"> 
                                            <input  type="date" class="form-control" name="date" value="11-01-2023" required>
                                            <div class="input-group-addon" >
                                            <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div> 
                                    </div>
									<div id="filterDate2">
                                       <label style="font-weight:bold; font-size:20px;"> Daily Sheet Date </label> 
                                        <div class="input-group date" data-date-format="dd.mm.yyyy"> 
                                            <input  type="text" class="form-control" name="daily_sheet" placeholder="01 & 02/10/2024" >
                                            <div class="input-group-addon" >
                                            <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div> 
                                    </div>    
                                </div>
                                <input type="submit" name="submit" 
                                class="btn "style="background:#1175B9; margin-top: 10px; color:#fff; "  value="Set Date" /> 
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
