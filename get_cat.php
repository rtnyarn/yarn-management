<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");
$db = new Database();
$fm = new Formate();
if(isset($_GET["product_code"])){
?>  		

<?php
$query ="SELECT * FROM product_table WHERE product_code='".$_GET["product_code"]."'";	
$results =$db->select($query);
	if ($results){ while ($show= $results->fetch_assoc()) {
		?>  
		 <?php 
		 $cat_id= $show['product_cat_id'];
		  // Fetch category name based on category ID
		$categoryQuery = "SELECT name FROM product_catagory WHERE id = '$cat_id'";
		$categoryResult = $db->select($categoryQuery);
		$category = ($categoryResult->num_rows > 0) ? $categoryResult->fetch_assoc()['name'] : '';
		
		 ?>
		 <option value="<?php echo $show['product_cat_id']; ?>" selected> <?php echo $category  ?> </option> 
		<?php 
		 
		}
	} 
}
?> 
		