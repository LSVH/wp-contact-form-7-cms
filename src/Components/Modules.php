<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Components;

class Modules extends BaseComponent
{
    public function install()
    {
        $dir = $this->plugin->getDir() . '/src/Modules';
        $this->loadModulesInDir($dir);
    }

    protected function loadModulesInDir($dir)
    {
        if (empty($dir) or !is_dir($dir)) {
            return false;
        }

        foreach (scandir($dir) as $file) {
            if (file_exists($dir . '/' . $file) && $this->endsWith($file, '.php')) {
                include_once $dir . '/' . $file;
            }
        }
    }

    protected function endsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}
