<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS\Components;

use LSVH\WordPress\Plugin\Wpcf7CMS\Plugin;

abstract class BaseComponent implements Component
{
    protected $plugin;
    protected $settings;
    protected $submission;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    public function install()
    {
        add_filter('wpcf7_default_value', [$this, 'loadDefaultValue'], 10, 2);
        add_filter('wpcf7_default_values', [$this, 'loadDefaultValues'], 10, 2);
        add_action('wpcf7_before_send_mail', function ($form) {
            $this->settings = $this->parseSettings($form);
            if ($this->shouldLoadServerSideLogic()) {
                $this->submission = $this->parseSubmission($_POST);
                $this->loadServerSideLogic();
            }
        });
    }

    protected function getSetting($key)
    {
        return array_key_exists($key, $this->settings) ? $this->settings[$key] : false;
    }

    protected function parseSettings($values)
    {
        $additional_settings = array_filter(explode("\n", $values));

        $result = [];
        foreach ($additional_settings as $additional_setting) {
            [$key, $value] = explode(':', $additional_setting);
            $value = strtolower(trim($value));
            $value = is_string($value) && in_array($value, ['on', '1', 'true']) ? true : $value;
            $value = is_string($value) && in_array($value, ['off', '0', 'false']) ? false : $value;
            $result[trim($key)] = $value;
        }

        return $result;
    }

    protected function getSubmission($key) {
        return array_key_exists($key, $this->submission) ? $this->submission[$key] : null;
    }

    protected function parseSubmission($values) {
        return array_map(function ($value) {
            return mysql_real_escape_string($value);
        }, $values);
    }
}
