<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $wordpressBaseDir = dirname(
            // ./wp-content
            dirname(
                // ./wp-content/plugins
                dirname(
                    // ./wp-content/plugins/this-plugin
                    dirname(
                        // ./wp-content/plugins/this-plugin/tests
                        __DIR__
                    )
                )
            )
        );

        /** Make WordPress think we're sending a GET request */
        $_SERVER['REQUEST_METHOD'] = "GET";

        /** Loads the WordPress Environment and Template */
        require_once $wordpressBaseDir . '/wp-blog-header.php';
    }

    public static function log($anything) {
        fwrite(STDOUT, var_export($anything));
    }
}
