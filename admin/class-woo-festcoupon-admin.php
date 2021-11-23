<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Woo_Festcoupon
 * @subpackage Woo_Festcoupon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Festcoupon
 * @subpackage Woo_Festcoupon/admin
 * @author     Faiq Masood <faiqmasood@cedcommerce.com>
 */
class Woo_Festcoupon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Festcoupon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Festcoupon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-festcoupon-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Festcoupon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Festcoupon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-festcoupon-admin.js', array( 'jquery' ), $this->version, false );

	}


	//Show Custom Meta Box to the Product General Tab (Below the Price of the Product)
	function show_custom_meta_woo_general(){ 
		global $thepostid;
		woocommerce_wp_text_input(
			array(
				'id'    => 'festive_price',
				'name'  => '_festive_price',
				'value' => get_post_meta( $thepostid, '_festive_price', true ),
				'class' => 'wc_input_price short',
				'label' => 'Festive Price',
			)
		); 
	}
	// Save the value of Woo Commerce Custom Meta Box ((Below the Price of the Product)) 
	function save_product_custom_metadata( $post_id ) {
		$product = wc_get_product( $post_id );
		$product->update_meta_data(
			'_festive_price',
			wc_clean( wp_unslash( filter_input( INPUT_POST, '_festive_price' ) ) )
		);
		$product->save();
	}


	//Check the Coupon code with existing coupon, if true then get the product meta and applied price to the cart table
	function auto_apply_coupon_conditionally( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) )
			return;
		$coupon_code = 'festive'; // HERE set the coupon code (in lowercase)
		$applied     = in_array( $coupon_code, $cart->get_applied_coupons() ) ? true : false;
		// Remove coupon
		if($applied){
			foreach($cart->get_cart() as $cart_item){

				$value = get_post_meta( $cart_item['data']->get_id(), '_festive_price', true );
				
				if( (int)$value > 0 ){
					$new_price = (int)$value;  
				}else{
					$new_price = $cart_item['data']->get_price();	
				}
				$cart_item['data']->set_price( $new_price );
			}
		}		
	}
	//Showing the message of Coup
	function ced_before_add_to_cart_btn(){
		echo '<p style="font-weight:light-bold;font-size:21px;color: red;">Apply "FESTIVE" Coupon at Cart or Checkout page to get the Festive off</p>';
	}
}
