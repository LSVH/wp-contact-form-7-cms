<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Stubs;

class SubmissionStub {
    private $form;
    private $posted_data;

    public function __construct($form) {
        $this->form = $form;
    }

    public function set_posted_data($posted_data) {
        $this->posted_data = $posted_data;
    }

    public function get_posted_data() {
        return $this->posted_data;
    }

    public function proceed()
    {
        do_action('wpcf7_before_send_mail', $this->form, false, $this);
    }
}
