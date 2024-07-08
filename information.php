<?php 
include('inc/information_index_header.php'); 
?>

<div class='dashboard'>
    <div class="dashboard-nav">
        <header>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo">
            <i class="fas fa-info-circle"></i>Information</span></a> 
                
        </header>
        <div class="logout"> 
           <a href="#" class="brand-logo">
           <i class="fa fa-sign-out-alt" style="color:#fff"></i>Logout</a>  
        </div>        
        <nav class="dashboard-nav-list">
            
            <a href="index.php" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>       
                    
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fas fa-cogs"></i> Settings </a>
                <div class='dashboard-nav-dropdown-menu'>  
                    <a class="dashboard-nav-dropdown-item" href="expnes_edit.php">Edit Expnes</a>
                    <a class="dashboard-nav-dropdown-item" href="expnes_ledger.php">Ledger</a> 
                </div>
            </div>

           
                   <a href="#" class="dashboard-nav-item"><i class="fas fa-user"></i> Company Profile </a>
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
                        <h5>Welcome To POS Management System</h5>
                    </div>
                    <div class='card-body text-center' style="min-height:600px;">
                        
                        <h3 style="padding-top:100px;">Your Accounts Accuracey is Our Goal </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('inc/footer.php'); 
?>

