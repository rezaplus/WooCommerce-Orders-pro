<?php $disable_onMobile=''; if($OrderPro_Orders_options['enable_onMobile']!='checked') $disable_onMobile='disabled' ?>
<li class='OP_options_section' name="orders_tab">
    <h3><?php echo esc_html__('Screen Options') .': '.esc_html__('On mobile','OrderPro_domain') ?></h3>
    <p><?php esc_html_e('By activating this section, you can see more details of orders in the mobile screen.','OrderPro_domain') ?></p>
    <table id="OP_Orders" class="form-table">
        <thead>
            <tr><th><label for="enable_onMobile"><?php esc_html_e('Activate'); ?> </label></th>
            <td ><input type="checkbox" name="enable_onMobile" <?php echo $OrderPro_Orders_options['enable_onMobile']; ?>></td></tr>
        </thead>
        <tbody>
            <tr><th><label for="total_onMobile"><?php esc_html_e('Total','woocommerce'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="total_onMobile" <?php echo $OrderPro_Orders_options['total_onMobile'].' '.$disable_onMobile; ?>></td></tr>
            <?php if(class_exists( 'WeDevs_Dokan' )){ ?>
            <tr><th><label for="saler_onMobile"><?php esc_html_e('Vendor','dokan-lite'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="saler_onMobile" <?php echo $OrderPro_Orders_options['saler_onMobile'].' '.$disable_onMobile; ?>></td></tr>
            <?php } ?>
            <tr><th><label for="actions_onMobile"><?php esc_html_e('Actions','woocommerce'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="actions_onMobile" <?php echo $OrderPro_Orders_options['actions_onMobile'].' '.$disable_onMobile; ?>></td></tr>
    
            <tr><th><label for="Shipping_address_onMobile"><?php esc_html_e('Shipping Address','woocommerce'); ?> </label></th>
            <td ><input type="checkbox"class="OP_Orders_subset"  name="Shipping_address_onMobile" <?php echo $OrderPro_Orders_options['Shipping_address_onMobile'].' '. $disable_onMobile; ?>></td></tr>
            
            <tr><th><label for="billing_address_onMobile"><?php esc_html_e('Billing Address','woocommerce'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="billing_address_onMobile" <?php echo $OrderPro_Orders_options['billing_address_onMobile'] .' '. $disable_onMobile; ?>></td></tr>
        </tbody>
    </table>
</li>

<li class='OP_options_section' name="orders_tab">
    <h3><?php echo esc_html_x('Orders', 'Admin menu name', 'woocommerce').'('.esc_html__('Product','woocommerce').')' ?></h3>
    <a href="<?php echo OrdersPro_pages_url.'orderes_products'; ?>"><p><?php esc_html_e('This page displays orders based on purchased products','OrderPro_domain') ?></p></a>
    <table id="OP_Orderes_products" class="form-table">
        <tbody>
            <tr><th><label for="image_orderesProducts"><?php esc_html_e('Image','woocommerce'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="image_orderesProducts" <?php echo $OrderPro_Orders_options['image_orderesProducts']; ?>></td></tr>
            
            <tr><th><label for="productName_orderesProducts"><?php esc_html_e('Product','woocommerce'); ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="productName_orderesProducts" <?php echo $OrderPro_Orders_options['productName_orderesProducts']; ?>></td></tr>

            <tr><th><label for="Quantity_orderesProducts"><?php esc_html_e('Quantity','woocommerce'); echo OSPO_premiumHTML ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="Quantity_orderesProducts" <?php echo $OrderPro_Orders_options['Quantity_orderesProducts']; ?>></td></tr>
    
            <tr><th><label for="Price_orderesProducts"><?php esc_html_e('Price','woocommerce'); echo OSPO_premiumHTML ?> </label></th>
            <td ><input type="checkbox"class="OP_Orders_subset"  name="Price_orderesProducts" <?php echo $OrderPro_Orders_options['Price_orderesProducts']; ?>></td></tr>
            
            <tr><th><label for="Order_orderesProducts"><?php esc_html_e('Order','woocommerce'); echo OSPO_premiumHTML ?> </label></th>
            <td ><input type="checkbox" class="OP_Orders_subset" name="Order_orderesProducts" <?php echo $OrderPro_Orders_options['Order_orderesProducts'] ; ?>></td></tr>
        </tbody>
    </table>
</li>