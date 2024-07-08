<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");
$db = new Database();
$fm = new Formate();
if(isset($_GET["product_code"])){
?>  		

<?php
$query ="SELECT * FROM stock_product WHERE product_code='".$_GET["product_code"]."'";	
$results =$db->select($query);
	if ($results){ while ($show= $results->fetch_assoc()) {
		?>  
		 <?php 
		 $location_id= $show['location'];
		  // Fetch category name based on category ID
		$subcategoryQuery = "SELECT name FROM product_location WHERE id = '$location_id'";
		$subcategoryResult = $db->select($subcategoryQuery);
		$subcategory = ($subcategoryResult->num_rows > 0) ? $subcategoryResult->fetch_assoc()['name'] : '';
		
		 ?>
		 <option value="<?php echo $show['location']; ?>"> <?php echo $subcategory  ?> </option> 
		<?php 
		 
		}
	} 
}
?> 
		