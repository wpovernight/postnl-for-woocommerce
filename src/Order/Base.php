<?php
/**
 * Class Order\Base file.
 *
 * @package PostNLWooCommerce\Order
 */

namespace PostNLWooCommerce\Order;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Base
 *
 * @package PostNLWooCommerce\Order
 */
abstract class Base {
	/**
	 * Saved shipping settings.
	 *
	 * @var shipping_settings
	 */
	protected $shipping_settings = array();

	/**
	 * Nonce key for ajax call.
	 *
	 * @var nonce_key
	 */
	protected $nonce_key = 'create-postnl-label';

	/**
	 * Current service.
	 *
	 * @var service
	 */
	protected $service = 'PostNL';

	/**
	 * Prefix for meta box fields.
	 *
	 * @var prefix
	 */
	protected $prefix = POSTNL_SETTINGS_ID . '_';

	/**
	 * Meta name for saved fields.
	 *
	 * @var meta_name
	 */
	protected $meta_name = '_' . POSTNL_SETTINGS_ID . '_saved_fields';

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Abstract function for collection of hooks when initiation.
	 */
	abstract public function init_hooks();

	/**
	 * Get nonce field.
	 *
	 * @return array
	 */
	public function get_nonce_fields() {
		return array_filter(
			$this->meta_box_fields(),
			function( $field ) {
				return ( ! empty( $field['nonce'] ) && true === $field['nonce'] );
			}
		);
	}

	/**
	 * Get field name without prefix.
	 *
	 * @param String $field_name Name of the field.
	 *
	 * @return String
	 */
	public function remove_prefix_field( $field_name ) {
		return str_replace( $this->prefix, '', $field_name );
	}

	/**
	 * List of meta box fields.
	 */
	public function meta_box_fields() {
		return apply_filters(
			'postnl_order_meta_box_fields',
			array(
				array(
					'id'                => $this->prefix . 'delivery_type',
					'type'              => 'text',
					'label'             => __( 'Delivery Type:', 'postnl-for-woocommerce' ),
					'description'       => '',
					'class'             => 'long',
					'value'             => 'Standard',
					'custom_attributes' => array( 'readonly' => 'readonly' ),
					'container'         => true,
				),
				array(
					'id'          => $this->prefix . 'insured_shipping',
					'type'        => 'checkbox',
					'label'       => __( 'Insured Shipping: ', 'postnl-for-woocommerce' ),
					'placeholder' => '',
					'description' => '',
					'value'       => '',
					'container'   => true,
				),
				array(
					'id'   => $this->prefix . 'break_1',
					'type' => 'break',
				),
				array(
					'id'          => $this->prefix . 'return_no_answer',
					'type'        => 'checkbox',
					'label'       => __( 'Return if no answer: ', 'postnl-for-woocommerce' ),
					'placeholder' => '',
					'description' => '',
					'value'       => '',
					'container'   => true,
				),
				array(
					'id'          => $this->prefix . 'signature_on_delivery',
					'type'        => 'checkbox',
					'label'       => __( 'Signature on Delivery: ', 'postnl-for-woocommerce' ),
					'placeholder' => '',
					'description' => '',
					'value'       => '',
					'container'   => true,
				),
				array(
					'id'          => $this->prefix . 'only_home_address',
					'type'        => 'checkbox',
					'label'       => __( 'Only Home Address: ', 'postnl-for-woocommerce' ),
					'placeholder' => '',
					'description' => '',
					'value'       => '',
					'container'   => true,
				),
				array(
					'id'                => $this->prefix . 'num_labels',
					'type'              => 'number',
					'label'             => __( 'Number of Labels: ', 'postnl-for-woocommerce' ),
					'placeholder'       => '',
					'description'       => '',
					'class'             => 'short',
					'value'             => '',
					'custom_attributes' =>
						array(
							'step' => 'any',
							'min'  => '0',
						),
					'container'         => true,
				),
				array(
					'id'          => 'postnl_create_return_label',
					'type'        => 'checkbox',
					'label'       => __( 'Create Return Label: ', 'postnl-for-woocommerce' ),
					'placeholder' => '',
					'description' => '',
					'value'       => '',
					'container'   => true,
				),
				array(
					'id'        => $this->prefix . 'label_nonce',
					'type'      => 'hidden',
					'nonce'     => true,
					'value'     => wp_create_nonce( $this->nonce_key ),
					'container' => true,
				),
			)
		);
	}

	/**
	 * Generating meta box fields.
	 *
	 * @param array $fields list of fields.
	 */
	public function fields_generator( $fields ) {
		foreach ( $fields as $field ) {
			if ( empty( $field['id'] ) ) {
				continue;
			}

			if ( ! empty( $field['container'] ) && true === $field['container'] ) {
				?>
				<div class="shipment-postnl-row-container shipment-<?php echo esc_attr( $field['id'] ); ?>">
				<?php
			}

			switch ( $field['type'] ) {
				case 'select':
					woocommerce_wp_select( $field );
					break;

				case 'checkbox':
					woocommerce_wp_checkbox( $field );
					break;

				case 'hidden':
					woocommerce_wp_hidden_input( $field );
					break;

				case 'radio':
					woocommerce_wp_radio( $field );
					break;

				case 'textarea':
					woocommerce_wp_textarea_input( $field );
					break;

				case 'break':
					echo '<div class="postnl-break-line ' . esc_attr( $field['id'] ) . '"><hr id="' . esc_attr( $field['id'] ) . '" /></div>';
					break;

				case 'text':
				case 'number':
				default:
					woocommerce_wp_text_input( $field );
					break;
			}

			if ( ! empty( $field['container'] ) && true === $field['container'] ) {
				?>
				</div>
				<?php
			}
		}
	}

	/**
	 * Saving meta box in order admin page.
	 *
	 * @param  int   $order_id Order post ID.
	 * @param  array $meta_values PostNL meta values.
	 */
	public function save_meta_value( $order_id, $meta_values ) {
		$order = wc_get_order( $order_id );

		if ( ! is_a( $order, 'WC_Order' ) ) {
			return false;
		}

		// Get array of nonce fields.
		$nonce_fields = array_values( $this->get_nonce_fields() );

		$saved_data = array();

		// Loop through inputs within id 'shipment-postnl-label-form'.
		foreach ( $this->meta_box_fields() as $field ) {
			// Don't save nonce field.
			if ( $nonce_fields[0]['id'] === $field['id'] ) {
				continue;
			}

			$post_value = ! empty( $meta_values[ $field['id'] ] ) ? sanitize_text_field( wp_unslash( $meta_values[ $field['id'] ] ) ) : '';

			if ( ! empty( $order->get_meta( $field['id'] ) ) ) {
				$post_value = $order->get_meta( $field['id'] );
			}

			$saved_data [ $field['id'] ] = $post_value;
		}

		$order->update_meta_data( $this->meta_name, $saved_data );
		$order->save();

		return $saved_data;
	}
}
