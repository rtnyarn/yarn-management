<?php
include('inc/sales_index_header.php');
 

if (isset($_POST['submit'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
} else {
    echo "No Data Found";
}

?>

<div class='dashboard'>

    <?php include('inc/sales_side_bar.php'); ?>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
        </header>


        <div class='dashboard-content'>
            <div class='container'>
                <div class='card'> 
                    <div class='card-body' style="min-height:600px;">

                         <?php
							if(isset($_POST['submit'])){
								$from 	=$_POST['from']; 
								$to	 	=$_POST['to'];  
								
								class PDF extends FPDF {  
									private $totalBalance = 0; // Variable to store the total balance for the page
									
									function Footer() {   
										$this->SetY(-15); // Positioning at 15 mm from the bottom
										$this->SetFont('Arial','B',12); // Setting font
										// Adding footer content
										$this->Cell(270,5,'Total Balance: '.number_format($this->totalBalance, 2), 0, 1, 'R'); // Display total balance for the page
										$this->SetFont('Arial','I',7); // Setting font
										$this->Cell(130,2,'-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'L'); 
										$this->Cell(150,5,'Software Developed By: Ibrahim Ali ',0,0,'L'); 
										$this->Cell(50,5,'| Printing Date: '.date("Y-m-d h:i:sa") ,0,0,'R');
										$this->Cell(68,5,'Page '.$this->PageNo().'/{nb}',0,1,'R'); 
										
									}
									
									function AddBalance($balance) {
										$this->totalBalance += $balance; // Add balance to the total balance for the page
									}
								}

								// Create an instance of your PDF class
								$pdf = new PDF('L','mm','A4');

								// Add page and set up page numbering
								$pdf->AliasNbPages();
								$pdf->AddPage();

								// Now you can continue adding content to your PDF

								
						
								//park name Setting park head
								$comquery ="SELECT * FROM `company_info`";
								
								$com_res=$db->select($comquery);			
								if ($com_res==true){
									while($company=$com_res->fetch_assoc()){  
										 
										$pdf->SetFont('Arial','B',18);				
										$pdf->Cell(135,10,'');
										$pdf->Cell(15,10,$company['company_name_first_part'].' '.$company['comapnay_name_last_part'],0,0,'C');			
										$pdf->Cell(15,10,'',0,1,'L',false);
										$pdf->Cell(135,6,'');
										$pdf->SetFont('Arial','',10);	
										$pdf->Cell(15,6,$company['address'],0,0,'C');			
										$pdf->Cell(15,10,'',0,1,'L',false);
									}
								}
											
								//End pad head 
								 
								
								$pdf->SetFont('Arial','B',14);
								$pdf->Cell(135,10,'');
								$pdf->Cell(15,10,'Trial Balance',0,0,'C');			
								$pdf->Cell(15,10,'',0,1,'L',false);
								
								$pdf->SetFont('Arial','B',12);
								$pdf->Cell(2,10,'');
								$pdf->Cell(20,10,'Period :');
								$pdf->Cell(25,10,$_POST['from']);
								$pdf->Cell(20,10,'Up To:',0,0,'C',);
								$pdf->Cell(15,10,$_POST['to'],0,1,'L',false);
								
								//header Table 
								$pdf->SetFont('Arial','B',9);
								$pdf->SetFillColor(230,230,230);
								$pdf->SetTextColor(0,0,0);
								$pdf->Cell(2, 5,'',0,0);//left margin
								$pdf->Cell(13	,6,'S.L',1,0,'C',true); 
								$pdf->Cell(70	,6,'Particular',1,0,'C',true); 
								$pdf->Cell(30	,6,'Amount',1,0,'C',true);			
								$pdf->Cell(2	,6,' ',1,0,'C',true);
								$pdf->Cell(13	,6,'S.L',1,0,'C',true); 
								$pdf->Cell(80	,6,'Particular',1,0,'C',true); 
								$pdf->Cell(30	,6,'Debit',1,0,'C',true);									
								$pdf->Cell(30	,6,'Credit',1,1,'C',true);
							 		
								
								//table Body 
							 
								$pdf->SetFont('Arial','', 9);
								$pdf->SetFillColor(255,255,255);
								$pdf->SetTextColor(0,0,0);
							
								$righquery = "SELECT 
									c.ac AS ac, 
									c.first_name AS f_name, 
									c.last_name AS l_name, 
									SUM(dt.op_balance) AS opening,
									SUM(dt.recive_amount) AS Total_Received_Amount,
									SUM(dt.expense_amount) AS Total_Expense_Amount
								FROM 
									customers c 
								LEFT JOIN 
									daily_transection dt ON c.ac = dt.lederid
								WHERE 
									dt.date <= '$to'  -- Adjust the date as needed
								GROUP BY 
									c.ac"; 

								$rightresults = $db->select($righquery);
								$id = 0;
								// Loop through all ledger accounts
								while ($ledger = $rightresults->fetch_assoc()) {												
								$id++; 
								$opbalance	=$ledger['opening']; 
								$recive		=$ledger['Total_Received_Amount']; 
								$expense	=$ledger['Total_Expense_Amount'];  
								$Balance	=$expense-$recive; 
								$grand_total =$Balance+$opbalance; 
								
								//Left Side 
								$pdf->Cell(2	,6,'',0,0);//left margin
								$pdf->Cell(13	,6,$id,1,0,'C',true); 
								$pdf->Cell(70	,6,'',1,0,'C',true); 
								$pdf->Cell(30	,6,'',1,0,'C',true);	

								//right Side 
								$pdf->Cell(2	,6,' ',1,0,'C',true); 
								
								$pdf->Cell(13	,6,$id,1,0,'C',true);
								
								$pdf->Cell(80	,6,$ledger['ac'].'-'.$ledger['f_name'].' '.$ledger['l_name'],1,0,'L',true);	
								
								
								if($grand_total<0){
									$pdf->Cell(30	,6,number_format($grand_total,2),1,0,'R',true);
								}else{
									$pdf->Cell(30	,6,'0.00',1,0,'R',true);
								}
								
								if($grand_total>0){
									$pdf->Cell(30	,6,number_format($grand_total,2),1,1,'R',true);
								}else{
									$pdf->Cell(30	,6,'0.00',1,1,'R',true);
								}
							 
							 
							 
								// Update total balance for the page
								$pdf->AddBalance($grand_total);
								
								
								}
								// Output PDF data as a string
								$pdf_data = $pdf->Output('S');
								
								// Display PDF data inside an <iframe>
								echo '<iframe src="data:application/pdf;base64,'.base64_encode($pdf_data).'" width="100%" height="700px"></iframe>';
							}
						?>

                            
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include('inc/footer.php');
?>
