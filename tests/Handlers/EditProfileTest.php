<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Handlers;

use LSVH\WordPress\Plugin\WPCF7CMS\Handlers\EditProfile;

final class EditProfileTest extends HandlerTest
{
    const PREFIX = self::BASE_PREFIX . EditProfile::PREFIX;

    protected static $testString = 'foo';
    protected static $testArray = ['foo', 'bar'];
    protected static $testUser;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$testUser = self::$users[0];
        self::loadUsers();
        self::loadUserMeta(self::$testUser);
    }

    /**
     * @test
     * @dataProvider userValues
     */
    public function can_update_user_field($field, $expected = null)
    {
        $this->resetUser(self::$testUser);
        $this->resetUserMeta(self::$testUser);
        $posted_data = [];
        $expected = empty($expected) ? self::$testString : $expected;
        $expected = $posted_data[self::PREFIX . $field] = $expected;
        $this->submission->set_posted_data($posted_data);

        $actual = $this->getFromCurrentUser($field);
        $this->assertNotEquals($expected, $actual);

        $this->submission->proceed();

        $actual = $this->getFromCurrentUser($field);
        $this->assertEquals($actual, $expected);
    }

    /** @test */
    public function can_update_user_pass()
    {
        $this->resetUserPass(self::$testUser);
        $field = EditProfile::PASS_KEY;
        $posted_data = [];
        $expected = $posted_data[self::PREFIX . $field] = self::$testString;
        $this->submission->set_posted_data($posted_data);

        $actual = $this->getFromCurrentUser($field);
        $this->assertFalse(wp_check_password($expected, $actual));

        $this->submission->proceed();

        $actual = $this->getFromCurrentUser($field);
        $this->assertTrue(wp_check_password($expected, $actual));
    }

    public function userValues()
    {
        $user_values = [
            'nicename' => ['nicename'],
            'url' => ['url', 'http://foo.bar'],
            'email' => ['email', 'foo@bar.com'],
            'display_name' => ['display_name'],
            'nickname' => ['nickname'],
            'first_name' => ['first_name'],
            'last_name' => ['last_name'],
            'description' => ['description'],
        ];

        $user_meta_values = [];
        foreach (self::$meta as $item) {
            $key = $item['key'];
            $value = is_array($item['value']) ? self::$testArray : self::$testString;
            $user_meta_values['meta: "'.$key.'"'] = [self::META_PREFIX . $key, $value];
        }

        return array_merge($user_values, $user_meta_values);
    }

    private function getFromCurrentUser($field)
    {
        $this->reloadCurrentUser();
        $user = wp_get_current_user();
        $user_values = $user->to_array();

        $user_meta_values = [];
        foreach (self::$meta as $item) {
            $key = $item['key'];
            $user_meta_values[self::META_PREFIX . $key] = get_user_meta($user->ID, $key, true);
        }

        $values = array_merge($user_values, $user_meta_values);

        $mappedFields = array_merge(EditProfile::$fieldMapping, [
            EditProfile::PASS_KEY => 'user_pass',
        ]);
        if (array_key_exists($field, $mappedFields)) {
            $field = $mappedFields[$field];
        }

        return array_key_exists($field, $values) ? $values[$field] : $user->$field;
    }

    private function reloadCurrentUser()
    {
        global $current_user;
        $current_user = null;
        self::setCurrentUser(self::$testUser);
    }
}
