<?php 
include('inc/hrm_index_header.php'); 
?>

<!-- partial:index.partial.html -->
<div class='dashboard'>
    <div class="dashboard-nav">
        <header>
            <a href="hrm_index.php" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo">
                <i class="fas fa-anchor"></i> <span>HRM</span></a> 
            </br>                 
        </header>      

        <div class="logout"> 
           <a href="#" class="brand-logo">
           <i class="fa fa-sign-out-alt" style="color:#fff"></i>Logout</a>  
        </div>
        <nav class="dashboard-nav-list">
            
            <a href="index.php" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>       
          
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-users" style="color:#fff; text-align:left;"></i> Employee</a>
                <div class='dashboard-nav-dropdown-menu'>                    
                    <a class="dashboard-nav-dropdown-item" href="sales_register.php">  Information</a>
                    <a class="dashboard-nav-dropdown-item" href="invoice_list.php">Leave Opening</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Leave Entry</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Shift Info</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">PF Loan</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Salary Adv.</a>
                </div>
            </div>
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-file" style="color:#fff; text-align:left;"></i> Reports</a>
                <div class='dashboard-nav-dropdown-menu'>                    
                    <a class="dashboard-nav-dropdown-item" href="sales_register.php">  Regular Attandance</a>
                    <a class="dashboard-nav-dropdown-item" href="invoice_list.php">Attandance</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">P.F. Loadn & Salary Advance St.</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Monthly Salary & Wages</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Salary Statement</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Salary Adv.</a>
                </div>
            </div>
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                     <i class="fas fa-dollar-sign" style="color:#fff; text-align:left;"></i> Salary & Wages</a>
                <div class='dashboard-nav-dropdown-menu'>                    
                    <a class="dashboard-nav-dropdown-item" href="sales_register.php">  Service Charge</a>
                    <a class="dashboard-nav-dropdown-item" href="invoice_list.php">O.T. Daily</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">O.T. Monthly</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">L.W.P Entry</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Tax Entry</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Process Salary</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Process Increment</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Bonous Process</a>
                </div>
            </div>

            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-cog" style="color:#fff; text-align:left;"></i> Setting</a>
                <div class='dashboard-nav-dropdown-menu'>                    
                    <a class="dashboard-nav-dropdown-item" href="sales_register.php">  Salary Setting</a>
                    <a class="dashboard-nav-dropdown-item" href="invoice_list.php">Leave Setting</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Increment Setting</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Shift Setting</a>
                    <a class="dashboard-nav-dropdown-item" href="return-history.php">Tax Entry</a> 
                </div>
            </div>
            
            
 
          <div class="nav-item-divider"></div>
          
        </nav>
    </div>
      
    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content' ">
            <div class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h5>Welcome To HRM Panel</h5>
                    </div>
                    <div class='card-body text-center' style="min-height:600px;">
                        
                        <h3 style="padding-top:100px;">Human resource management (HRM) </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 

<?php 
include('inc/footer.php'); 
?>
