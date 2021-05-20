<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

use LSVH\WordPress\Plugin\WPCF7CMS\Tests\BaseTest;
use LSVH\WordPress\Plugin\WPCF7CMS\Components\Sources;

abstract class SourceTest extends BaseTest
{
    protected $form;

    const SEPARATOR = Sources::SEPARATOR;
    const VALUE_SEPARATOR = Sources::VALUE_SEPARATOR;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadWordPress();
    }

    public function setUp(): void
    {
        $this->form = \WPCF7_ContactForm::get_template();
    }

    protected function addSelectToForm($options) {
        $options = is_array($options) ? explode(' ', $options) : $options;
        $this->form->set_properties([
            'form' => '[select testing ' . $options . ']',
        ]);
    }
}
