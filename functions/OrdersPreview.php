<?php
/**
 * return woocommerce order preview custom columns.
 */
add_filter( 'woocommerce_admin_order_preview_line_item_columns',function( $_columns ) {
	//set Columns name
	$ProductID = [ 'ProductID' => esc_html__( 'ID','woocommerce') ];
	$Image = [ 'image' => esc_html__( 'Image') ];
 	$Category = [ 'category' => esc_html__( 'Category','woocommerce') ];
 	$Product = [ 'product' => esc_html__( 'Product','woocommerce') ];
	$Stock = [ 'stock' => esc_html__( 'Stock','woocommerce') ];
	$Quantity = [ 'quantity' => esc_html__( 'Quantity','woocommerce') ];
	$Total = [ 'total-price' => esc_html__( 'Total','woocommerce') ];
	$Price = [ 'Price' => esc_html__( 'Price','woocommerce') ];
	$Vendor = [ 'vendor' => esc_html__( 'Vendor','dokan-lite') ];
	$tax = [ 'tax' => esc_html__( 'Tax','dokan-lite') ];
//	$items  = count( $_columns );
	$OrderPro_Column = get_option('OrderPro_Column'); //get custom culomns
	if(empty($OrderPro_Column)) //if the custom columns are not set.
		return $_columns;//return defult culomns.
	$columns = array();
	foreach($OrderPro_Column as $column => $value)	//create custom columns array
	{
	    if($value == "true")	//if column is set from setings
	    {
	        $columns = array_merge($columns, ${$column});	//add column to array
	    }
	}
	return $columns ;
});

 require_once 'OrdersPreview/columns.php';
 
