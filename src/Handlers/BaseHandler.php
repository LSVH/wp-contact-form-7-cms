<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Handlers;

use LSVH\WordPress\Plugin\WPCF7CMS\Base;

abstract class BaseHandler extends Base implements Handler
{
    protected static function shouldProcessData($data) {
        return is_array($data) && !empty($data);
    }
}
