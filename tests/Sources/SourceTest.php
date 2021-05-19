<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

use LSVH\WordPress\Plugin\WPCF7CMS\Tests\BaseTest;

abstract class SourceTest extends BaseTest
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadWordPress();
    }

    public function setUp(): void
    {
        $this->form = \WPCF7_ContactForm::get_template();
    }
}
