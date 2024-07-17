<?php
/*
Plugin Name: Assets Management
Plugin URI: tawhid.com
Description: This plugin manages the assets (CSS and JS) for both the admin and public areas of a WordPress site.
Version: 1.0.0
Author: Your Name
Author URI: https://example.com
Text Domain: assetsmanagement
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( "AM_PUBLIC_DIR", plugin_dir_url( __FILE__ ) . "/public" );
define( "AM_ADMIN_DIR", plugin_dir_url( __FILE__ ) . "/admin" );

class AssetManagement {

    private $version;

    public function __construct() {
        $this->version = time();
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( "wp_enqueue_scripts", array( $this, 'load_public_assets' ) );
        add_action( "admin_enqueue_scripts", array( $this, 'load_admin_assets' ) );
    }

    public function load_public_assets() {
        wp_enqueue_script( 'am-public-custom-css', AM_PUBLIC_DIR . '/css/custom.css', null, $this->version );
        wp_enqueue_script( 'am-public-custom-js', AM_PUBLIC_DIR . '/js/custom.js', array( 'jquery' ), $this->version, true );
    }

    public function load_admin_assets($screen) {
        
        $_current_screen = get_current_screen();

        if('edit.php' == $screen &&  ('page' == $_current_screen->post_type || 'post' == $_current_screen->post_type )){
            wp_enqueue_script( 'am-admin-custom-css', AM_ADMIN_DIR . '/css/custom.css', null, $this->version );
            wp_enqueue_script( 'am-admin-custom-js', AM_ADMIN_DIR . '/js/custom.js', array( 'jquery' ), $this->version, true );
        }
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'assetmanagement', false, plugin_dir_url( __FILE__ ) . '/languages');
    }
}

new AssetManagement();
