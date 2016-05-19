<?php
/**
 * @class         WPL_Import_Export_CSV
 * @since         
 * @package       WPL CSV Import / Export
 * @license       http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

//include "EbayController.php";
if ( ! class_exists( 'WPL_Import_Export_CSV' ) ) :

// To parse serialized object "details", it should require EBatNS classes

if ( ! class_exists('OrderType') ) {
	require_once WP_PLUGIN_DIR . '/wplab-import-export-addon/include/OrderType.php';
}

include_once ABSPATH . 'wp-admin/includes/media.php';
include_once ABSPATH . 'wp-admin/includes/file.php';
include_once ABSPATH . 'wp-admin/includes/image.php';
/**
 * WPL_Import_Export_CSV Class.
 */
class WPL_Import_Export_CSV {
	
	/**
     * Class constructor
     *
     * @access public
     * @param 
     */
    public function __construct() {
    	$this->wpl_enqueue();
    }

    /**
	 * Generate Export Page Content
	 *
	 * @access public
	 * @return 
	 */
	public function output_page_content() {
			
		include WP_PLUGIN_DIR . '/wplab-import-export-addon/views/import_export_csv_template.php';

	}

	/**
	 * Export Order CSV - One order per row
	 *
	 * @access public
	 * @return 
	 */
	public function export_order_csv() {

		global $wpdb;

		// Create Temporaray CSV file
		$filename = 'wpl-ebay-orders-'.date_i18n( "Y-m-d_H-i-s" ).'.csv';
		$filepath = $filename;
		$fp = fopen( $filepath, 'w' );

		// Generate Header Row
		$header = array();
		array_push( $header, "id" );
		array_push( $header, "order_id" );
		array_push( $header, "date_created" );
		array_push( $header, "total" );
		array_push( $header, "currency" );
		array_push( $header, "status" );
		array_push( $header, "post_id" );
		array_push( $header, "item_count" );
		array_push( $header, "sellingManagerSalesRecordNumber" );
		array_push( $header, "buyer_userid" );
		array_push( $header, "buyer_name" );
		array_push( $header, "buyer_email" );
		array_push( $header, "eBayPaymentStatus" );
		array_push( $header, "CheckoutStatus" );
		array_push( $header, "ShippingService" );
		array_push( $header, "PaymentMethod" );
		array_push( $header, "ShippingAddress_City" );
		array_push( $header, "CompleteStatus" );
		array_push( $header, "LastTimeModified" );
		array_push( $header, "account_id" );
		array_push( $header, "site_id" );
		array_push( $header, "tracking_number" );
		array_push( $header, "tracking_provider" );
		array_push( $header, "shipped_date" );
		
		fputcsv( $fp, $header );

		// Generate Data Rows
		
		$table_name = $wpdb->prefix . 'ebay_orders';
		
		$result = $wpdb->get_results( "SELECT * FROM $table_name" );
		
		foreach ( $result as $row ) {
			// Make a 
			$csv_data_row = array();
			array_push( $csv_data_row, $row->id );
			array_push( $csv_data_row, $row->order_id );
			array_push( $csv_data_row, $row->date_created );
			array_push( $csv_data_row, $row->total );
			array_push( $csv_data_row, $row->currency );
			array_push( $csv_data_row, $row->status );
			array_push( $csv_data_row, $row->post_id );
			array_push( $csv_data_row, $this->getItemCounts( $row->items ) );
			array_push( $csv_data_row, $this->getSellingManagerSalesRecordNumber( $row->details ) );
			array_push( $csv_data_row, $row->buyer_userid );
			array_push( $csv_data_row, $row->buyer_name );
			array_push( $csv_data_row, $row->buyer_email );
			array_push( $csv_data_row, $row->eBayPaymentStatus );
			array_push( $csv_data_row, $row->CheckoutStatus );
			array_push( $csv_data_row, $row->ShippingService );
			array_push( $csv_data_row, $row->PaymentMethod );
			array_push( $csv_data_row, $row->ShippingAddress_City );
			array_push( $csv_data_row, $row->CompleteStatus );
			array_push( $csv_data_row, $row->LastTimeModified );
			array_push( $csv_data_row, $row->account_id );
			array_push( $csv_data_row, $row->site_id );
			array_push( $csv_data_row, '' );
			array_push( $csv_data_row, '' );
			array_push( $csv_data_row, '' );

			// Write Each Data Row
			fputcsv( $fp, $csv_data_row );
		}

		fclose( $fp );

		// Download CSV
		header( 'Content-Type:application/octet-stream' );
		header( 'Content-Disposition:filename='.$filename );
		header( 'Content-Length:' . filesize( $filepath ) );
		readfile( $filepath );  

		// Delete temporary file
		unlink( $filepath );

		exit;
	}

	/**
	 * Export Order CSV - One order per row
	 *
	 * @access public
	 * @return 
	 */
	public function export_orderitem_csv() {

		global $wpdb;

		// Create Temporaray CSV file
		$filename = 'wpl-ebay-orderitems-'.date_i18n( "Y-m-d_H-i-s" ).'.csv';
		$filepath = $filename;
		$fp = fopen( $filepath, 'w' );

		// Generate Header Row
		$header = array();
		array_push( $header, "item_id" );
		array_push( $header, "title" );
		array_push( $header, "sku" );
		array_push( $header, "quantity" );
		array_push( $header, "transaction_id" );
		array_push( $header, "OrderLineItemID" );
		array_push( $header, "TransactionPrice" );
		array_push( $header, "OrderID" );
		array_push( $header, "DateCreated");
		
		fputcsv( $fp, $header );

		// Generate Data Rows
		
		$table_name = $wpdb->prefix . 'ebay_orders';
		
		$result = $wpdb->get_results( "SELECT * FROM $table_name" );
		
		foreach ( $result as $row ) {

			// One Order Item Per Row
			foreach( $this->decodeObject($row->items) as $item ) {

				$csv_data_row = array();

				array_push( $csv_data_row, $item['item_id'] );
				array_push( $csv_data_row, $item['title'] );
				array_push( $csv_data_row, $item['sku'] );
				array_push( $csv_data_row, $item['quantity'] );
				array_push( $csv_data_row, $item['transaction_id'] );
				array_push( $csv_data_row, $item['OrderLineItemID'] );
				array_push( $csv_data_row, $item['TransactionPrice'] );
				array_push( $csv_data_row, $row->order_id );
				array_push( $csv_data_row, $row->date_created );

				fputcsv( $fp, $csv_data_row );
			}		

		}

		fclose( $fp );

		// Download CSV
		header( 'Content-Type:application/octet-stream' );
		header( 'Content-Disposition:filename='.$filename );
		header( 'Content-Length:' . filesize( $filepath ) );
		readfile( $filepath );  

		// Delete temporary file
		unlink( $filepath );

		exit;
	}

	/**
     * Plugin script/style enqueue function
     *
     * @access public
     * @return void
     */
    public function wpl_enqueue() {
        wp_enqueue_style( 'wple-style-custom', plugins_url( 'css/style.css', dirname(__FILE__) ) );
        wp_enqueue_script( 'wple-script-main', plugins_url( 'js/custom_script.js', dirname(__FILE__) ), array(), '1.0.0', true);
    }

   	/**
     * Flexible object decoder from wplister-ebay
     *
     * @access public
     * @return void
     */
	public function decodeObject( $str, $assoc = false ) {

		if ( $str == '' ) return false; 

		if ( is_object($str) || is_array($str) ) return $str;

		// unserialize fallback
		$obj = maybe_unserialize( $str );
		
		if ( is_object($obj) || is_array($obj) ) return $obj;

		// json_decode
		$obj = json_decode( $str, $assoc );
		
		if ( is_object($obj) || is_array($obj) ) return $obj;
		
		// mb_unserialize fallback
		$obj = $this->mb_unserialize( $str );
		
		if ( is_object($obj) || is_array($obj) ) return $obj;

		return false;
	}	

   	/**
     * Flexible object decode helper from wplister-ebay
     *
     * @access public
     * @return void
     */
	public function mb_unserialize( $string ) {

		// special handling for asterisk wrapped in zero bytes
	    $string = str_replace( "\0*\0", "*\0", $string);
	    $string = @preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string); // added @ to avoid deprecated warning in PHP5.5 (TODO: fix)
	    $string = str_replace('*\0', "\0*\0", $string);

	    return unserialize($string);
	}

   	/**
     * Get SellingManageerSalesRecordNumber From Serialized Details Data
     *
     * @access public
     * @return void
     */
	public function getSellingManagerSalesRecordNumber( $details_data ) {

		$obj = $this->decodeObject( $details_data, false );

		if ( $obj == false ) return "0";
		
		$shippingDetails = $obj->getShippingDetails();
		
		if ( empty($shippingDetails) ) return "0";

		$sellingManagerSalesRecordNumber = $shippingDetails->getSellingManagerSalesRecordNumber();

		if ( empty($sellingManagerSalesRecordNumber) ) return "0";

		return $sellingManagerSalesRecordNumber; 
	}

	/**
     * Get Item Counts From Serialized Item Data
     *
     * @access public
     * @return void
     */
	public function getItemCounts( $item_data ) {

		$items = $this->decodeObject( $item_data, false );

		if ( empty( $items ) ) return 0;

		return sizeof( $items ); 
	}

	/**
	 * Import Order CSV - One order per row
	 *
	 * @access public
	 * @return 
	 */
	public function import_order_csv() {

		// Upload csv file to wordpress upload folder
	    
	    $uploadedfile = $_FILES['csv_file'];
		$upload_overrides = array( 'test_form' => false );
		
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		
		if ( ! $movefile || isset($movefile['error']) ) {
			die( $movefile['error'] );
		}
		
		// Parse csv file
		
		$file = fopen($movefile['file'],"r");
		
		$expected_headers = array(
			'id',
			'order_id',
			'date_created',
			'total',
			'currency',
			'status',
			'post_id',
			'item_count',
			'sellingManagerSalesRecordNumber',
			'buyer_userid',
			'buyer_name',
			'buyer_email',
			'eBayPaymentStatus',
			'CheckoutStatus',
			'ShippingService',
			'PaymentMethod',
			'ShippingAddress_City',
			'CompleteStatus',
			'LastTimeModified',
			'account_id',
			'site_id',
			'tracking_number',
			'tracking_provider',
			'shipped_date'
		);

		$csv_headers = fgetcsv($file);
		if ($csv_headers !== $expected_headers) {
			die( "The uploaded CSV is not WPLAB order CSV." );
		}
		
		while( ! feof( $file ) ) {
			// a line of csv string to array
			$data = fgetcsv( $file );
			$post_id = $data[0];

			// Extract tracking data from the current row
			$args = array();
			$args['TrackingNumber'] = $data[21];
			$args['TrackingCarrier'] = $data[22];
			$args['ShippedTime'] = $data[23];	// optional
			//$args['FeedbackText'] = $data[24];	// optional

			// Save tracking data as custom meta field
			if ( $args['TrackingNumber'] != '' ) {
				update_post_meta( $post_id, '_tracking_number', $args['TrackingNumber'] );
			}
			if ( $args['TrackingCarrier'] != '' ) {
				update_post_meta( $post_id, '_tracking_provider', $args['TrackingCarrier'] );
			}
			if ( $args['ShippedTime'] != '' ) {
				update_post_meta( $post_id, '_shipped_date', $args['ShippedTime'] );
			}

			// Mark order as shipped on ebay
			do_action('wple_complete_sales_on_ebay', $post_id, $args);
		}
		
		fclose($file);
		unlink($movefile['file']);
	}

}

endif;