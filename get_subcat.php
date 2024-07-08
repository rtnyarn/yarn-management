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
		 $sub_cat_id= $show['sub_cat_id'];
		  // Fetch category name based on category ID
		$subcategoryQuery = "SELECT sub_cat_name FROM sub_catagory WHERE id = '$sub_cat_id'";
		$subcategoryResult = $db->select($subcategoryQuery);
		$subcategory = ($subcategoryResult->num_rows > 0) ? $subcategoryResult->fetch_assoc()['sub_cat_name'] : '';
		
		 ?>
		 <option value="<?php echo $show['sub_cat_id']; ?>" selected> <?php echo $subcategory  ?> </option> 
		<?php 
		 
		}
	} 
}
?> 
		