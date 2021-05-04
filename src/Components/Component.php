<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS\Components;

interface Component
{
    public function install();
    public function loadDefaultValue($value, $tag);
    public function loadDefaultValues($values, $tag);
    public function loadServerSideLogic();
    public function shouldLoadServerSideLogic();
}
