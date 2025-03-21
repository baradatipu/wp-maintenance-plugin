<?php
/**
 * Plugin Name: Construction Mode
 * Plugin URI: #
 * Description: Enable construction/maintenance mode for your website with a beautiful 3D particle animated theme. Only admin users can access the site during maintenance.
 * Version: 1.0.0
 * Author: Tipu
 * Author URI: #
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: construction-mode
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('CONSTRUCTION_MODE_VERSION', '1.0.0');
define('CONSTRUCTION_MODE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CONSTRUCTION_MODE_PLUGIN_URL', plugin_dir_url(__FILE__));

class ConstructionMode {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Initialize plugin
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_loaded', array($this, 'check_maintenance_mode'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }

    public function init() {
        load_plugin_textdomain('construction-mode', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function activate() {
        // Set default options
        $default_options = array(
            'enabled' => false,
            'title' => 'Under Construction',
            'description' => 'We are currently working on improving our website. Please check back soon!',
            'logo' => '',
            'background_color' => '#000000',
            'text_color' => '#ffffff'
        );
        add_option('construction_mode_settings', $default_options);
    }

    public function deactivate() {
        // Cleanup if needed
    }

    public function uninstall() {
        delete_option('construction_mode_settings');
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Construction Mode', 'construction-mode'),
            __('Construction Mode', 'construction-mode'),
            'manage_options',
            'construction-mode',
            array($this, 'admin_page'),
            'dashicons-admin-tools'
        );
    }

    public function register_settings() {
        register_setting('construction_mode_settings', 'construction_mode_settings');
    }

    public function admin_scripts($hook) {
        if ('toplevel_page_construction-mode' !== $hook) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker', '', array('jquery'), false, true);
        wp_enqueue_script('construction-mode-admin', CONSTRUCTION_MODE_PLUGIN_URL . 'admin/js/admin.js', array('jquery', 'wp-color-picker'), CONSTRUCTION_MODE_VERSION, true);
    }

    public function check_maintenance_mode() {
        if (!is_admin() && !wp_doing_ajax()) {
            $options = get_option('construction_mode_settings');
            if ($options['enabled'] && !current_user_can('manage_options')) {
                $this->show_maintenance_page();
            }
        }
    }

    private function show_maintenance_page() {
        include_once CONSTRUCTION_MODE_PLUGIN_DIR . 'templates/maintenance.php';
        exit;
    }

    public function admin_page() {
        include_once CONSTRUCTION_MODE_PLUGIN_DIR . 'admin/settings.php';
    }
}

// Initialize the plugin
function construction_mode_init() {
    $construction_mode = ConstructionMode::get_instance();
}
add_action('plugins_loaded', 'construction_mode_init');

// Register activation, deactivation and uninstall hooks
register_activation_hook(__FILE__, array(ConstructionMode::get_instance(), 'activate'));
register_deactivation_hook(__FILE__, array(ConstructionMode::get_instance(), 'deactivate'));

// For uninstall hook, we need to use a static method or function
function construction_mode_uninstall() {
    delete_option('construction_mode_settings');
}
register_uninstall_hook(__FILE__, 'construction_mode_uninstall');