<?php
if(!function_exists('OSPO_display_orderspro_tab_content')){
    function OSPO_display_orderspro_tab_content()
    {
        $sortimg = OrderPro_DIR.'assets/img/sort.svg';
        $visible = OrderPro_DIR.'assets/img/visible.svg';
        $OrderPro_translations =  get_option('OrderPro_translations');
        $OrderPro_Column =  get_option('OrderPro_Column');
        $OrderPro_Orders_options =  get_option('OrdersPro_Orders_options');
        include (OrderPro_DIR_path . 'pages/options.php');
    }
}

add_action('wp_ajax_OrderPro_settings_save', function()
{
    $OrderPro_Column = OSPO_array_map_sanitize('strip_tags',$_POST['OrderPro_Column']);
    update_option( 'OrderPro_Column',$OrderPro_Column);
    
    $Orders_options =  OSPO_array_map_sanitize('strip_tags',$_POST['Orders_options']);
    update_option( 'OrdersPro_Orders_options',$Orders_options);
    
    $OrderPro_translations = OSPO_array_map_sanitize('strip_tags',$_POST['OrderPro_translations']);
    if($OrderPro_translations['instock']==''){$OrderPro_translations['instock']=esc_html__('In stock','woocommerce');}
    if($OrderPro_translations['outofstock']==''){$OrderPro_translations['outofstock']=esc_html__('Out of stock','woocommerce');}
    if($OrderPro_translations['lowinstock']==''){$OrderPro_translations['lowinstock']=esc_html__('Low in stock','woocommerce');}
    if($OrderPro_translations['onbackorder']==''){$OrderPro_translations['onbackorder']=esc_html__('On backorder','woocommerce');}
    update_option( 'OrderPro_translations', $OrderPro_translations);
    
    wp_die();
});

if(!function_exists('OSPO_array_map_sanitize')){
    function OSPO_array_map_sanitize( $func, $arr )
    {
        $newArr = array();
    
        foreach( $arr as $key => $value )
        {
            $newArr[ $key ] = ( is_array( $value ) ? OSPO_array_map_sanitize( $func, $value ) : ( is_array($func) ? call_user_func_array($func, $value) : $func( $value ) ) );
        }
    
        return $newArr;
    }
}











 