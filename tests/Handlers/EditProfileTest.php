<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Handlers;

use LSVH\WordPress\Plugin\WPCF7CMS\Handlers\EditProfile;

final class EditProfileTest extends HandlerTest
{
    const PREFIX = self::BASE_PREFIX . EditProfile::PREFIX;
    const META_KEY = 'test';

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadTestUser();
    }

    public function tearDown(): void
    {
        $this->resetTestUser();
    }

    /**
     * @test
     * @dataProvider user_fields
     */
    public function can_update_user_field($field, $expected = 'foo')
    {
        $field = $field;
        $posted_data = [];
        $expected = $posted_data[self::PREFIX . $field] = $expected;
        $this->submission->set_posted_data($posted_data);

        $actual = $this->getFromCurrentUser($field);
        $this->assertNotEquals($expected, $actual);

        $this->submission->proceed();

        $actual = $this->getFromCurrentUser($field);
        $this->assertEquals($actual, $expected);
    }

    public function user_fields()
    {
        return [
            'nicename' => ['nicename'],
            'url' => ['url', 'http://foo.bar'],
            'email' => ['email', 'foo@bar.com'],
            'display_name' => ['display_name'],
            'nickname' => ['nickname'],
            'first_name' => ['first_name'],
            'last_name' => ['last_name'],
            'description' => ['description'],
            'meta (string value)' => [self::META_PREFIX . self::META_KEY],
            'meta (array value)' => [self::META_PREFIX . self::META_KEY, ['foo', 'bar']],
        ];
    }

    /** @test */
    public function can_update_user_pass()
    {
        $field = EditProfile::PASS_KEY;
        $posted_data = [];
        $expected = $posted_data[self::PREFIX . $field] = 'foo';
        $this->submission->set_posted_data($posted_data);

        $actual = $this->getFromCurrentUser($field);
        $this->assertFalse(wp_check_password($expected, $actual));

        $this->submission->proceed();

        $actual = $this->getFromCurrentUser($field);
        $this->assertTrue(wp_check_password($expected, $actual));
    }

    private function resetTestUser()
    {
        $id = username_exists(self::USERNAME);
        $user = [
            'ID' => $id,
            'user_nicename' => '',
            'user_url' => '',
            'user_email' => '',
            'display_name' => '',
            'nickname' => '',
            'first_name' => '',
            'last_name' => '',
            'description' => '',
        ];
        wp_update_user($user);
        wp_set_password(self::PASSWORD, $id);
        update_user_meta($id, self::META_KEY, '');
    }

    private function getFromCurrentUser($field)
    {
        $this->reloadCurrentUser();
        $user = wp_get_current_user();

        $fields = array_merge($user->to_array(), [
            self::META_PREFIX . self::META_KEY => get_user_meta($user->ID, self::META_KEY, true),
        ]);

        $mappedFields = array_merge(EditProfile::$fieldMapping, [
            EditProfile::PASS_KEY => 'user_pass',
        ]);
        if (array_key_exists($field, $mappedFields)) {
            $field = $mappedFields[$field];
        }

        return array_key_exists($field, $fields) ? $fields[$field] : $user->$field;
    }

    private function reloadCurrentUser()
    {
        global $current_user;
        $current_user = null;
        wp_set_current_user(null, self::USERNAME);
    }
}
