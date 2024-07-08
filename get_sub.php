<?php
include("lib/config.php");
include("lib/database.php");
include("lib/helper.php");
$db = new Database();
$fm = new Formate();
if(isset($_GET["id"])){
?>  		

<option value="" Selected>Selected Product</option> 
<?php
$query ="SELECT * FROM sub_catagory WHERE main_cat_id='".$_GET["id"]."'";	
$results =$db->select($query);
	if ($results){ while ($sho= $results->fetch_assoc()) {
		?>  
		 <option value="<?php echo $sho['id']; ?>"><?php echo $sho['sub_cat_name'];?></option> 
		<?php 
		 
		}
	} 
}
?> 
		