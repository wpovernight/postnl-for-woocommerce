<?php
/**
 * Class Frontend/Base file.
 *
 * @package PostNLWooCommerce\Frontend
 */

namespace PostNLWooCommerce\Frontend;

use PostNLWooCommerce\Shipping_Method\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Base
 *
 * @package PostNLWooCommerce\Frontend
 */
abstract class Base {
	/**
	 * Settings class instance.
	 *
	 * @var PostNLWooCommerce\Shipping_Method\Settings
	 */
	protected $settings;

	/**
	 * Template file name.
	 *
	 * @var string
	 */
	public $template_file;

	/**
	 * Prefix for meta box fields.
	 *
	 * @var prefix
	 */
	protected $prefix = POSTNL_SETTINGS_ID . '_';

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		$this->settings = Settings::get_instance();
		$this->set_template_file();
		$this->init_hooks();
	}

	/**
	 * Need to set the template file name;
	 */
	abstract public function set_template_file();

	/**
	 * List of frontend fields.
	 */
	abstract public function get_fields();

	/**
	 * Check if this feature is enabled from the settings.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return ( $this->settings->is_delivery_enabled() && ! empty( $this->get_fields() ) );
	}

	/**
	 * Collection of hooks when initiation.
	 */
	public function init_hooks() {
		if ( ! $this->is_enabled() ) {
			return;
		}

		add_action( 'woocommerce_review_order_after_shipping', array( $this, 'display_fields' ) );
		add_filter( 'woocommerce_checkout_posted_data', array( $this, 'validate_posted_data' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_data' ), 10, 2 );
	}

	/**
	 * Add delivery day fields.
	 */
	public function display_fields() {
		$template_args = array(
			'fields' => $this->get_fields_with_value(),
		);

		wc_get_template( $this->template_file, $template_args, '', POSTNL_WC_PLUGIN_DIR_PATH . '/templates/' );
	}

	/**
	 * Add value to the fields.
	 *
	 * @return array
	 */
	public function get_fields_with_value() {
		$post_data = array();

		if ( isset( $_REQUEST['post_data'] ) ) {
			parse_str( sanitize_text_field( wp_unslash( $_REQUEST['post_data'] ) ), $post_data );
		}

		$field_w_val = array_map(
			function ( $field ) use ( $post_data ) {
				$field['value'] = array_key_exists( $field['id'], $post_data ) ? $post_data[ $field['id'] ] : '';
				return $field;
			},
			$this->get_fields()
		);

		return $field_w_val;
	}

	/**
	 * Validate posted data.
	 *
	 * @param array $data Array of posted data.
	 */
	public function validate_posted_data( $data ) {
		$nonce_value    = wc_get_var( $_REQUEST['woocommerce-process-checkout-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // phpcs:ignore
		$expiry_message = sprintf(
			/* translators: %s: shop cart url */
			__( 'Sorry, your session has expired. <a href="%s" class="wc-backward">Return to shop</a>', 'woocommerce' ),
			esc_url( wc_get_page_permalink( 'shop' ) )
		);

		if ( empty( $nonce_value ) || ! wp_verify_nonce( $nonce_value, 'woocommerce-process_checkout' ) ) {
			return $data;
		}

		$data = $this->validate_fields( $data, $_POST );

		return $data;
	}

	/**
	 * Validate delivery type fields.
	 *
	 * @param array $data Array of posted data.
	 * @param array $posted_data Array of global _POST data.
	 *
	 * @return array
	 */
	abstract public function validate_fields( $data, $posted_data );

	/**
	 * Save frontend field value to meta.
	 *
	 * @param int   $order_id ID of the order.
	 * @param array $posted_data Posted values.
	 */
	public function save_data( $order_id, $posted_data ) {

		$order = wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) {
			return;
		}

		foreach ( $this->get_fields() as $field ) {
			if ( array_key_exists( $field['id'], $posted_data ) ) {
				$order->update_meta_data( $field['id'], $posted_data[ $field['id'] ] );
			}
		}

		$order->save();
	}
}
