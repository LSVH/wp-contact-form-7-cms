<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class UserTest extends SourceTest
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadTestUser();
    }

    /** @test */
    public function by_user()
    {
        $this->form->set_properties([
            'form' =>
            '[select testing data:wp_user?login=' . self::USERNAME . ']',
        ]);

        $actual = $this->form->form_elements();

        $value = get_current_user_id();
        $label = self::USERNAME;
        $this->assertStringContainsString('<option value="' . $value . '">' . $label . '</option>', $actual);
    }
}
