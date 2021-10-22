
    <h3><?php esc_html_e('Translations') ?></h3>
    <p><?php esc_html_e('You can use lowercase for better display','OrderPro_domain') ?></p>
    <table id="OP_Translations" class="form-table">
        <tbody>
            <tr><th><label for="instock"><?php esc_html_e('In stock','woocommerce'); ?> </label></th>
            <td class="forminp forminp-text"><input type="text" value="<?php if($OrderPro_translations['instock']!=esc_html__('In stock','woocommerce')){echo esc_html($OrderPro_translations['instock']);} ?>" name="instock"></td></tr>
            
            <tr><th><label for="outofstock"><?php esc_html_e('Out of stock','woocommerce'); ?> </label></th>
            <td class="forminp forminp-text"><input type="text" value="<?php if($OrderPro_translations['outofstock']!=esc_html__('Out of stock','woocommerce')){echo esc_html($OrderPro_translations['outofstock']);} ?>" name="outofstock"></td></tr> 
            
            <tr><th><label for="lowinstock"><?php esc_html_e('Low in stock','woocommerce'); ?> </label></th>
            <td class="forminp forminp-text"><input type="text" value="<?php if($OrderPro_translations['lowinstock']!=esc_html__('Low in stock','woocommerce')){echo esc_html($OrderPro_translations['lowinstock']);} ?>" name="lowinstock"></td></tr> 
            
            <tr><th><label for="onbackorder"><?php esc_html_e('On backorder','woocommerce'); ?> </label></th>
            <td class="forminp forminp-text"><input type="text" value="<?php if($OrderPro_translations['onbackorder']!=esc_html__('On backorder','woocommerce')){echo esc_html($OrderPro_translations['onbackorder']);} ?>" name="onbackorder"></td></tr>
    </tbody>
    </table>