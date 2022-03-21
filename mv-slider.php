<?php /** @noinspection PhpIncludeInspection */

/**
 * Plugin Name: MV Slider
 * Plugin URI: https://www.wordpress.org/mv-slider
 * Description: My plugin's description
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Marcelo Vieira
 * Author URI: https://www.codigowp.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mv-slider
 * Domain Path: /languages
 */

/*
MV Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
MV Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with MV Slider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('MV_Slider')) {
    class MV_Slider
    {
        function __construct()
        {
            $this->define_constants();
            add_action('admin_menu', [ $this, 'mv_slider_admin_menu' ]);

            require_once(MV_SLIDER_PATH . 'post-types/class.mv-slider-cpt.php');
            new MV_Slider_Post_Type();

            require_once(MV_SLIDER_PATH . 'mv-slider-settings.php');
            new MV_Slider_Settings();

            require_once(MV_SLIDER_PATH . 'shortcodes/mv-slider_shortcode.php');
            new MV_Slider_Shortcode();

            add_action( 'wp_enqueue_scripts', [$this, 'register_scripts'], 1000);
        }

        public function register_scripts() {
            wp_register_script(
                'mv-slider-flex-js',
                MV_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js',
                    ['jquery'],
                MV_SLIDER_VERSION,
                true
            );

            wp_register_script(
                'mv-slider-options-js',
                MV_SLIDER_URL . 'vendor/flexslider/flexslider.js',
                ['jquery'],
                MV_SLIDER_VERSION,
                true
            );

            wp_register_style(
                'mv-slider-flexslider-css',
                MV_SLIDER_URL . 'vendor/flexslider/flexslider.css',
                [],
                MV_SLIDER_VERSION,
                'all'
            );

            wp_register_style(
                'mv-slider-flexslider-front-css',
                MV_SLIDER_URL . 'assets/css/flexslider-frontend.css',
                [],
                MV_SLIDER_VERSION,
                'all'
            );
        }

        public function mv_slider_admin_menu(){
            add_menu_page(
                'MV Slider Options',
                'MV Slider',
                'manage_options',
                'mv_slider_settings',
                [ $this, 'mv_slider_settings_page' ],
                'dashicons-images-alt2',
                10
            );

            add_submenu_page(
                'mv_slider_settings',
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=mv-slider',
                null
            );

            add_submenu_page(
                'mv_slider_settings',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=mv-slider',
                null
            );
        }

        public function mv_slider_settings_page() {
            if ( ! current_user_can( 'manage_options' )){
                return;
            }
            if ( isset ( $_GET['settings-updated'])) {
                add_settings_error( 'mv_slider_options', 'mv_slider_message', 'Settings Saved', 'success');
            }
            settings_errors( 'mv_slider_options' );
            require_once(MV_SLIDER_PATH . 'views/mv-slider_settings_page.php');
        }



        public function define_constants()
        {
            define('MV_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('MV_SLIDER_URL', plugin_dir_url(__FILE__));
            define('MV_SLIDER_VERSION', '1.0.0');
        }

        public static function activate()
        {
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('mv-slider');
        }

        public static function uninstall()
        {

        }

    }
}

if (class_exists('MV_Slider')) {
    register_activation_hook(__FILE__, array('MV_Slider', 'activate'));
    register_deactivation_hook(__FILE__, array('MV_Slider', 'deactivate'));
    register_uninstall_hook(__FILE__, array('MV_Slider', 'uninstall'));

    $mv_slider = new MV_Slider();
} 
