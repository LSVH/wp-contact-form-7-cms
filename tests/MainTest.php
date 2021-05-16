<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS\Tests;

final class IntegrationTests extends BaseTest {
    function test_if_the_plugin_is_active() {
        $thisPlugin = basename(dirname(__DIR__)) . '/index.php';
        $plugins = get_option('active_plugins');
        $this->assertTrue(in_array($thisPlugin, $plugins));
    }
}
