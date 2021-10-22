<?php
//orders on mobile
add_filter( 'admin_body_class',function( $classes ) {
    $OrderPro_Orders_options = get_option('OrdersPro_Orders_options');
    if( get_post_type(get_the_ID()) == 'shop_order' ) {
        if($OrderPro_Orders_options['enable_onMobile']=='checked'){$classes .= ' enable_onMobile';
            if($OrderPro_Orders_options['total_onMobile']=='checked'){$classes .= ' total_onMobile';}
            if($OrderPro_Orders_options['actions_onMobile']=='checked'){$classes .= ' actions_onMobile';}
            if($OrderPro_Orders_options['Shipping_address_onMobile']=='checked'){$classes .= ' Shipping_address_onMobile ';}
            if($OrderPro_Orders_options['billing_address_onMobile']=='checked'){$classes .= ' billing_address_onMobile ';}
            if(class_exists( 'WeDevs_Dokan' )): if($OrderPro_Orders_options['saler_onMobile']=='checked'){$classes .= ' saler_onMobile ';} endif;
        }
    }
    //premium label
    $classnameversion =' OSP_free ';
    if(get_option('ospcode')==500){$classnameversion =' OSP_premium ';}
    return $classes . $classnameversion;
});