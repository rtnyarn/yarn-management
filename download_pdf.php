
<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");
include("lib/function.php");
$db = new Database();
$fm = new Formate();
?> 
<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
if (isset($_POST['download'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    // Assume the functions are already defined and accessible here
    // Fetch data again as it will be used in the PDF generation
    $trialBalance = BankTotal($db, $from, $to);
    $totalDebit = $trialBalance['totalDebit'];
    $totalCredit = $trialBalance['totalCredit'];
    $trialfdr = fdrs($db, $from, $to);
    $totalDebitfdr = $trialfdr['totalDebit'];
    $totalCreditfdr = $trialfdr['totalCredit'];
    $cashinhand = getCashInHand($db, $from, $to);
    $Ledger = 'CP001';
    $Capital_Amount = getLastBalance($db, $Ledger, $from, $to);
    $trialBalanceEx = ExpenseTotal($db, $from, $to);
    $totalDebitEx = $trialBalanceEx['totalDebit'];
    $totalCreditEx = $trialBalanceEx['totalCredit'];
    $trialBalancestaff = StaffSalary($db, $from, $to);
    $totalDebitstaff = $trialBalancestaff['totalDebit'];
    $totalCreditstaff = $trialBalancestaff['totalCredit'];
    $trialBalanceRePay = RePayParty($db, $from, $to);
    $totalCreditRePay = $trialBalanceRePay['totalCredit'];
    $totalDebitRePay = $trialBalanceRePay['totalDebit'];
    $trialBalanceRePayMills = RePayMills($db, $from, $to);
    $totalCreditRePayMills = $trialBalanceRePayMills['totalCredit'];
    $totalDebitRePayMills = $trialBalanceRePayMills['totalDebit'];

    // HTML content for the PDF
    $html = '
	<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Balance Sheet</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            /* Custom CSS if needed */
        </style>
    </head>
    <body>
    <h2 style="text-align:center; font-weight:bold;">M/S. Ratan Enterprise</h2>
    <h5 style="text-align:center;">Tanbazar, Narayanganj.</h5>
    <h4 style="text-align:center; font-weight:bold;">Final Accounts Reports</h4>
    <h6 style="text-align:center; font-weight:bold;">Balance Sheet on ' . $to . '</h6>
    <table border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr> 
                <th>Particular</th>
                <th></th> 
                <th>Amount</th> 
            </tr>
        </thead>
        <tbody>  
            <tr style="background-color: #28a745; color: white;">
                <td>Asset</td>
                <td></td>  
                <td></td>  
            </tr> 
            <tr>
                <td>Bank Balance</td>
                <td>:</td>  
                <td>' . number_format($totalCredit, 2) . '</td>  
            </tr>
            <tr>
                <td>FDRS</td>
                <td>:</td>  
                <td>' . number_format($totalCreditfdr, 2) . '</td>  
            </tr>
            <tr>
                <td>Cash In Hand</td>
                <td>:</td>  
                <td>' . $cashinhand . '</td>  
            </tr>
            <tr>
                <td>Receivable Amount From Party</td>
                <td>:</td>  
                <td>' . number_format($totalCreditRePay, 2) . '</td>  
            </tr>
            <tr>
                <td>Receivable Amount From Mills</td>
                <td>:</td>  
                <td>' . number_format($totalCreditRePayMills, 2) . '</td>  
            </tr>
            <tr>
                <td>Stock Product</td>
                <td>:</td>  
                <td>0.00</td>  
            </tr>
            <tr style="background-color: #28a745; color: white;">
                <td>Liabilities</td>
                <td></td>  
                <td></td>  
            </tr> 
            <tr>
                <td>Capital Fund</td>
                <td>:</td>  
                <td>' . $Capital_Amount . '</td>  
            </tr>
            <tr>
                <td>Payable Amount To Party</td>
                <td>:</td>  
                <td>' . number_format($totalDebitRePay, 2) . '</td>  
            </tr>
            <tr>
                <td>Payable Amount To Mills</td>
                <td>:</td>  
                <td>' . number_format($totalDebitRePayMills, 2) . '</td>  
            </tr>
            <tr>
                <td>Bank Loan</td>
                <td>:</td>  
                <td>' . number_format($totalDebit, 2) . '</td>  
            </tr>
            <tr style="background-color: #28a745; color: white;">
                <td>Expense</td>
                <td></td>  
                <td></td>  
            </tr> 
            <tr>
                <td>Staff Salary</td>
                <td>:</td>  
                <td>' . number_format($totalCreditstaff, 2) . '</td>  
            </tr>
            <tr>
                <td>Office, Flat, Telephone Bill <br> Electric Bill, Car, Land etc.</td>
                <td>:</td>  
                <td>' . number_format($totalCreditEx, 2) . '</td>  
            </tr>
        </tbody> 
    </table>   
	</body>
    </html>';

    // Instantiate Dompdf with options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);

    // Load HTML to Dompdf
    $dompdf->loadHtml($html);

    // (Optional) Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF (1 = download and 0 = preview)
    $dompdf->stream("Balance_Sheet_$to", array("Attachment" => 1));
}
?>