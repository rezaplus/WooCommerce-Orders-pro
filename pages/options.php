<div class="OP_options_menu">
    <h3>OrdersPro</h3>
    <ul id="tabs_buttons">
        <li id="orders_tab"><?php esc_html_e('Orders','woocommerce'); ?></li>
        <li id="preview_tab" ><?php esc_html_e('Preview', 'woocommerce'); ?></li>
        <li id="translations_tab" ><?php esc_html_e('Translations'); ?></li>
       <?php 
        if(OrdersPro_License_Version == 'premium' ){
            ?><li id="license" ><?php esc_html_e('License','OrderPro_domain'); ?></li><?php
         }else{
            ?><li id="license" ><?php esc_html_e('About Premium','OrderPro_domain'); ?></li><?php
         }
        ?>
    </ul>
</div>
<ul class="OP_options" id="tabs_sections">
     <?php require_once 'Options/Orders.php'; ?>
    <li class='OP_options_section ordersPro_columns_settings' name="preview_tab"> <?php require_once 'Options/OrderPreviewColumns.php'; ?> </li>
    <li class='OP_options_section' name="translations_tab"> <?php require_once 'Options/Translations.php'; ?> </li>
    <li class='OP_options_section' name="license">
     <?php 
        if(OrdersPro_License_Version == 'premium' ){
            require_once OrderPro_DIR_path.'/premium/pages/Options/License.php';
        }else{
            require_once 'Options/aboutPremium.php';
        }
    ?>
    </li>
</ul>

<button id="save_settings_Orders_pro"  class="button button-primary" ><?php esc_html_e('Save changes','woocommerce'); ?></button>
<img class="OrderPro_Done" src="<?php echo OrderPro_DIR.'assets/img/mark.svg'; ?>">
<img class="OrderPro_loading" src="<?php echo OrderPro_DIR.'assets/img/oval.svg'; ?>">
