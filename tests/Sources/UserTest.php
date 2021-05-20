<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class UserTest extends SourceTest
{
    const OPTION = 'data:wp_user' . self::SEPARATOR;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadUsers();
    }

    /** @test */
    public function by_user()
    {
        $logins = [];
        foreach (self::$users as $user) {
            $logins[] = $user['user_login'];
        }

        $args = 'login__in=' . implode(self::VALUE_SEPARATOR, $logins);
        $this->addSelectToForm(self::OPTION . $args);

        $actual = $this->form->form_elements();

        foreach (self::$users as $user) {
            $value = self::getUserId($user);
            $label = $user['user_login'];
            $this->containsSelectOption($value, $label, $actual);
        }
    }
}
