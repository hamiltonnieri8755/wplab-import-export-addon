<?php
/**
 * Plugin Name: WPLab Import/Export Plugin
 * Plugin URI: https://www.wplab.com/
 * Description: WPLab tool that helps you import/export wplister data
 * Version: 1.0
 * Author: Hamilton Nieri
 * Author URI: https://www.wplab.com/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * ----------------------------------------------------------------------
 * Copyright (C) 2016  Hamilton Nieri  (Email: hamiltonnieri8755@yahoo.com)
 * ----------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * ----------------------------------------------------------------------
 */

// Including WP core file
if ( ! function_exists( 'get_plugins' ) )
    require_once ABSPATH . 'wp-admin/includes/plugin.php';

// Including base class
if ( ! class_exists( 'WPL_Import_Export_CSV' ) )
    require_once plugin_dir_path( __FILE__ ) . 'classes/class-wpl-import-export-csv.php';

// Whether plugin active or not
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) :

	add_action('admin_menu', 'wpl_import_export_register_menu');
 	
 	function wpl_import_export_register_menu() {
 		add_submenu_page(
		    'wplister',  
		    'Import / Export',
		    'Import / Export',
		    'manage_options',
		    'wpl-import-export-page',
		    'wpl_import_export_page_callback'
		);
 	}

 	$wpl_csv = new WPL_Import_Export_CSV();

 	function wpl_import_export_page_callback() {
 		global $wpl_csv;
 		$wpl_csv->output_page_content();
 	}

 	add_action('init', 'wpl_import_export_init'); 

 	function wpl_import_export_init() {

 		if ( isset($_POST['addon_action']) ) {
 			
 			global $wpl_csv;
 			
 			switch ( $_POST['addon_action'] ) {
 				
 				case 'export_order':
 					// One Order Per Row
 					$wpl_csv->export_order_csv();
 					break;
 				
 				case 'export_orderitem':
 					// One Order Item Per Row
 					$wpl_csv->export_orderitem_csv();
 					break;

 				case 'import_order':
 					// Import CSV
 					$wpl_csv->import_order_csv();
 					break;
 
 				default:
 					break;
 			}
 		}
 	}

endif;