<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    const USERNAME = 'test';
    const PASSWORD = 'secret123';
    const POST_TYPE = 'test-post';
    const TAXONOMY = 'test-taxonomy';

    protected static $posts = [
        ['post_type' => self::POST_TYPE, 'post_status' => 'publish', 'post_title' => 'Test Post 1'],
        ['post_type' => self::POST_TYPE, 'post_status' => 'publish', 'post_title' => 'Test Post 2'],
    ];

    protected static $terms = [
        ['taxonomy' => self::TAXONOMY, 'slug' => 'test-term-1', 'name' => 'Test Term 1'],
        ['taxonomy' => self::TAXONOMY, 'slug' => 'test-term-2', 'name' => 'Test Term 2'],
    ];

    private static function loadServerVariables()
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'GET',
            'SERVER_NAME' => 'localhost',
        ];
    }

    protected static function loadWordPress()
    {
        self::loadServerVariables();
        $wordpressBaseDir = dirname(
            // ./wp-content
            dirname(
                // ./wp-content/plugins
                dirname(
                    // ./wp-content/plugins/my-plugin
                    dirname(
                        // ./wp-content/plugins/my-plugin/tests
                        __DIR__
                    )
                )
            )
        );

        require_once $wordpressBaseDir . '/wp-blog-header.php';
    }

    protected static function loadTestUser()
    {
        if (!username_exists(self::USERNAME)) {
            self::log('Created user, with username: ' . self::USERNAME);
            wp_create_user(self::USERNAME, self::PASSWORD);
        }

        wp_set_current_user(username_exists(self::USERNAME));
    }

    protected static function loadPosts()
    {
        if (!function_exists('post_exists')) {
            require_once ABSPATH . 'wp-admin/includes/post.php';
        }

        $missing_posts = array_filter(self::$posts, function ($post) {
            return empty(self::getPostId($post));
        });

        if (!empty($missing_posts)) {
            foreach ($missing_posts as $new_post) {
                wp_insert_post($new_post);
            }
        }
    }

    protected static function getPostId($args)
    {
        return post_exists($args['post_title'], '', '', $args['post_type']);
    }

    protected static function loadTerms()
    {
        if (!taxonomy_exists(self::TAXONOMY)) {
            register_taxonomy(self::TAXONOMY, self::POST_TYPE);
        }

        $missing_terms = array_filter(self::$terms, function ($term) {
            return empty(self::getTermId($term));
        });

        if (!empty($missing_terms)) {
            foreach ($missing_terms as $new_term) {
                $t = wp_insert_term($new_term['name'], $new_term['taxonomy'], [
                    'slug' => $new_term['slug'],
                ]);
            }
        }
    }

    protected static function getTermId($args)
    {
        $term = get_term_by('slug', $args['slug'], $args['taxonomy']);

        return is_object($term) ? $term->term_id : null;
    }
}
