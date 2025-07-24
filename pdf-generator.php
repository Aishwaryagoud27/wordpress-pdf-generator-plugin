<?php
/**
 * Plugin Name: PDF Generator for WordPress
 * Description: Adds a "Download as PDF" button to posts or pages.
 * Version: 1.0
 * Author: Your Name
 */

defined('ABSPATH') or die('No script kiddies please!');

require_once plugin_dir_path(__FILE__) . 'includes/class-pdf-generator.php';

function pdf_generator_init() {
    $plugin = new PDF_Generator();
    $plugin->run();
}
add_action('plugins_loaded', 'pdf_generator_init');
