<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS;

use LSVH\WordPress\Plugin\Wpcf7CMS\Components\UserForm;

class Bootstrap
{
    private $plugin;

    public function __construct($file)
    {
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $this->plugin = new Plugin(get_plugin_data($file, false));
    }

    public function exec()
    {
        $components = [
            new UserForm($this->plugin),
        ];

        foreach ($components as $component) {
            $component->install();
        }
    }
}
