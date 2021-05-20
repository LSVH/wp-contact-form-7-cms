<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Defaults;

class UserMeta extends DefaultTest
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self:loadTestUser();
    }
}
