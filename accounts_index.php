<?php 
include('inc/accounts_index_header.php'); 
?>
<!-- partial:index.partial.html -->
<div class='dashboard'>
    <div class="dashboard-nav">
        <header>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo">
                <i class="fas fa-anchor"></i> <span>Accounts & Reports</span></a> 
                
        </header>
        <div class="logout"> 
           <a href="#" class="brand-logo">
           <i class="fa fa-sign-out-alt" style="color:#fff"></i>Logout</a>  
        </div>
        <nav class="dashboard-nav-list">
            
            <a href="index.php" class="dashboard-nav-item"><i class="fas fa-home"></i>Home </a>       
          
                      
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-minus" style="color:#fff; text-align:left;"></i> Payment</a>
                <div class='dashboard-nav-dropdown-menu'>      
                    <a class="dashboard-nav-dropdown-item" href="new_expens.php">New Expens</a>
                    <a class="dashboard-nav-dropdown-item" href="add_newhead.php">Add New Head</a>
                    <a class="dashboard-nav-dropdown-item" href="expnes_edit.php">Edit Expnes</a>
                    <a class="dashboard-nav-dropdown-item" href="expnes_ledger.php">Ledger</a> 
                </div>
            </div>

            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-file" style="color:#fff; text-align:left;"></i> Reports Panel</a>
                <div class='dashboard-nav-dropdown-menu'>      
                    <a class="dashboard-nav-dropdown-item" href="salesreport.php">Sales Report</a>
                    <a class="dashboard-nav-dropdown-item" href="final_report.php">Monthly Report </a>
                    <a class="dashboard-nav-dropdown-item" href="stock_report.php">Stock Position </a>
                    
                </div>
            </div>

            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fa fa-dollar-sign" style="color:#fff; text-align:left;"></i> Accounts Panel</a>
                <div class='dashboard-nav-dropdown-menu'>      
                    <a class="dashboard-nav-dropdown-item" href="collect_mony.php">Collect Money</a>
                    <a class="dashboard-nav-dropdown-item" class="dashboard-nav-dropdown-item"href="money_receipt_list.php">Print Money Recipt</a>
                    <a class="dashboard-nav-dropdown-item" href="distributor_ledger_search.php">Distributer Ledger</a>
                    <a class="dashboard-nav-dropdown-item" href="ec_members_monthly_ledger_search.php">Monthly Ledger</a>
                    <a class="dashboard-nav-dropdown-item" href="collecteble_dues.php">Collecteble Dues</a>
                    <a class="dashboard-nav-dropdown-item" href="add_bank.php">Add New Bank</a>
                    <a class="dashboard-nav-dropdown-item" href="bank_deposite.php">Deposite Money To Bank</a>
                    <a class="dashboard-nav-dropdown-item" href="bank_depositeinfo.php">Bank Account Ledger</a> 
                    
                </div>
            </div>
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"> 
                    <i class="fas fa-cogs"></i> Settings </a>
                <div class='dashboard-nav-dropdown-menu'>      
                    <a class="dashboard-nav-dropdown-item" href="collect_mony.php">Collect Money</a>
                    <a class="dashboard-nav-dropdown-item" class="dashboard-nav-dropdown-item"href="money_receipt_list.php">Print Money Recipt</a>
                    <a class="dashboard-nav-dropdown-item" href="distributor_ledger_search.php">Distributer Ledger</a>
                    <a class="dashboard-nav-dropdown-item" href="ec_members_monthly_ledger_search.php">Monthly Ledger</a>
                    <a class="dashboard-nav-dropdown-item" href="collecteble_dues.php">Collecteble Dues</a>
                    <a class="dashboard-nav-dropdown-item" href="add_bank.php">Add New Bank</a>
                    <a class="dashboard-nav-dropdown-item" href="bank_deposite.php">Deposite Money To Bank</a>
                    <a class="dashboard-nav-dropdown-item" href="bank_depositeinfo.php">Bank Account Ledger</a> 
                    
                </div>
            </div>

           
                   <a href="#" class="dashboard-nav-item"><i class="fas fa-user"></i> Profile </a>
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
