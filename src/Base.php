<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS;

abstract class Base
{
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }
}
