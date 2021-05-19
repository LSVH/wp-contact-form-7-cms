<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Components;

use LSVH\WordPress\Plugin\WPCF7CMS\Sources\Post;
use LSVH\WordPress\Plugin\WPCF7CMS\Sources\Term;

class Sources extends BaseComponent
{
    const SEPARATOR = '?';

    public function install()
    {
        $sources = [
            'wp_post' => Post::class,
            'wp_term' => Term::class,
        ];

        add_filter('wpcf7_form_tag_data_option', function ($items, $options) use ($sources) {
            $items = is_array($items) ? $items : [];
            foreach ($options as $option) {
                $source = self::getSource($option);
                if (array_key_exists($source, $sources)) {
                    $fqdn = $sources[$source];
                    $instance = new $fqdn($this->plugin);
                    $query = self::getQuery($option);
                    $items = $instance->query($query);
                }
            }
            return $items;
        }, 10, 2);
    }

    private static function getSource($value)
    {
        $segments = explode(self::SEPARATOR, $value);
        return is_array($segments) && array_key_exists(0, $segments)
        ? $segments[0] : null;
    }

    private static function getQuery($value)
    {
        return substr($value, strpos($value, self::SEPARATOR) + 1);
    }
}
