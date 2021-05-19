<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Handlers;

use LSVH\WordPress\Plugin\WPCF7CMS\Components\Handlers;
use LSVH\WordPress\Plugin\WPCF7CMS\Tests\BaseTest;
use LSVH\WordPress\Plugin\WPCF7CMS\Tests\Stubs\FormStub;
use LSVH\WordPress\Plugin\WPCF7CMS\Tests\Stubs\SubmissionStub;

abstract class HandlerTest extends BaseTest
{
    const BASE_PREFIX = Handlers::PREFIX;
    const META_PREFIX = Handlers::META_PREFIX;

    protected $submission;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadWordPress();
    }

    public function setUp(): void
    {
        $form = new FormStub();
        $this->submission = new SubmissionStub($form);
    }
}
