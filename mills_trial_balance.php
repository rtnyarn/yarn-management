<?php
include('inc/sales_index_header.php');
error_reporting(0);
  
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
                    <div class='card-header'>
                        <h4>M/S. Raten Enterprise</h4>
                        <h5>Tanbazar, Narayanganj.</h5>
                        <h5>All Mills Trial Balance</h5>
                    </div>

                    <div class='card-body' style="min-height:600px;">

                        <div class="row align-items-start">
                            <div class="col-md-12">

                                <table id="# example" class=" table-striped table-bordered"
                                    style="width:100%; font-weight:bold; ">

                                    <tr>
                                        <td class="text-white bg-info">Upto </td>
                                        <td style="font-weight:bold;"><?php echo date('Y-m-d') ?></td>

                                    </tr>
                                </table>
                                <br>
                                <table id="# example" class="table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr class="text-white bg-info">
                                            <th>S.L</th>
                                            <th>Acount No</th>
                                            <th>Name</th>
                                            <th>Opening</th>
                                            <th>Recive/Debit</th>
                                            <th>Credit/Payment</th>
                                            <th>Balance</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr class=" bg-warning" style="text-align:right; font-weight:bold; ">
                                        </tr>

                                        <?php
                                        $previousDay = date('Y-m-d', strtotime($from . ' - 1 day'));
										$dateFrom= date('Y-m-d');
                                        // Opening balance query
                                        $ledgerOpeningBalanceQuery = "SELECT c.ac, 
										CONCAT(SUM((COALESCE(t.expense_amount, 0) - COALESCE(t.recive_amount, 0) + COALESCE(t.op_balance, 0)))) 
										AS opening_balance FROM customers c LEFT JOIN daily_transection t ON c.ac = t.lederid
										WHERE t.date <= '$previousDay' OR t.date IS NULL
										GROUP BY c.ac";


                                        $openingBalancesResult = $db->select($ledgerOpeningBalanceQuery);
                                        $openingBalances = [];
                                        while ($row = $openingBalancesResult->fetch_assoc()) {
                                            $openingBalances[$row['ac']] = $row['opening_balance'];
                                        }

                                        // Main query 
										$query = "SELECT c.ac, c.first_name, c.last_name, 
												  SUM(CASE WHEN t.recive_amount > t.expense_amount THEN t.recive_amount ELSE 0 END) AS total_recive,
												  SUM(CASE WHEN t.recive_amount <= t.expense_amount THEN t.expense_amount ELSE 0 END) AS total_expense
												  FROM customers c
												  LEFT JOIN (
													  SELECT lederid, recive_amount, expense_amount
													  FROM daily_transection
													  WHERE date BETWEEN '$dateFrom' AND '$dateFrom' OR date IS NULL
												  ) t ON c.ac = t.lederid
												  WHERE c.ac_type = '8'  -- Filter based on ac_type
												  GROUP BY c.ac, c.first_name, c.last_name";




                                        $results = $db->select($query);
                                        $id = 0;
                                        if ($results) {
                                            while ($rs = $results->fetch_assoc()) {
                                                $openingBalance = isset($openingBalances[$rs['ac']]) ? $openingBalances[$rs['ac']] : 0;
                                                $netBalance = $rs['total_expense'] - $rs['total_recive'] + $openingBalance;
                                                $id++;
                                        ?>
                                        <tr>
                                            <td><?php echo $id; ?> </td>
                                            <td><?php echo $rs['ac']; ?> </td>
                                            <td><?php echo $rs['first_name'] . ' ' . $rs['last_name']; ?> </td>
                                            <td><?php echo number_format($openingBalance, 2); ?> </td>
                                            <td><?php echo number_format($rs['total_recive'], 2); ?> </td>
                                            <td><?php echo number_format($rs['total_expense'], 2); ?> </td>
                                            <td><?php echo number_format($netBalance, 2); ?> </td>
											<td>
											<form action="ledger.php" method="post"> 
												<input type="hidden" class="form-control" name="ledger" value="<?php echo $rs['ac']; ?>">   
												<input type="hidden" class="form-control" name="from" value="2024-01-01">   
												<input type="hidden" class="form-control" name="to" value="<?php echo date('Y-m-d'); ?>"> 
												<button type="submit" name="submit" class="btn btn-warning btn-sm main_btn"> View </button>
											</form>  
											</td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            foreach ($openingBalances as $ac => $openingBalance) {
                                                $id++;
                                        ?>
                                        <tr>
                                            <td><?php echo $id; ?> </td>
                                            <td><?php echo $ac; ?> </td>
                                            <td>
                                                <?php
                                                    $query = "SELECT * from customers where ac='$ac' ";
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
