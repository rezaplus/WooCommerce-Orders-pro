<?php
//  Price column
add_filter( 'woocommerce_admin_order_preview_line_item_column_price',function ( $result, $_item ) {
    $product = wc_get_product($_item['product_id'] );
    if(empty($product)) return;
    $result = '<div onclick=" set_price(this,'.$_item['product_id'].','.sprintf("'%s'",$product->get_name()).','.$product->get_regular_price().','.$product->get_sale_price().') " ><div>'.$product->get_price_html().'</div><img class="op-edit-image" src="'.OrderPro_DIR.'assets/img/edit-button.svg"></div>';
	return $result;
}, 10, 2 );
add_action('wp_ajax_orderPro_Price_new', function()
{       
        $product = wc_get_product(sanitize_text_field($_GET['product']));
        $checkchanges = false;
        
        if($_GET['sale_price'] != $product->get_sale_price()){
            
            $product->set_sale_price(sanitize_text_field($_GET['sale_price']));
            $checkchanges = true;
        }
        if($_GET['regular_price']!= $product->get_regular_price()){
            
            $product->set_regular_price(sanitize_text_field($_GET['regular_price']));
            $checkchanges = true;
        }
        if($checkchanges)
            $product->save();
    
        echo $product->get_price_html();
    wp_die();
}, 10, 2 );