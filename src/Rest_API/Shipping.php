<?php
/**
 * Class Rest_API/Shipping file.
 *
 * @package PostNLWooCommerce\Rest_API
 */

namespace PostNLWooCommerce\Rest_API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Shipping
 *
 * @package PostNLWooCommerce\Rest_API
 */
class Shipping extends Base {
	/**
	 * API Endpoint.
	 *
	 * @var string
	 */
	public $endpoint = '/v1/shipment?confirm=true';

	/**
	 * Send API request to PostNL Rest API.
	 */
	public function send_request() {
		$api_url = esc_url( $this->get_api_url() );

		/*
		$request_args = array(
			'method'  => 'POST',
			'headers' => $this->get_headers_args(),
			'body'    => wp_json_encode(
				array(
					'Customer'  => array(
						'Address'            => array(
							'AddressType' => '02',
							'City'        => 'Hoofddorp',
							'CompanyName' => 'PostNL',
							'Countrycode' => 'NL',
							'HouseNr'     => '42',
							'Street'      => 'Siriusdreef',
							'Zipcode'     => '2132WT',
						),
						'CollectionLocation' => '1234506',
						'ContactPerson'      => 'Janssen',
						'CustomerCode'       => 'DEVC',
						'CustomerNumber'     => '11223344',
						'Email'              => 'email@company.com',
						'Name'               => 'Janssen',
					),
					'Message'   => array(
						'MessageID'        => '36209c3d-14d2-478f-85de-abccd84fa790',
						'MessageTimeStamp' => '28-04-2020 14:21:08',
						'Printertype'      => 'GraphicFile|PDF',
					),
					'Shipments' => array(
						array(
							'Addresses'           => array(
								array(
									'AddressType' => '01',
									'City'        => 'Utrecht',
									'Countrycode' => 'NL',
									'FirstName'   => 'Peter',
									'HouseNr'     => '9',
									'HouseNrExt'  => 'a bis',
									'Name'        => 'de Ruiter',
									'Street'      => 'Bilderdijkstraat',
									'Zipcode'     => '3532VA',
								),
							),
							'Contacts'            => array(
								array(
									'ContactType' => '01',
									'Email'       => 'receiver@email.com',
									'SMSNr'       => '+31612345678',
								),
							),
							'Dimension'           => array(
								'Weight' => '4300',
							),
							'ProductCodeDelivery' => '3085',
						),
					),
				)
			),
		);
		*/

		$request_args = array(
			'method'  => 'POST',
			'headers' => $this->get_headers_args(),
			'body'    => wp_json_encode(
				array(
					'Customer'  => array(
						'Address'            => array(
							'AddressType' => '02',
							'City'        => 'Hoofddorp',
							'CompanyName' => 'PostNL',
							'Countrycode' => 'NL',
							'HouseNr'     => '42',
							'Street'      => 'Siriusdreef',
							'Zipcode'     => '2132WT',
						),
						'CollectionLocation' => '1234506',
						'ContactPerson'      => 'Janssen',
						'CustomerCode'       => 'DEVC',
						'CustomerNumber'     => '11223344',
						'Email'              => 'email@company.com',
						'Name'               => 'Janssen',
					),
					'Message'   => array(
						'MessageID'        => '36209c3d-14d2-478f-85de-abccd84fa790',
						'MessageTimeStamp' => '28-04-2020 14:21:08',
						'Printertype'      => 'GraphicFile|PDF',
					),
					'Shipments' => array(
						array(
							'Addresses'           => array(
								array(
									'AddressType' => '01',
									'City'        => 'Utrecht',
									'Countrycode' => 'NL',
									'FirstName'   => 'Peter',
									'HouseNr'     => '9',
									'HouseNrExt'  => 'a bis',
									'Name'        => 'de Ruiter',
									'Street'      => 'Bilderdijkstraat',
									'Zipcode'     => '3532VA',
								),
							),
							'Contacts'            => array(
								array(
									'ContactType' => '01',
									'Email'       => 'receiver@email.com',
									'SMSNr'       => '+31612345678',
								),
							),
							'Dimension'           => array(
								'Weight' => '4300',
							),
							'ProductCodeDelivery' => '3085',
						),
					),
				)
			),
		);

		$response = wp_remote_request( $api_url, $request_args );
		$body     = wp_remote_retrieve_body( $response );

		return $body;
	}

	/**
	 * Get shipping address info from the WC Cart data.
	 *
	 * @return array
	 */
	public function get_shipping_address() {
		$address = array(
			'AddressType' => '01',
		);

		$address['Street']      = ( ! empty( $this->post_data['shipping_address_1'] ) ) ? $this->post_data['shipping_address_1'] : '';
		$address['HouseNr']     = ( ! empty( $this->post_data['shipping_address_2'] ) ) ? $this->post_data['shipping_address_2'] : '';
		$address['HouseNrExt']  = '';
		$address['Zipcode']     = ( ! empty( $this->post_data['shipping_postcode'] ) ) ? $this->post_data['shipping_postcode'] : '';
		$address['City']        = ( ! empty( $this->post_data['shipping_city'] ) ) ? $this->post_data['shipping_city'] : '';
		$address['CountryCode'] = ( ! empty( $this->post_data['shipping_country'] ) ) ? $this->post_data['shipping_country'] : '';

		return $address;
	}
}
