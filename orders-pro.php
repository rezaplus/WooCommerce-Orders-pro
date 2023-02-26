<?php
/**
 * Plugin Name: Orders Pro
 * Description: Professionally Customize  admin-side orders page and enjoy it.
 * Plugin URI: "https://rellaco.com/product/orderspro-premium/"
 * Author: rellaco
 * Author URI: https://rellaco.com
 * Text Domain: OrderPro_domain
 *
 * Version: 1.8
 * Requires at least: 5.0
 * Requires PHP: 7.0
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('OrdersPro_version', "1.8");
define('OrdersPro_License_Version', "free");

class OSPO_OrdersPro{

    static $instance = null;

    public function __construct(){

        //default_options on activation
        register_activation_hook( __FILE__,array($this,'default_options'));

        $this->define_constants();
        $this->include_exceptions();
        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ));

        // loading styles and scripts
        add_action('admin_enqueue_scripts', array( $this, 'scripts_stye_load_admin' ));

        //Create admin menu and pages

        add_action('admin_menu',array($this,'Admin_menu'),99);

    }

    /**
     * Define all constants
     *
     * @return void
     */
    protected function define_constants(){
        $this->define('OrderPro_DIR',plugin_dir_url(dirname(__FILE__)).dirname(plugin_basename(__FILE__)).'/');
        $this->define('OrderPro_DIR_path',plugin_dir_path( __FILE__ ));
        $this->define('OrderPro_plugin_basename',dirname(plugin_basename(__FILE__)));
        $this->define('OrdersPro_Pages_path',OrderPro_DIR_path.'pages/');
        $this->define('OrdersPro_pages_url',admin_url('admin.php').'?page=');
		$this->define('OSPO_img_dir',OrderPro_DIR . 'assets/img/');

        $premiumHTML =' <a class="premium_orderspro dashicons dashicons-lock OSPO_tooltip" data-tooltip="Premium Feature" href="https://rellaco.com/product/orderspro-premium/" target="_blank"></a>';
        $this->define('OSPO_premiumHTML', $premiumHTML);
    }
    public function include_exceptions(){
        require_once 'functions/OrdersPreview.php';
        require_once 'functions/Options.php';
        require_once 'functions/Orders.php';
        if(OrdersPro_License_Version != 'free')
            require_once 'premium/premium.php';
        else
            require_once OrdersPro_Pages_path.'Orderes_products.php';;
    }

    public function default_options(){
        if(!get_option('OrderPro_Column')){
            $default_Columns = Array
                 (
                     'ProductID' => 'true',
                     'Image' => 'true',
                     'Product' => 'true',
                     'Quantity' => 'true',
                     'Stock' => 'false',
                     'Price' => 'true',
                     'Total' => 'true',
                     'Category' => 'true',
                     'tax' => 'false'
                 );
            update_option( 'OrderPro_Column',$default_Columns);
        }
        if(!get_option('OrdersPro_Orders_options')){
            $default_Orders_options = Array (
                'enable_onMobile' => 'checked',
                'total_onMobile' => 'checked',
                'actions_onMobile' => 'checked',
                'Shipping_address_onMobile' => 'checked',
                'billing_address_onMobile' => 'unchecked',
                'image_orderesProducts' => 'checked',
                'productName_orderesProducts' => 'checked',
                'Quantity_orderesProducts' => 'unchecked',
                'Price_orderesProducts' => 'unchecked',
                'Order_orderesProducts' => 'unchecked',
                'instock' => __('In stock','woocommerce'),
                'outofstock'=>__('Out of stock','woocommerce'),
                'lowinstock'=>__('Out of stock','woocommerce'),
                'onbackorder'=>__('On backorder','woocommerce')
                );
            update_option( 'OrdersPro_Orders_options',$default_Orders_options);
        }
    }

    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function scripts_stye_load_admin(){
        //check current page is OrdersPro_settings
		$currentpage = false;
        if(isset($_GET['page'])){
            if($_GET['page'] == 'OrdersPro_settings' or $_GET['page'] == 'orderes_products') $currentpage = true; else $currentpage = false;
        }
        if($currentpage or get_post_type(get_the_ID()) == 'shop_order' ){

            //RIGHT To LEFT Style
            if(is_rtl()){wp_enqueue_style('OrdersPro-rtl', OrderPro_DIR . 'assets/OrdersPro-rtl.css', array() , constant("OrdersPro_version"));}

            //Style
            wp_enqueue_style('OrdersPro', OrderPro_DIR . 'assets/OrdersPro.css', array() , constant("OrdersPro_version"));
            //Scripts
            if($currentpage){
                wp_enqueue_script('OrdersPro_options', OrderPro_DIR . 'assets/options.js', array('jquery-ui-sortable') , constant("OrdersPro_version") , true);
            }

            if(get_post_type(get_the_ID()) == 'shop_order'){

                wp_enqueue_script('OrdersPro', OrderPro_DIR . 'assets/OrdersPro.js', array() , constant("OrdersPro_version") , true);
                wp_localize_script('OrdersPro', 'OrdersPro_localize', array(
                	'regular_price' => esc_html__('Regular price', 'woocommerce'),
                	'sale_price' => esc_html__('Sale price', 'woocommerce'),
                	'sale_price_is_not_true_alert' =>esc_html__('Please enter in a value less than the regular price.','woocommerce'),
                	'enable_stock_management' => esc_html__('Enable stock management','woocommerce'),
                	'inactive_manage_stock' => esc_html__('Manage stock','woocommerce').': '.esc_html__('Inactive','woocommerce'),
                	'Stock_prompt' => esc_html__("Stock qty","woocommerce"). ':'
                ));
            }
        }
    }
    public function Admin_menu() {

    add_menu_page(esc_html__("Orders Pro",'OrderPro_domain'), esc_html__("Orders Pro",'OrderPro_domain') , 'manage_options', 'OrdersPro_settings', 'OSPO_display_orderspro_tab_content', 'dashicons-screenoptions', 150);
	
    add_submenu_page( 'woocommerce',  esc_html_x('Orders', 'Admin menu name', 'woocommerce')."(".esc_html__('Products','woocommerce').")",  esc_html_x('Orders', 'Admin menu name', 'woocommerce')."(".esc_html__('Product','woocommerce').")", 'manage_options', 'orderes_products', 'OSPO_display_Orderes_products',2 );

    }
    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain('OrderPro_domain', false, OrderPro_plugin_basename  . '/languages/');
    }

    /**
     * Define constant if not already defined
     * @param string $name
     * @param string|bool $value
     * @return void
     */
    protected function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    if(is_admin()){
        OSPO_OrdersPro::get_instance();
    }
}else{
    add_action('admin_notices',function(){
        ?>
            <div class="notice notice-error is-dismissible" style="display: flow-root;">
             <p><?php esc_html_e('Orders Pro require WooCoommerce is Activate.','OrderPro_domain') ?></p>
            </div>
        <?php
    });
}
