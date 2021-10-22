<?php
// Price Column
require_once 'PriceColumn.php';

//  ProductID column
add_filter( 'woocommerce_admin_order_preview_line_item_column_productid', function( $result, $_item , $item_id ) {
	return esc_html($item_id) ;
}, 10, 3 );
//  Total column
add_filter( 'woocommerce_admin_order_preview_line_item_column_'.sanitize_key('total-price'), function( $result, $_item , $item_id, $order) {
    $price = '';
    if($_item['quantity'] > 1){$price = strip_tags(wc_price($_item['total']/$_item['quantity'], array( 'currency' => $order->get_currency() ) ));}
	return ' <div title="'.$price.'">'. wc_price( $_item['total'], array( 'currency' => $order->get_currency() ) ).'</div>' ;
}, 10, 4 );

//  Category column
add_filter( 'woocommerce_admin_order_preview_line_item_column_category', function ( $result, $_item ) {
	return wc_get_product_category_list($_item['product_id'] );
}, 10, 2 );

//image culomn
add_filter( 'woocommerce_admin_order_preview_line_item_column_image', function ( $result, $_item ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_item['product_id'] ), 'thumbnail' );
    $image_full = wp_get_attachment_image_src( get_post_thumbnail_id( $_item['product_id'] ), 'single-post-thumbnail' );
	$result = '<a target="_blank" href="'.$image_full[0].'"><img style="width: 100px;" src=" '. $image[0] .'" data-id=" '.  $_item['product_id']  .' "></a>';
	return $result;
}, 10,2 );

// stock column
    add_filter( 'woocommerce_admin_order_preview_line_item_column_stock',function() {
        return OSPO_premiumHTML;
    }, 10);
//  Vendor column
add_filter( 'woocommerce_admin_order_preview_line_item_column_vendor', function ( $result, $_item ) {
    if(class_exists( 'WeDevs_Dokan' )){
        $sub_orders = get_children( array( 'post_parent' =>   $_item['order_id'], 'post_type' => 'shop_order' ) );
      //  return json_encode ( $sub_orders);
        // if order not have suborders
        if ( empty($sub_orders) ){
        
            $vendor_id = dokan_get_seller_id_by_order( $_item['order_id'] );
            $vendor_data = get_user_meta( $vendor_id );
            return $vendor_data["first_name"][0]." ".$vendor_data["last_name"][0];
            
        }//if order has suborders
        else {
            foreach ($sub_orders as $sub) {
                $order = new WC_Order( $sub->ID );
	    	
	    		//get the order items
	    		$order_items = $order->get_items();
	    		foreach( $order_items as $order_item ) {
                    if($order_item['product_id'] == $_item['product_id']){
                        $vendor_id = dokan_get_seller_id_by_order( $sub->ID );
                        $vendor_data = get_user_meta( $vendor_id );
                        return $vendor_data["first_name"][0]." ".$vendor_data["last_name"][0];
                    }
                }
            }
            
        }
    
    }
}, 10, 2 );
