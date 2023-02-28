<?php
/**
 * Class Mapping file.
 *
 * @package PostNLWooCommerce\Helper
 */

namespace PostNLWooCommerce\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Mapping
 *
 * @package PostNLWooCommerce\Mapping
 */
class Mapping {
	/**
	 * Delivery type mapping.
	 *
	 * @return array.
	 */
	public static function delivery_type() {
		return array(
			'NL' => array(
				'NL'  => array(
					'delivery_day_type'   => array(
						'08:00-12:00' => esc_html__( 'Morning Delivery', 'postnl-for-woocommerce' ),
						'Daytime'     => esc_html__( 'Standard Shipment', 'postnl-for-woocommerce' ),
						'Evening'     => esc_html__( 'Evening Delivery', 'postnl-for-woocommerce' ),
					),
					'dropoff_points_type' => array(
						'Pickup' => esc_html__( 'Pickup at PostNL Point', 'postnl-for-woocommerce' ),
					),
				),
				'BE'  => array(
					'delivery_day_type'   => array(
						'Daytime' => esc_html__( 'Standard Shipment Belgium', 'postnl-for-woocommerce' ),
					),
					'dropoff_points_type' => array(
						'Pickup' => esc_html__( 'Pickup at PostNL Point Belgium', 'postnl-for-woocommerce' ),
					),
				),
				'EU'  => esc_html__( 'EU Parcel', 'postnl-for-woocommerce' ),
				'ROW' => esc_html__( 'Globalpack', 'postnl-for-woocommerce' ),
			),
			'BE' => array(
				'BE'  => esc_html__( 'Belgium Domestic', 'postnl-for-woocommerce' ),
				'NL'  => esc_html__( 'EU Parcel', 'postnl-for-woocommerce' ),
				'EU'  => esc_html__( 'EU Parcel', 'postnl-for-woocommerce' ),
				'ROW' => esc_html__( 'Globalpack', 'postnl-for-woocommerce' ),
			),
		);
	}

	/**
	 * Products code & options mapping.
	 *
	 * @return array[]
	 */
	public static function products_data() {
		return array(
			'NL' => array(
				'NL'  => array(
					'delivery_day'  => array(
						array(
							'combination' => array(),
							'code'        => '3085',
							'options'     => array()
						),
						array(
							'combination' => array( 'only_home_address' ),
							'code'        => '3385',
							'options'     => array()
						),
						array(
							'combination' => array( 'return_no_answer' ),
							'code'        => '3090',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping' ),
							'code'        => '3087',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery' ),
							'code'        => '3189',
							'options'     => array()
						),
						array(
							'combination' => array( 'return_no_answer', 'only_home_address' ),
							'code'        => '3390',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping', 'return_no_answer' ),
							'code'        => '3094',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery', 'only_home_address' ),
							'code'        => '3089',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery', 'return_no_answer' ),
							'code'        => '3389',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery', 'only_home_address', 'return_no_answer' ),
							'code'        => '3096',
							'options'     => array()
						),
						array(
							'combination' => array( 'letterbox' ),
							'code'        => '2928',
							'options'     => array()
						),
						array(
							'combination' => array( 'id_check' ),
							'code'        => '3438',
							'options'     => array()
						)
					),
					'pickup_points' => array(
						array(
							'combination' => array(),
							'code'        => '3533',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping' ),
							'code'        => '3534',
							'options'     => array()
						),
					)
				),
				'BE'  => array(
					'delivery_day'  => array(
						array(
							'combination' => array(),
							'code'        => '4946',
							'options'     => array()
						),
						array(
							'combination' => array( 'only_home_address' ),
							'code'        => '4941',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery' ),
							'code'        => '4912',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping' ),
							'code'        => '4914',
							'options'     => array()
						)
					),
					'pickup_points' => array(
						array(
							'combination' => array(),
							'code'        => '4936',
							'options'     => array()
						)
					),
				),
				'EU'  => array(
					'delivery_day'  => array(
						array(
							'combination' => array(),
							'code'        => '4944',
							'options'     => array()
						)
					),
					'pickup_points' => array(
						'4944' => array(),
					),
				),
				'ROW' => array(
					'delivery_day'  => array(
						array(
							'combination' => array(),
							'code'        => '4945',
							'options'     => array()
						)
					),
					'pickup_points' => array(
						array(
							'combination' => array(),
							'code'        => '4945',
							'options'     => array()
						)
					),
				)
			),
			'BE' => array(
				'BE'  => array(
					'delivery_day'  => array(
						array(
							'combination' => array(),
							'code'        => '4961',
							'options'     => array()
						),
						array(
							'combination' => array( 'only_home_address' ),
							'code'        => '4960',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery' ),
							'code'        => '4963',
							'options'     => array()
						),
						array(
							'combination' => array( 'signature_on_delivery', 'only_home_address' ),
							'code'        => '4962',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping', 'only_home_address' ),
							'code'        => '4965',
							'options'     => array()
						)
					),
					'pickup_points' => array(
						array(
							'combination' => array(),
							'code'        => '4880',
							'options'     => array()
						),
						array(
							'combination' => array( 'insured_shipping' ),
							'code'        => '4878',
							'options'     => array()
						)
					),
				),
				'NL'  => array(
					'delivery_day' => array(
						array(
							'combination' => array( 'track_and_trace' ),
							'code'        => '4907',
							'options'     => array()
						)
					),
				),
				'EU'  => array(
					'delivery_day' => array(
						array(
							'combination' => array( 'track_and_trace' ),
							'code'        => '4907',
							'options'     => array()
						)
					),
				),
				'ROW' => array(
					'delivery_day' => array(),
				),
			)
		);
	}

	/**
	 * Label type mapping.
	 *
	 * @return Array
	 */
	public static function label_type_list() {
		return array(
			'NL' => array(
				// Return label is added here since smart return is not implemented yet.
				// If smart return is implemented, we might need to remove return-label from this list.
				'NL'  => array( 'label', 'return-label', 'buspakjeextra', 'printcodelabel' ),
				'BE'  => array( 'label' ),
				'EU'  => array( 'label' ),
				'ROW' => array( 'cn23', 'cp71' ),
			),
			'BE' => array(
				'BE'  => array( 'label' ),
				'NL'  => array( 'label' ),
				'EU'  => array( 'label' ),
				'ROW' => array( 'cn23', 'cp71' ),
			),
		);
	}

	/**
	 * Product code mapping.
	 *
	 * @return Array
	 */
	public static function option_available_list() {
		return array(
			'NL' => array(
				'NL'  => array( 'create_return_label', 'num_labels' ),
				'BE'  => array( 'create_return_label', 'num_labels' ),
				'EU'  => array( 'num_labels' ),
				'ROW' => array( 'num_labels' ),
			),
			'BE' => array(
				'BE'  => array( 'num_labels' ),
				'NL'  => array( 'num_labels' ),
				'EU'  => array( 'num_labels' ),
				'ROW' => array( 'num_labels' ),
			),
		);
	}

	/**
	 * Product options mapping.
	 *
	 * @return array
	 */
	public static function product_options() {
		return array(
			'NL' => array(
				'NL' => array(
					'frontend_data' => array(
						'delivery_day' => array(
							'type' => array(
								'Evening'     => array(
									'characteristic' => '118',
									'option'         => '006',
								),
								'08:00-12:00' => array(
									'characteristic' => '118',
									'option'         => '008',
								),
							),
						),
					),
				),
			),
		);
	}

	/**
	 * List of countries that available for checkout feature.
	 *
	 * @return Array.
	 */
	public static function available_country_for_checkout_feature() {
		return array(
			'NL' => array(
				'NL' => array( 'pickup_points', 'delivery_day', 'evening_delivery' ),
				'BE' => array( 'pickup_points', 'delivery_day' ),
			),
			'BE' => array(
				'BE' => array( 'pickup_points' ),
			),
		);
	}
}
