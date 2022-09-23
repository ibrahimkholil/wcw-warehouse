<?php
/*
* Plugin Name: Woocomerce Warehouse
* Version: 1.0.0
* Author: Ibrahim
* Description: Custom woocommerce warehouse base on Test
* Text Domain: wcw-warehouse
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/*
 * The main plugin class
 */

final class WCW_Warehouse {

	/**
	 * Plugin version
	 */
	const version = '1.0.0';

	/**
	 * Custom_Warehouse constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action('plugins_loaded',[$this,'plugin_init']);
	}

	/**
	 * Initializes a singleton instance
	 * @return \Custom_Warehouse
	 */

	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;

	}

	/**
	 * Defined constants
	 */
	public function define_constants() {
		define( 'WCW_WAREHOUSE_VERSION', self::version );
		define( 'WCW_WAREHOUSE_FILE', __FILE__ );
		define( 'WCW_WAREHOUSE_PATH', plugin_dir_path( __FILE__ ) );
		define( 'WCW_WAREHOUSE_URL', plugins_url( '/', WCW_WAREHOUSE_FILE ) );
		define( 'WCW_WAREHOUSE_ASSETS', WCW_WAREHOUSE_URL . '/assets' );
	}

	/**
	 * Initialize the plugin
	 */
	public function plugin_init() {

		  if (is_admin()){
		  	new \Wcw\Warehouse\Admin();
		  }else{
		  	echo "nothing";
		  }
    }
	/**
	 * plugin activation do stuff
	 */
	public function activate() {
		$installed = get_option( 'wcw_warehouse_installed' );
		if ( ! $installed ) {
			update_option( 'wcw_warehouse_installed', time() );
		}
		update_option( 'wcw_warehouse_version', WCW_WAREHOUSE_VERSION );
	}
}

function wcw_warehouse() {
	return WCW_Warehouse::init();
}

wcw_warehouse();
// define Constant


// add warehouse list to inventory
//function wcw_lists_warehouse() {
//	$args    = array(
//		'post_type'      => 'wcw',
//		'posts_per_page' => - 1 // to get all warehouses
//
//	);
//	$querys  = get_posts( $args );
//	$options = [];
//
//	foreach ( $querys as $query ) {
//		if ( ! empty( $query->ID ) ) {
//			$options[ $query->ID ] = $query->post_title;
//		}
//	}
//
//	return $options;
//
//
//}

//// Warehouse select field
//function wcw_lists_select_field() {
//	woocommerce_wp_select(
//		array(
//			'id'                => 'wcw_select_warehouse',
//			'label'             => _x( 'Select Warehouse', 'wcw' ),
//			//  'options' => array(
//			//     '1' => 'option_value',
//			//     '2' => 'option_value1',
//			//     '3' => 'option_value2',
//			//     '4' => 'option_value3',
//			//  ),
//			'options'           => wcw_lists_warehouse(),
//			'custom_attributes' => array( 'multiple' => 'multiple' )
//		)
//	);
//}
//
//add_action( 'woocommerce_product_options_inventory_product_data', 'wcw_lists_select_field' );
//
//// save field data
//add_action( 'woocommerce_process_product_meta', 'save_select_wareouse_field_data', 10, 2 );
//function save_select_wareouse_field_data( $id, $post ) {
//	// $product = wc_get_product($id);
//
//	var_dump( $_POST['wcw_select_warehouse'] );
//	if ( isset( $_POST['wcw_select_warehouse'] ) ) {
//		update_post_meta( $id, 'wcw_select_warehouse', $_POST['wcw_select_warehouse'] );
//		// $product_id->update_meta_data( 'wcw_select_warehouse',  $_POST['wcw_select_warehouse']  );
//	}
//
//}
//
//
//// display the custom field value in single product page
//add_action( 'woocommerce_before_add_to_cart_button', 'wcw_warehouse_display' );
//function wcw_warehouse_display() {
//	global $post;
//	$product    = wc_get_product( $post->ID );
//	$warehouses = $product->get_meta( 'wcw_select_warehouse' );
//	woocommerce_form_field( 'warehouse_user_select_option',
//
//		array(
//			'id'                => 'warehouse_user_select',
//			'type'              => 'select',
//			'label'             => 'Select Warehouse',
//			'required'          => true,
//			'options'           => wcw_lists_warehouse(),
//			'custom_attributes' => array( 'multiple' => 'multiple' )
//		),
//        );
//}
//
//// select field
//function wcw_user_select_warehouse() {
//	if ( isset( $_POST['warehouse_user_select_option'] ) ) {
//
//		$product_id = $_POST['warehouse_user_select_option'];
//		$found      = false;
//		if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
//			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
//				$_product = $values['data'];
//				if ( $_product->id == $product_id ) {
//					$found = true;
//				}
//			}
//			if ( ! $found ) {
//				WC()->cart->add_to_cart( $product_id );
//			}
//		} else {
//			WC()->cart->add_to_cart( $product_id );
//		}
//	}
//}
//
//add_action( 'woocommerce_add_to_cart', 'wcw_user_select_warehouse' );
//
//// add warehouse value to cart page
//
//add_action( 'woocommerce_add_cart_item_data', 'wcw_warehouse_selected_data' );
//
//function wcw_warehouse_selected_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
//
//	if ( ! empty( $_POST ['warehouse_user_select_option'] ) ) {
//		$cart_item_data['warehouse_user_select_option'] = $_POST['warehouse_user_select_option'];
//	}
//
//	return $cart_item_data;
//
//}

