<?php
include('inc/sales_index_header.php');
error_reporting(0);
  
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
                    <div class='card-header'>
                        <h4>M/S. Raten Enterprise</h4>
                        <h5>Tanbazar, Narayanganj.</h5>
                        <h5>All Mills Trial Balance</h5>
                    </div>

                    <div class='card-body' style="min-height:600px;">

                        <div class="row align-items-start">
                            <div class="col-md-12">

                                <table id="example" class="table-striped table-bordered" style="width:100%; font-weight:bold; ">

                                    <tr>
                                        <td class="text-white bg-info">Upto </td>
                                        <td style="font-weight:bold;"><?php echo date('Y-m-d') ?></td>

                                    </tr>
                                </table>
                                <br>
                                <table id="example" class="table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="text-white bg-info">
                                            <th>S.L</th>
                                            <th>Product Code</th>
                                            <th>Name</th>
                                            <th>Opening</th>
                                            <th>Import</th>
                                            <th>Sales</th>
                                            <th>Balance</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr class="bg-warning" style="text-align:right; font-weight:bold; ">
                                        </tr>

                                        <?php
                                        $previousDay = date('Y-m-d', strtotime($from . ' - 1 day'));
										$dateFrom= date('Y-m-d');
                                        // Opening balance query
                                        $productOp = "SELECT s.product_code, 
																	   CONCAT(SUM(COALESCE(t.quntity, 0))) AS opening_balance 
																		FROM stock_product s 
																		LEFT JOIN product_transection t ON s.product_code = t.product_code
																		WHERE t.create_date <= '$previousDay' OR t.create_date IS NULL
																		GROUP BY s.product_code
																		";


                                        $resOP = $db->select($productOp);
                                        $openingBalances = [];
                                        while ($row = $resOP->fetch_assoc()) {
                                            $openingBalances[$row['product_code']] = $row['opening_balance'];
                                        }

                                       // Main query 
									$query = "SELECT 
												s.product_code,
												SUM(CASE WHEN t.trans_type = 'Sales' THEN t.quntity ELSE 0 END) AS sales,
												SUM(CASE WHEN t.trans_type = 'Purchase' THEN t.quntity ELSE 0 END) AS import
											  FROM stock_product s
											  LEFT JOIN (
												  SELECT product_code, quntity, trans_type
												  FROM product_transection
												  WHERE create_date BETWEEN '$dateFrom' AND '$dateFrom' OR create_date IS NULL
											  ) t ON s.product_code = t.product_code
											  GROUP BY s.product_code"; 


                                        $results = $db->select($query);
                                        $id = 0;
                                        if ($results) {
                                            while ($rs = $results->fetch_assoc()) {
                                                $openingBalance = isset($openingBalances[$rs['product_code']]) ? $openingBalances[$rs['product_code']] : 0;
                                                $netBalance = $rs['sales'] - $rs['import'] + $openingBalance;
                                                $id++;
                                        ?>
                                        <tr>
                                            <td><?php echo $id; ?> </td>
                                            <td><?php echo $rs['product_code']; ?></td>
                                            <td><?php echo $rs['product_code']; ?></td>
                                            <td><?php echo number_format($openingBalance, 2); ?> </td>
                                            <td><?php echo number_format($rs['sales'], 2); ?> </td>
                                            <td><?php echo number_format($rs['import'], 2); ?> </td>
                                            <td><?php echo number_format($netBalance, 2); ?> </td>
											<td>
											<form action="ledger.php" method="post"> 
												<input type="hidden" class="form-control" name="ledger" value="<?php echo $rs['product_code']; ?>">   
												<input type="hidden" class="form-control" name="from" value="2024-01-01">   
												<input type="hidden" class="form-control" name="to" value="<?php echo date('Y-m-d'); ?>"> 
												<button type="submit" name="submit" class="btn btn-warning btn-sm main_btn"> View </button>
											</form>  
											</td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            foreach ($openingBalances as $product_code => $openingBalance) {
                                                $id++;
                                        ?>
                                        <tr>
                                            <td><?php echo $id; ?> </td>
                                            <td><?php echo $product_code; ?> </td>
                                            <td>
                                                <?php
                                                    $query = "SELECT * from customers where product_code='$product_code' ";
                                                    $results = $db->select($query);
                                                    if ($results) {
                                                        while ($rs = $results->fetch_assoc()) {
                                                            echo $rs['first_name'] . ' ' . $rs['last_name'];
                                                        }
                                                    }
                                                ?> </td>
                                            <td><?php echo number_format($openingBalance, 2); ?> </td>
                                            <td><?php echo "0.00"; ?> </td>
                                            <td><?php echo "0.00"; ?> </td>
                                            <td><?php echo number_format($openingBalance, 2); ?> </td>
                                             
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>


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
</div>

<?php
include('inc/footer.php');
?>
