<?php

namespace Wcw\Warehouse\Admin;
/**
 * Class Main
 * @package WcWWarehouse\Admin
 */
class Main {

	public function __construct() {

		add_action( 'init', [ $this, 'wcw_warehouse_taxonomy' ] );
		add_action( 'woocommerce_product_options_stock_fields', [ $this, 'wcw_warehouse_stock_fields' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'wcw_warehouse_field_save_data' ] );
	}

	/**
	 *  Register taxonomy for warehouse
	 */
	public function wcw_warehouse_taxonomy() {
		$labels = array(
			'name'                       => __( 'Warehouse', 'wcw-warehouse' ),
			'singular_name'              => __( 'Warehouse', 'wcw-warehouse' ),
			'menu_name'                  => __( 'Warehouses', 'wcw-warehouse' ),
			'all_items'                  => __( ' All Warehouses', 'wcw-warehouse' ),
			'parent_item'                => __( 'Parent Warehouse', 'wcw-warehouse' ),
			'parent_item_colon'          => __( ' Parent Warehouse:', 'wcw-warehouse' ),
			'new_item_name'              => __( ' New Warehouse', 'wcw-warehouse' ),
			'add_new_item'               => __( ' Add New Warehouse', 'wcw-warehouse' ),
			'edit_item'                  => __( ' Edit Warehouse', 'wcw-warehouse' ),
			'update_item'                => __( ' Update Warehouse', 'wcw-warehouse' ),
			'separate_items_with_commas' => __( 'Separate Warehouse with commas', 'wcw-warehouse' ),
			'search_items'               => __( 'Search Warehouses', 'wcw-warehouse' ),
			'add_or_remove_items'        => __( 'Add or remove Warehouses', 'wcw-warehouse' ),
			'choose_from_most_used'      => __( 'Choose from the most used Warehouses', 'wcw-warehouse' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'wcw_warehouse', 'product', $args );
	}

	/**
	 * Warehouse stock field
	 */
	public function wcw_warehouse_stock_fields() {
		global $product_object;
		if ( ! $product_object->is_type( 'simple' ) ) {
			return;
		} // do nothing for all but simple product only
		//list Warehouse terms
		$list_warehouses = get_terms( [
				'taxonomy'   => 'wcw_warehouse',
				'hide_empty' => true
			]
		);
//		print_r($list_warehouses);

		if ( is_array( $list_warehouses ) && sizeof( $list_warehouses ) > 0 ) {
//			print_r(sizeof($list_warehouses));
			?>
            <p class="wcw-warehouse-label form-field">
                <label><b><?php _e( 'Warehouse Lists', 'wcw-warehouse' ); ?></b></label></p>
			<?php
			foreach ( $list_warehouses as $list ) {
//				print_r($list);
				$warehouse_stock = $list->term_id;
				$warehouse_name  = $list->name;
				$warehouse_stock_value = intval( $product_object->get_meta( 'wcw_warehouse_stock_value' . $warehouse_stock, true ) );
				?>
                <p class="wcw-warehouse-name form-field"><label><?php echo esc_attr( $warehouse_name ); ?>:</label></p>
				<?php
				woocommerce_wp_text_input(
					array(
						'id'                => 'wcw_warehouse_stock['.$warehouse_stock.']',
						'value'             => $warehouse_stock_value,
						'label'             => __( 'Warehouse Quantity', 'wcw-warehouse' ),
						'desc_tip'          => true,
						'description'       => __( 'Warehouse Name: ' .$warehouse_name, 'wcw-warehouse' ),
						'type'              => 'number',
						'custom_attributes' => array(
							'step' => 'any',
						),
						'data_type'         => 'stock',

					)
				);
			}
		}
	}

	public function wcw_warehouse_field_save_data( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			return;
		}
		$warehouse_stock = ( isset( $_POST['wcw_warehouse_stock'] ) ) ? $_POST['wcw_warehouse_stock'] : array();

		if ( is_array($warehouse_stock) && sizeof($warehouse_stock) > 0 ){
			foreach ( $warehouse_stock as $warehouse_id => $warehouse_stock_count ) {
				$warehouse_stock_count = intval( $warehouse_stock_count );
				$product->update_meta_data( 'wcw_warehouse_stock_value' . $warehouse_id, $warehouse_stock_count );
			}
			$product->save();
		}


	}
}