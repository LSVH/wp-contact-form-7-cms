<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Handlers;

class EditProfile extends BaseHandler
{
    const PREFIX = 'user_';
    const ID_KEY = 'ID';
    const PASS_KEY = 'pass';

    public static $fieldMapping = [
        'nicename' => 'user_nicename',
        'url' => 'user_url',
        'email' => 'user_email',
        'display_name' => 'display_name',
        'nickname' => 'nickname',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'description' => 'description',
    ];

    public function getPrefix() {
        return self::PREFIX;
    }

    public function execute($entity, $entity_meta = [])
    {
        $id = get_current_user_id();

        if (!empty($id)) {
            if (self::shouldProcessData($entity)) {
                $this->updateUser($id, $entity);
                $this->updateUserPass($id, $entity);
            }

            if (self::shouldProcessData($entity_meta)) {
                $this->updateUserMeta($id, $entity_meta);
            }
        }
    }

    private function updateUser($id, $data)
    {
        $update = [];
        foreach ($data as $key => $value) {
            if (array_key_exists($key, self::$fieldMapping)) {
                $update[self::$fieldMapping[$key]] = $value;
            }
        }

        if (!empty($update)) {
            $update[self::ID_KEY] = $id;
            wp_update_user($update);
        }
    }

    private function updateUserPass($id, $data)
    {
        if (array_key_exists(self::PASS_KEY, $data)) {
            wp_set_password($data[self::PASS_KEY], $id);
        }
    }

    private function updateUserMeta($id, $data)
    {
        foreach ($data as $key => $value) {
            update_user_meta($id, $key, $value);
        }
    }
}
