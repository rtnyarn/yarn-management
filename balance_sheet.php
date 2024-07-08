<?php
include('inc/sales_index_header.php');
error_reporting(0);

if (isset($_POST['submit'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
} else {
    echo "No Data Found";
}

// All Functions 
// Bank Function 
$trialBalance = BankTotal($db, $from, $to);
$totalDebit = $trialBalance['totalDebit'];
$totalCredit = $trialBalance['totalCredit'];  
// FDRS 
$trialfdr = fdrs($db, $from, $to);
$totalDebitfdr = $trialfdr['totalDebit'];
$totalCreditfdr = $trialfdr['totalCredit'];  

// End Bank Function 

// Cash in Hand function
$cashinhand = getCashInHand($db, $from, $to);

// Capital amount 
$Ledger = 'CP001'; 
$Capital_Amount = getLastBalance($db, $Ledger, $from, $to);

// Ex Function 
$trialBalanceEx = ExpenseTotal($db, $from, $to);
$totalDebitEx = $trialBalanceEx['totalDebit'];
$totalCreditEx = $trialBalanceEx['totalCredit'];  
// End Function 

// Staff Salary Function 
$trialBalancestaff = StaffSalary($db, $from, $to);
$totalDebitstaff = $trialBalancestaff['totalDebit'];
$totalCreditstaff = $trialBalancestaff['totalCredit'];

// Receivable & Payable Function 
$trialBalanceRePay = RePayParty($db, $from, $to);
$totalCreditRePay = $trialBalanceRePay['totalCredit'];
$totalDebitRePay = $trialBalanceRePay['totalDebit'];

$trialBalanceRePayMills = RePayMills($db, $from, $to);
$totalCreditRePayMills = $trialBalanceRePayMills['totalCredit'];
$totalDebitRePayMills = $trialBalanceRePayMills['totalDebit'];

?>

<div class='dashboard'>
    <?php include('inc/sales_side_bar.php'); ?>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar'>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>  
        <div class='dashboard-content'>
            <div class='container'>
                <div class='card'>
                    <div class='card-header'></div>
                    <div class='card-body' style="min-height:600px;">
                        <div style="width: 600px; border: 1px solid #eee; margin:0px auto;">
                            <div class="row align-items-start">
                                <div class="col-md-12 text-center" style="padding-top:30px;">  
                                    <h2 style="font-weight:bold;">M/S. Ratan Enterprise</h2>
                                    <h5>Tanbazar, Narayanganj.</h5>
                                    <h4 style="font-weight:bold;">Final Accounts Reports</h4>
                                    <h6 style="font-weight:bold;">Balance Sheet on <?php echo $to; ?></h6>
                                    <table id="# example" class="table-striped table-bordered" style="padding: 30px; width:100%;">
                                        <thead>
                                            <tr class=""> 
                                                <th>Particular</th>
                                                <th> </th> 
                                                <th>Amount</th> 
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <!-- Asset Area --> 
                                            <tr class="bg-success text-white">
                                                <td>Asset </td>
                                                <td></td>  
                                                <td></td>  
                                            </tr> 
                                            <tr>
                                                <td>Bank Balance </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCredit, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>FDRS </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCreditfdr, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Cash In Hand </td>
                                                <td>:</td>  
                                                <td><?php echo $cashinhand; ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Receivable Amount From Party </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCreditRePay, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Receivable Amount From Mills </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCreditRePayMills, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Stock Product </td>
                                                <td>:</td>  
                                                <td>0.00</td>  
                                            </tr> 

                                            <!-- Liabilities Area --> 
                                            <tr class="bg-success text-white">
                                                <td>Liabilities </td>
                                                <td></td>  
                                                <td></td>  
                                            </tr> 
                                            <tr>
                                                <td>Capital Fund</td>
                                                <td>:</td>  
                                                <td><?php echo $Capital_Amount; ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Payable Amount To Party </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalDebitRePay, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Payable Amount To Mills </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalDebitRePayMills, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Bank Loan </td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalDebit, 2); ?></td>  
                                            </tr> 

                                            <!-- Expense Area --> 
                                            <tr class="bg-success text-white">
                                                <td>Expense </td>
                                                <td></td>  
                                                <td></td>  
                                            </tr> 
                                            <tr>
                                                <td>Staff Salary</td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCreditstaff, 2); ?></td>  
                                            </tr>
                                            <tr>
                                                <td>Office, Flat, Telephone Bill <br> Electric Bill, Car, Land etc.</td>
                                                <td>:</td>  
                                                <td><?php echo number_format($totalCreditEx, 2); ?></td>  
                                            </tr> 
                                        </tbody> 
                                    </table>
                                    <form action="download_pdf.php" method="post" target="_blank">
                                        <input type="hidden" name="from" value="<?php echo $from; ?>">
                                        <input type="hidden" name="to" value="<?php echo $to; ?>">
                                        <button type="submit" name="download" class="btn btn-primary mt-3">Download PDF</button>
                                    </form>
                                </div> 
                            </div>
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
