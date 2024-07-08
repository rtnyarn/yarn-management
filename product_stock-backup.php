<?php 
include('inc/sales_index_header.php');
error_reporting(E_ALL);
?>
<?php 
	if (empty($_GET['id'])){
	}elseif(!isset($_GET['id']) || $_GET['id'] == NULL){
		echo 'Something went to wrong';
	}else{
			$tid= $_GET['id'];
			$id= preg_replace("/[^0-9a-zA-Z]/", "", $tid);
			$rid = $id;
	}
 
?>
<div class='dashboard'>    
    
    <?php  include('inc/sales_side_bar.php'); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class='dashboard-app'>
        <header class='dashboard-toolbar  '>   
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a> 
        </header> 
         
        
        <div class='dashboard-content'>
            <div class='container'>
                <div class='card'>
                    <div class='card-header'>
                        <h4> Stock Reports</h4>
                    </div>
                    <div class='card-body ' style="min-height:600px;">
                        
                    <div class="row align-items-start" > 
						<div class="col-md-12 text-center">
						
							 
							<table class=" table-striped table-bordered" style="width:100%; font-size: 18px;">
							  
							  
							  
							  
							  
							
								<thead>
							<!-- Test -->
									<tr class="bg-light">
										<th>S.L No</th> 
                                        <th width="250px;">Name</th>
                                        <th width="250px;">Godown No</th>  
										<th>Stock </th>                                      
										<th>Total</th>  
										<th>Action </th>   
									</tr>
								</thead>
								<tbody>
								
								
		<?php
$queryCat = "SELECT * FROM product_catagory";
$resultsCat = $db->select($queryCat);

if ($resultsCat) {
    while ($CatRes = $resultsCat->fetch_assoc()) {
        $CatId = $CatRes['id'];
?>
        <tr class="bg-success text-white">
            <td colspan="9" style="font-weight:bold; font-size: 24px">
                <?php echo $CatRes['name']; ?>
            </td>
        </tr>

    <?php
        $query1 = "SELECT DISTINCT sub_cat_id 
                   FROM stock_product 
                   WHERE catogry_id = '$CatId' 
                     AND stock_quantity IS NOT NULL";

        $results1 = $db->select($query1);

        if ($results1) {
            while ($subCatRes = $results1->fetch_assoc()) {
                $subCatId = $subCatRes['sub_cat_id'];

                // Calculate total stock quantity for sub_cat_id
                $totalStockQuery = "SELECT SUM(stock_quantity) AS total_stock 
                                    FROM stock_product 
                                    WHERE catogry_id = '$CatId' 
                                      AND sub_cat_id = '$subCatId' 
                                      AND stock_quantity IS NOT NULL";

                $totalStockResult = $db->select($totalStockQuery);
                $totalStock = $totalStockResult->fetch_assoc()['total_stock'];

                // Count occurrences of sub_cat_id
                $countQuery = "SELECT COUNT(*) AS count 
                               FROM stock_product 
                               WHERE catogry_id = '$CatId' 
                                 AND sub_cat_id = '$subCatId' 
                                 AND stock_quantity IS NOT NULL";

                $countResult = $db->select($countQuery);
                $rowCount = $countResult->fetch_assoc()['count'];

                // Fetch and display data for the first row
                $firstRowQuery = "SELECT * 
                                  FROM stock_product 
                                  WHERE catogry_id = '$CatId' 
                                    AND sub_cat_id = '$subCatId' 
                                    AND stock_quantity IS NOT NULL 
                                  ORDER BY sub_cat_id ASC, CAST(stock_quantity AS SIGNED)
                                  LIMIT 1";

                $firstRowResult = $db->select($firstRowQuery);
                $firstRow = $firstRowResult->fetch_assoc();
    ?>
                <tr>
                    <td><?php echo $firstRow['id']; ?></td>
                    <td style="text-align:left;">
                        <?php
                        $product_code = $firstRow['product_code'];
                        $product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];
                        echo $product_coderes;
                        ?>
                    </td>
                    <!-- Add other columns here -->
                    
                    <td><?php
						$location = $firstRow['location'];
						$locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];
						echo $locationres;
					?></td>
                    <td><?php echo $firstRow['stock_quantity'];   ?></td>
					<td class="font-weight-bold" rowspan="<?php echo $rowCount; ?>">
                        <?php echo $totalStock; // Display total stock ?>
                    </td>
                    <td class="font-weight-bold">
                        <a href="product_stock_details.php?id='<?php echo $firstRow['product_code']; ?>'" class="btn btn-info btn-sm"> History </a>
                    </td>
                </tr>

                <?php
                // Fetch and display data for the remaining rows
                $remainingRowsQuery = "SELECT * 
                                       FROM stock_product 
                                       WHERE catogry_id = '$CatId' 
                                         AND sub_cat_id = '$subCatId' 
                                         AND stock_quantity IS NOT NULL 
                                       ORDER BY sub_cat_id ASC, CAST(stock_quantity AS SIGNED)
                                       LIMIT 1, " . ($rowCount - 1);

                $remainingRowsResult = $db->select($remainingRowsQuery);

                while ($rs = $remainingRowsResult->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $rs['id']; ?></td>
                        <td style="text-align:left;">
                            <?php
                            $product_code = $rs['product_code'];
                            $product_coderes = $db->select("SELECT * FROM product_table where product_code='$product_code'")->fetch_assoc()['product_name'];
                            echo $product_coderes;
                            ?>
                        </td>
                         <td><?php 
						 
						 $location = $rs['location'];
						$locationres = $db->select("SELECT * FROM product_location where id='$location'")->fetch_assoc()['name'];
						echo $locationres;
						 ?></td>
						 <td><?php echo $rs['stock_quantity']; ?></td>
                        <td class="font-weight-bold">
                            <a href="product_stock_details.php?id='<?php echo $rs['product_code']; ?>'" class="btn btn-info btn-sm"> History </a>
                        </td>
                    </tr>
                <?php
                }
            }
        } else {
                ?>
            <div class="bg-danger">
                <p style='text-align:center;'>No Data Found!</p>
            </div>
    <?php
        }
    }
}
?>




								</tbody>   
							
							
                            </table>
							
						</div>
 
                    </div>
                </div>
            </div>
        </div>
		
    </div>
</div>

 
 	<script type="text/javascript">
		function getId(str) { 
		  var xhttp = new XMLHttpRequest();
		  var xhttp1 = new XMLHttpRequest();
		  
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {		
			 document.getElementById("sub_cat").innerHTML = this.responseText;
			
			}
		  }; 
		  xhttp.open("GET", "get_sub.php?id="+str, true);
		  xhttp.send();	 
		 
		}  
	 </script>


<?php 
include('inc/footer.php'); 
?>

