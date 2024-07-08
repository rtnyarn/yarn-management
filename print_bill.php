<?php include('inc/sales_index_header.php'); ?>

<div class='dashboard'>

    <?php  include('inc/sales_side_bar.php'); ?>   

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content' ">
            <div class='container'>
                <div class='card'>
                    <div class='card-header text-center'>
					<h6 class="text-left">  Sales Panel || Sales Register || Inovice-<?php echo $value?> <h6>							 
                    </div>
                    <div class='card-body' style="min-height:600px;">
                    <div class="row"> 


							<?php

							function numberTowords($num)
							{

							$ones = array(
							0 =>"Zero",
							1 => "One",
							2 => "Two",
							3 => "Three",
							4 => "Four",
							5 => "Five",
							6 => "Six",
							7 => "Seven",
							8 => "Eight",
							9 => "Nine",
							10 => "Ten",
							11 => "Eleven",
							12 => "Twelve",
							13 => "Thirteen",
							14 => "Fourteen",
							15 => "Fifteen",
							16 => "Sixteen",
							17 => "Seventeen",
							18 => "Eighteen",
							19 => "Nineteen",
							"014" => "Fourteen"
							);
							$tens = array( 
							0 => "Zero",
							1 => "Ten",
							2 => "Twenty",
							3 => "Thirty", 
							4 => "Forty", 
							5 => "Fifty", 
							6 => "Sixty", 
							7 => "Seventy", 
							8 => "Eighty", 
							9 => "Ninety" 
							); 
							$taka='Tk Only';
							$hundreds = array( 
							"Hundred", 
							"Thousand", 
							"Million", 
							"Billion", 
							"Trillion", 
							"Quardrillion"
							); /*limit t quadrillion */
							$num = number_format($num,2,".",","); 
							$num_arr = explode(".",$num); 
							$wholenum = $num_arr[0]; 
							$decnum = $num_arr[1]; 
							$whole_arr = array_reverse(explode(",",$wholenum)); 
							krsort($whole_arr,1); 
							$rettxt = ""; 
							foreach($whole_arr as $key => $i){
								
							while(substr($i,0,1)=="0")
									$i=substr($i,1,5);
							if($i < 20){ 
							/* echo "getting:".$i; */
							$rettxt .= $ones[$i]; 
							}elseif($i < 100){ 
							if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
							if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
							}else{ 
							if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
							if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
							if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 

							} 
							if($key > 0){ 
							$rettxt .= " ".$hundreds[$key]." "; 
							}
							} 
							if($decnum > 0){
							$rettxt .= " and ";
							if($decnum < 20){
							$rettxt .= $ones[$decnum];
							}elseif($decnum < 100){
							$rettxt .= $tens[substr($decnum,0,1)];
							$rettxt .= " ".$ones[substr($decnum,1,1)];
							}
							}
							return $rettxt;
							}
 
						
							$db = new Database();
							$fm = new Formate();

							if (empty($_GET['inv'])){
							}elseif(!isset($_GET['inv']) || $_GET['inv'] == NULL){
								echo 'Something went to wrong';
							}else{
									$tid= $_GET['inv'];
									$id= preg_replace("/[^0-9a-zA-Z]/", "", $tid);
									$rid = $id;
									}
								
								
							class PDF extends FPDF {  
								function Footer() {   
									$this->SetY(-15); // Arial italic 8
									$this->SetFont('Arial','I',7);	// Page number
									$this->Cell(130,2,'---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'L'); 
									$this->Cell(70,5,'Software Developed By: irsoftsolution, +8801916859326',0,0,'L'); 
									$this->Cell(50,5,'Printing Date: '.date("Y-m-d h:i:sa") ,0,0,'R');
									$this->Cell(70,5,'Page '.$this->PageNo().'/{nb}',0,0,'R'); 
								}
							}		
							//A4 width : 219mm
							//default margin : 10mm each side
							//writable horizontal : 219-(10*2)=189mm
							// Define the custom paper size
							//$pdf = new FPDF('P', 'mm', array(80,0)); // Width: 80mm, Height: auto
							$pdf = new FPDF('P','mm','Letter');// for custome page array(100,150)
							$pdf = new pdf();
							$pdf->AliasNbPages();
							$pdf->AddPage();
							//set font to arial, bold, 14pt



							//header information 


							$comquery="SELECT * from company_info";
							$res=$db->select($comquery);
							if($res){
								while($comres=$res->fetch_assoc()){ 
								
								$pdf->Image($comres['logo'],20,10,20,20);

							$pdf->SetFont('Arial','B',20);
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(115	,10,'',0,1,'R'); //end of line  
							$pdf->Cell(88	,7,$comres['company_name_first_part'],0,0,'R'); //end of line  
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(50	,7,$comres['comapnay_name_last_part'],0,1,'L'); //end of line  

							$pdf->SetFont('Arial','',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(45	,10,'',0,0,'C'); //end of line  
							$pdf->Cell(45	,6,$comres['address'],0,1,'C'); //end of line  

							$pdf->SetFont('Arial','',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(45	,5,'',0,0,'L'); //end of line  
							$pdf->Cell(150	,5,$comres['tag'],0,1,'L'); //end of line  
							$pdf->Cell(180	,5,'',0,1,'C'); 

								}
							}

							//end header information 

							//distributor info
							$query1="SELECT * FROM `sales_invoice` where invoice_no=$rid";	 				
							$results1=$db->select($query1);
							
							if ($results1){	
								while($rs1=$results1->fetch_assoc()){
									$year=date('Y');
									$pdf->Cell(10	,7,' ',0,0,'L');
									$pdf->cell(35, 7,'Invoice No: NCL/'.$year.'/',0,0,'L'); 
									$pdf->Cell(105	,7,$rs1['invoice_no'].' ',0,0,'L');
									$pdf->cell( 10, 7,'Date:',0,0,'L');
									$pdf->cell( 30, 7,$rs1['date'],0,1,'L');
							
								}
							}



							//show title 
							$pdf->SetFont('Arial','',20);
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(190	,4,'Bill',0,1,'C');
							$pdf->Cell(190	,3,'------------',0,1,'C');

							$pdf->SetFont('Arial','B',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFillColor(223,240,216);//Head Color 
							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(190	,5,'',0,1,'L'); //end of line  
							$pdf->Cell(10	,7,' ',0,0,'L');

							//distributor info
							$query2="SELECT * FROM `sales_invoice` where invoice_no=$rid";	 				
							$results2=$db->select($query2);
							$id3=0; 
							if ($results2){	
								while($rs2=$results2->fetch_assoc()){
								$id3++;	
									$pdf->cell( 37, 7,'Customer Name',0,0,'L');
									$pdf->cell( 5, 7,':',0,0,'L');
									
										$customer=$rs2['customer_id'];
										
											$cus="SELECT * FROM `customers` where ac='$customer'";	 				
											$disn=$db->select($cus);
											if($disn){
											while($cusres=$disn->fetch_assoc()){ 
											$pdf->Cell(10	,7,$cusres['first_name'].' '.$cusres['last_name'],0,1,'L');
											$pdf->Cell(10	,7,' ',0,0,'L');
											$pdf->cell( 37, 7,'Address',0,0,'L');
											$pdf->cell( 5, 7,':',0,0,'L');
											$pdf->cell( 50, 7,$cusres['Address'],0,1,'L');
											}
										}

									}
							}

							$pdf->Cell(190	,5,'',0,1,'L'); //end of line  


							
							//Table Head
							$pdf->SetFont('Arial','B',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFillColor(211,211,211);//Head Color 
							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(10	,7,'S.L',1,0,'C',true);
							$pdf->Cell(50	,7,'Item Name',1,0,'C',true);
							$pdf->Cell(40	,7,'Quantity',1,0,'C',true);
							$pdf->Cell(40	,7,'Unite Price',1,0,'C',true);
							$pdf->Cell(35	,7,'Total Price',1,1,'C',true);

							//Table Boday 
							$query3="SELECT * FROM `sales_details` where invoice_id=$rid";	 				
							$results3=$db->select($query3);
							$id3=0; 
							if ($results3){	
								while($rs3=$results3->fetch_assoc()){
								$id3++;		 
							$pdf->SetFont('Arial','',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(10	,7,$id3,1,0,'C');
										$prcode=$rs3['product_id'];
										$query4="SELECT * FROM `product_table` where product_code=$prcode";	 				
										$results4=$db->select($query4);
										if ($results4){	
											while($rs4=$results4->fetch_assoc()){
												$pdf->Cell(50	,7,$rs4['product_name'],1,0,'C');
											}
										}

							$pdf->Cell(40	,7,number_format((float)$rs3['quantity'], 2, '.', ','),1,0,'C');
							$pdf->Cell(40	,7,number_format((float)$rs3['price'], 2, '.', ','),1,0,'C');


										$price	=$rs3['price'];
										$qty 	=$rs3['quantity'];
										$total	=$qty*$price;
										
							$pdf->Cell(35	,7,number_format((float)$total, 2, '.', ','),1,1,'C');

								}
							}

							//End Table Boday 

							$pdf->SetFont('Arial','B',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFillColor(255,255,255);//Head Color 


							$totalcal="SELECT * FROM `sales_invoice` where invoice_no=$rid";	 				
							$invres=$db->select($totalcal);

							if ($invres){	
								while($inv=$invres->fetch_assoc()){

							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(140	,7,'Sub Total=',1,0,'R',true);
							$pdf->Cell(35	,7,number_format((float)$inv['sales_subtotal'], 2, '.', ','),1,1,'C',true);

							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(140	,7,' Discount Amount=',1,0,'R',true);
							$pdf->Cell(35	,7,number_format((float)$inv['discount_amount'], 2, '.', ','),1,1,'C',true);

							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(140	,7,'Paid Amount=',1,0,'R',true);
							$pdf->Cell(35	,7,number_format((float)$inv['amount_paid'], 2, '.', ','),1,1,'C',true);

							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(140	,7,'Due Amount=',1,0,'R',true);
							$pdf->Cell(35	,7,number_format((float)$inv['amount_due'], 2, '.', ','),1,1,'C',true);

							$pdf->SetFont('Arial','B',10);
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFillColor(211,211,211);//Head Color 

							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(140	,7,'Grand Total=',1,0,'R',true);
							$pdf->Cell(35	,7,number_format((float)$inv['sales_total'], 2, '.', ','),1,1,'C',true);
								
								$grtotal=$inv['sales_total'];
								$gr=numberTowords($grtotal);
								
							$pdf->Cell(35	,10,'',0,1,'C');
							$pdf->Cell(10	,10,'',0,0,'C');
							$pdf->Cell(20	,10,'In Word:',0,0,'C');
							$pdf->Cell(100	,10,$gr.' Taka Only',0,1,'L');

								}
							}



								
								
							$pdf->Cell(180	,10,'',0,1,'C'); 
							$pdf->Cell(180	,10,'',0,1,'C'); 
							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(20	,4,'------------------------------',0,0,'L');//end of line
							$pdf->Cell(155	,4,'---------------------------',0,1,'R');//end of line
							$pdf->Cell(10	,7,' ',0,0,'L');
							$pdf->Cell(20	,4,'Customer Signature',0,0,'L');//end of line
							$pdf->Cell(152	,4,'Seller Signature',0,0,'R');//end of line


							$filename="Distributore Ledger";
							// Output PDF data as a string
							$pdf_data = $pdf->Output('S');
											
							// Display PDF data inside an <iframe>
							echo '<iframe src="data:application/pdf;base64,'.base64_encode($pdf_data).'" width="100%" height="700px"></iframe>';
							?>			 			  
								
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php'); ?>