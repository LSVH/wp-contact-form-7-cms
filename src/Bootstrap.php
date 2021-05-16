<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS;

use LSVH\WordPress\Plugin\Wpcf7CMS\Components\Modules;

class Bootstrap
{
    private $plugin;

    public function __construct($file)
    {
        $this->plugin = new Plugin($file);
    }

    public function exec()
    {
        if ($this->isInactivePlugin('contact-form-7/wp-contact-form-7.php')) {
            $this->throwMissingDependency('Contact Form 7', 'contact-form-7');
            return false;
        }

        $components = [
            // Remove after PR's are accepted: https://github.com/takayukister/contact-form-7/pulls?q=416+417
            Modules::class,
        ];

        foreach ($components as $component) {
            (new $component($this->plugin))->install();
        }

        return true;
    }

    protected function throwMissingDependency($dependencyName, $dependencyDomain)
    {
        $domain = $this->plugin->getDomain();
        $name = $this->plugin->getName();
        $link = function ($label, $href) {
            return '<a href="plugin-install.php?tab=plugin-information&plugin=' . $href . '">' . $label . '</a>';
        };
        $error = new \WP_Error(
            'missing_dependency',
            sprintf(
                __('The plugin %s depends on %s, please install and active the plugin.', $domain),
                $link($name, $domain),
                $link($dependencyName, $dependencyDomain)
            )
        );

        add_action('admin_notices', function () use ($error) {
            printf('<div class="notice notice-error"><p>%s</p></div>', $error->get_error_message());
        });

    }

    protected function isInactivePlugin($plugin)
    {
        return !in_array($plugin, get_option('active_plugins'));
    }
}
