<?php
function OSPO_display_Orderes_products(){
    //set default status
    if(empty($_GET['status'])){$status = 'wc-processing';}else{$status = sanitize_text_field($_GET['status']);}

    // set number of orders  by user
    if(!empty($_GET['order_count_input'])){
        update_option('order_pro_Number_of_orders',(absint($_GET['order_count_input'])));
    }
    //set default number of orders
    $order_pro_Number_of_orders = (get_option('order_pro_Number_of_orders'));
    if(empty($order_pro_Number_of_orders))$order_pro_Number_of_orders=20;
    
    /*
    Get all orders.
    parent = 0 when dokan is active get only parent orders.
    */
    $orders = wc_get_orders( array(
    'parent' => '0',
    'status' => array($status),
    'return' => 'ids',
    'paginate' => true,
    'limit' => $order_pro_Number_of_orders,
    ));
    OSPO_header_orderes_produtcs($status);
    OSPO_orderes_products_table(OSPO_generate_orders_data($orders));
    OSPO_footer_orderes_products($order_pro_Number_of_orders);
}
if(!function_exists('OSPO_header_orderes_produtcs')){
    function OSPO_header_orderes_produtcs($current_status){
        echo ' <h2 style="margin-top: 25px;">'. esc_html_x("Orders", "Admin menu name", "woocommerce") .'('. esc_html__("Product","woocommerce").')<h2>';
        $statuses = wc_get_order_statuses();
        echo '<ul class="subsubsub statuslist">';
            foreach($statuses as $status_id => $status){
                $style='';
                if($current_status == $status_id) $style='style ="color: black;font-weight: 900;"';
                
                echo '<li><a '.$style.' href="'.OrdersPro_pages_url.'orderes_products&status='.$status_id.'">';
                echo $status;
                echo '</a>';
                if (strnatcmp(phpversion(),'7.3.0') >= 0){
                    if ($status_id !== array_key_last($statuses)) echo ' | ';}
                else{echo ' | ';}
                echo '</li> ';
            }
        echo '</ul>';
    }
}
if(!function_exists('OSPO_orderes_products_table')){
    function OSPO_orderes_products_table($products ){
        
        echo '<table class="wp-list-table widefat posts striped Orderes_products_table"><thead>';
        
        if(OSPO_checkenablecolumn('image_orderesProducts'))
            echo '<th>'.esc_html__("Image").'</th>';
            
        if(OSPO_checkenablecolumn('productName_orderesProducts'))
            echo '<th>'.esc_html__("Product","woocommerce").'</th>';
            
        if(OSPO_checkenablecolumn('Quantity_orderesProducts'))
            echo '<th>'.esc_html__("Quantity","woocommerce").'</th>';
            
        if(OSPO_checkenablecolumn('Price_orderesProducts'))
            echo '<th>'.esc_html__("Price","woocommerce").'</th>';
            
        if(OSPO_checkenablecolumn('Order_orderesProducts'))
            echo '<th>'.esc_html__("Order","woocommerce").'</th>';
            
        echo '</thead><tbody>';
        if(!empty($products))
        foreach($products[0] as $productID => $productQTY){
            
            $product = wc_get_product( $productID );
			
	     if(!$product) continue; //check product not deleted.
            
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $productID ), 'thumbnail' );
            
            $Fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $productID ), 'single-post-thumbnail' );
            
            if(empty($image))$image[0]=null;
            if(empty($Fullimage))$Fullimage[0]=null;
            echo '<tr>';
            
            if(OSPO_checkenablecolumn('image_orderesProducts'))
                echo '<td><a target="_blank" href="'.$Fullimage[0].'"><img src="'. $image[0] .'" data-id='. $productID .'></a></td>';
                
            if(OSPO_checkenablecolumn('productName_orderesProducts'))
                echo '<td>'.$product->get_name().'<br>'.$product->get_sku().'</td>';
                
            if(OSPO_checkenablecolumn('Quantity_orderesProducts'))
                echo '<td>'.OSPO_premiumHTML.'</td>';
                
            if(OSPO_checkenablecolumn('Price_orderesProducts'))
                echo '<td>'.OSPO_premiumHTML.'</td>';
                
            if(OSPO_checkenablecolumn('Order_orderesProducts'))
                echo '<td>'.OSPO_premiumHTML.'</td>';
                
            echo '</tr>';
        }
            echo '</tbody>';
	    echo '<tfoot><tr><td colspan="100%">'.__('Rows','woocommerce').': ';
	    if(!empty($products)) echo count($products[0]); else echo '0';
	    echo'</td></tr></tfoot>';
    	    echo '</table>';
    }
}
if(!function_exists('OSPO_generate_orders_data')){
    function OSPO_generate_orders_data($orders){
        $products = array();
        foreach ( $orders->orders as $order ) {
            
            $items = wc_get_order( $order )->get_items();
            
            foreach ( $items as $item ){
                
                $products[0][$item->get_product_id()]='';
                
            }
        }
        return $products;
    }
}
if(!function_exists('OSPO_checkenablecolumn')){
    function OSPO_checkenablecolumn($column)
    {
        $OrderPro_Orders_options = get_option('OrdersPro_Orders_options');
        if($OrderPro_Orders_options[$column]=='checked'){return true;}else{return false;}
    }
}
if(!function_exists('OSPO_footer_orderes_products')){
    function OSPO_footer_orderes_products($order_pro_Number_of_orders){
        ?>
        <form  class="order_count_input">
            <input type="hidden" name='page' value="<?php esc_attr_e( $_GET['page'] )?>">
            <input type="hidden" name='status' value="<?php esc_attr_e($_GET['status']) ?>">
            <label for="order_count_input"><?php esc_html_e('Number of orders','woocommerce') ?>:</label>
            <input name="order_count_input" type="number" value="<?php esc_attr_e($order_pro_Number_of_orders); ?>">
            <input type="submit" class="button button-primary" value="<?php esc_html_e('Run','woocommerce') ?>">
        </form>
        <?php
    }
}
