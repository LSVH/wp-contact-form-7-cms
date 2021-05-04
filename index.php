<?php

/**
 * Plugin Name: Contact Form 7: CMS Integration
 * Plugin URI: https://github.com/LSVH/wp-contact-form-7-cms
 * Description: Classify an WordPress user.
 * Version: 0.1.1
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Author: LSVH
 * Author URI: https://lsvh.org/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: contact-form-7-cms
 * Domain Path: /languages
 */

$autoloader = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloader)) {
    die('Autoloader not found.');
}

require $autoloader;

use LSVH\WordPress\Plugin\Wpcf7CMS\Bootstrap;

$boot = new Bootstrap(__FILE__);
$boot->exec();
