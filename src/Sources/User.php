<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Sources;

class User extends BaseSource
{
    public function query($args = '') {
        $loop = new \WP_Term_Query(array_merge(wp_parse_args($args), [
            'fields' => 'id=>name'
        ]));

        return $loop->get_terms();
    }
}
