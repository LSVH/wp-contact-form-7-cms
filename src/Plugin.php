<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS;

class Plugin
{
    private $dir;
    private $name;
    private $domain;
    private $options;

    public function __construct(string $file)
    {
        $this->dir = untrailingslashit(dirname($file));

        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $data = get_plugin_data($file, false);

        $this->name = array_key_exists('Name', $data) ? $data['Name'] : 'default';
        $this->domain = array_key_exists('TextDomain', $data) ? $data['TextDomain'] : 'default';
        $this->options = get_option(esc_sql($this->domain), []);
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption(string $name)
    {
        return is_array($this->options) && array_key_exists($name, $this->options)
        ? $this->options[$name] : null;
    }

    public function setOption(string $name, $value)
    {
        // Make sure the `options` field is an array.
        if (!is_array($this->options)) {
            $this->options = [];
        }

        // Change the value locally and then in the database.
        $this->options[$name] = $value;
        update_option($name, $this->options);
    }
}
