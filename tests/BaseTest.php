<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    const POST_TYPE = 'test-post';
    const TAXONOMY = 'test-taxonomy';

    protected static $users = [
        ['user_login' => 'test-user1', 'user_pass' => 'secret123'],
        ['user_login' => 'test-user2', 'user_pass' => '123secret'],
    ];

    protected static $posts = [
        ['post_type' => self::POST_TYPE, 'post_status' => 'publish', 'post_title' => 'Test Post 1'],
        ['post_type' => self::POST_TYPE, 'post_status' => 'publish', 'post_title' => 'Test Post 2'],
    ];

    protected static $terms = [
        ['taxonomy' => self::TAXONOMY, 'slug' => 'test-term-1', 'name' => 'Test Term 1'],
        ['taxonomy' => self::TAXONOMY, 'slug' => 'test-term-2', 'name' => 'Test Term 2'],
    ];

    protected static $meta = [
        ['key' => 'test_string', 'value' => 'hello'],
        ['key' => 'test_array', 'value' => ['hello', 'world']],
    ];

    public static function containsSelectOption($value, $label, $actual)
    {
        self::assertStringContainsString('<option value="' . $value . '">' . $label . '</option>', $actual);
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

    protected static function loadUsers()
    {
        self::loadEntities(self::$users, 'getUserId', function ($new) {
            print("\nInserting test user\n");
            wp_insert_user($new);
        });
    }

    protected static function getUserId($args)
    {
        return username_exists($args['user_login']);
    }

    protected static function setCurrentUser($args)
    {
        wp_set_current_user(self::getUserId($args));
    }

    protected static function resetUser($args)
    {
        $id = self::getUserId($args);
        $user = [
            'ID' => $id,
            'user_nicename' => '',
            'user_url' => '',
            'user_email' => '',
            'display_name' => '',
            'nickname' => '',
            'first_name' => '',
            'last_name' => '',
            'description' => '',
        ];
        wp_update_user($user);
    }

    protected static function resetUserPass($args) {
        $id = self::getUserId($args);
        wp_set_password($args['user_pass'], $id);
    }

    protected static function loadUserMeta($for = null)
    {
        $for = self::getUserId(empty($for) ? self::$users[0] : $for);
        self::loadMetaForEntities('user', $for);
    }

    protected static function resetUserMeta($for = null)
    {
        $for = self::getUserId(empty($for) ? self::$users[0] : $for);
        self::resetMetaForEntities('user', $for);
    }

    protected static function loadPosts()
    {
        self::loadEntities(self::$posts, 'getPostId', function ($new) {
            print("\nInserting test post\n");
            wp_insert_post($new);
        });
    }

    protected static function getPostId($args)
    {
        if (!function_exists('post_exists')) {
            require_once ABSPATH . 'wp-admin/includes/post.php';
        }

        return post_exists($args['post_title'], '', '', $args['post_type']);
    }

    protected static function loadPostMeta($for = null)
    {
        $for = self::getPostId(empty($for) ? self::$posts[0] : $for);
        self::loadMetaForEntities('post', $for);
    }

    protected static function resetPostMeta($for = null)
    {
        $for = self::getPostId(empty($for) ? self::$posts[0] : $for);
        self::resetMetaForEntities('post', $for);
    }

    protected static function loadTerms()
    {
        if (!taxonomy_exists(self::TAXONOMY)) {
            register_taxonomy(self::TAXONOMY, self::POST_TYPE);
        }

        self::loadEntities(self::$terms, 'getTermId', function ($new) {
            print("\nInserting test term\n");
            wp_insert_term($new['name'], $new['taxonomy'], [
                'slug' => $new['slug'],
            ]);
        });
    }

    protected static function getTermId($args)
    {
        $term = get_term_by('slug', $args['slug'], $args['taxonomy']);

        return is_object($term) ? $term->term_id : null;
    }

    protected static function loadTermMeta($for = null)
    {
        $for = self::getTermId(empty($for) ? self::$terms[0] : $for);
        self::loadMetaForEntities('term', $for);
    }

    protected static function resetTermMeta($for = null)
    {
        $for = self::getTermId(empty($for) ? self::$terms[0] : $for);
        self::resetMetaForEntities('term', $for);
    }

    private static function loadServerVariables()
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'GET',
            'SERVER_NAME' => 'localhost',
        ];
    }

    private static function loadMetaForEntities($type, $for)
    {
        self::resetMetaForEntities($type, $for, 'metaExists');
    }

    private static function metaExists($args)
    {
        return metadata_exists($args['type'], $args['for'], $args['key']);
    }

    private static function resetMetaForEntities($type, $for, $existsCallback = '')
    {
        $items = array_map(function ($item) use ($type, $for) {
            return array_merge([
                'type' => $type,
                'for' => $for,
            ], $item);
        }, self::$meta);

        $action = empty($existsCallback) ? null : 'Inserting';
        self::loadEntities($items, $existsCallback, function ($new) use ($action) {
            $type = $new['type'];
            if (!empty($action)) {
                print("\n$action test $type meta\n");
            }
            update_metadata($type, $new['for'], $new['key'], $new['value']);
        });
    }

    private static function loadEntities($items, $existsCallback, $createCallback)
    {
        $existsCallback = empty($existsCallback) ? null : get_called_class() . '::' . $existsCallback;
        $missing = empty($existsCallback) && !is_callable($existsCallback)
        ? $items
        : array_filter($items, function ($item) use ($existsCallback) {
            return !call_user_func($existsCallback, $item);
        });

        if (!empty($missing)) {
            foreach ($missing as $new) {
                $createCallback($new);
            }
        }
    }
}
