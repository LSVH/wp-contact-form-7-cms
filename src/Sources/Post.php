<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Sources;

class Post extends BaseSource
{
    public function query($args = '')
    {
        $posts = [];

        $loop = new \WP_Query($args);

        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();
                $posts[get_the_ID()] = get_the_title();
            }
        }
        wp_reset_postdata();

        return $posts;
    }
}
