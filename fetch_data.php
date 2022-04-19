<?php

//fetch_data.php
include('includes/connection.php');
if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM products WHERE product_id IS NOT NULL 
	";
	
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		  AND product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["category"]))
	{
		$category_filter = implode("','", $_POST["category"]);
		$query .= "
		 AND cat_id IN('".$category_filter."')
		";
	}
	if(isset($_POST["manufacturer"]))
	{
		$manufacturer_filter = implode("','", $_POST["manufacturer"]);
		$query .= "
		 AND manufacturer_id IN('".$manufacturer_filter."')
		";
	}
	
	$result=mysqli_query($con,$query);
            
	$total_row = mysqli_num_rows($result);
	$output = '';
	if($total_row)
	{
        while($row = mysqli_fetch_array($result))
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; ">
					<img src="images/products/'. $row['product_img'] .'" style="height:150px"  class="img-responsive" >
					<p align="center"><strong><a href="'.$row['product_url'].'">'. $row['product_title'] .'</a></strong></p>
					<h4 style="text-align:center;" class="text-danger" >'. $row['product_price'] .'</h4>
				</div>
			</div>
			';
		}
	}
	else
	{
		$output = '<h3>Pas de produits trouvés</h3>';
	}
	echo $output;
}

?>