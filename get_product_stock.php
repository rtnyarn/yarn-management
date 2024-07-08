<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");
$db = new Database();
$fm = new Formate();
if(isset($_GET["id"])){
?>  		
<?php
$query ="SELECT * FROM product_table WHERE product_code='".$_GET["id"]."'";	
		$results =$db->select($query);
			if ($results){ while ($sho= $results->fetch_assoc()) {
				?>
				<option value="<?php echo $sho['unite_price']; ?>" selected><?php echo $sho['unite_price']; ?></option>
				 
				<?php 
				 
			}
		}
}
?> 
		