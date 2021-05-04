<?php

namespace LSVH\WordPress\Plugin\Wpcf7CMS\Components;

class UserForm extends BaseComponent
{
    const FEATURE_NAME = 'edit_profile';
    const META_PREFIX = 'user_meta_';

    private static $keysCoreValues = [
        "user_login", "user_nicename", "user_pass", "user_url", "user_email",
        "display_name", "nickname", "first_name", "last_name", "description", "locale",
    ];

    public function loadDefaultValue($value, $tag)
    {
        return $this->searchValue($tag->name, $value);
    }

    public function loadDefaultValues($values, $tag)
    {
        $values = $this->searchValue($tag->name, $values);

        return is_array($values) ? $values : [$values];
    }

    private function searchValue($key, $fallback = null)
    {
        $user = wp_get_current_user();
        if (in_array($key, self::$keysCoreValues)) {
            return $user->get($key);
        }

        $meta_key = substr($key, strlen(self::META_PREFIX));
        if ($user->has_prop($meta_key)) {
            return $user->get($meta_key);
        }

        return $fallback;
    }

    public function shouldLoadServerSideLogic()
    {
        return $this->getSetting(self::FEATURE_NAME);
    }

    public function loadServerSideLogic()
    {
        if (current_user_can('read')) {
            $this->updateCoreValues();
            $this->updateMetaValues();
        }
    }

    private function updateCoreValues()
    {
        $values = $this->getCoreValues();
        $user_id = get_current_user_id();
        if (!empty($values) && $user_id) {
            $values['ID'] = $user_id;
            wp_update_user($values);
        }
    }

    private function getCoreValues()
    {
        return array_filter($this->submission, function ($key) {
            return in_array(strtolower(trim($key)), self::$keysCoreValues);
        }, ARRAY_FILTER_USE_KEY);
    }

    private function updateMetaValues()
    {
        $values = $this->getMetaValues();
        $user_id = get_current_user_id();
        if (!empty($values) && $user_id) {
            foreach ($values as $key => $value) {
                update_user_meta($user_id, $key, $value);
            }
        }
    }

    private function getMetaValues()
    {
        return array_filter($this->submission, function ($key) {
            return substr(strtolower(trim($key)), 0, strlen(self::META_PREFIX)) === self::META_PREFIX;
        }, ARRAY_FILTER_USE_KEY);
    }
}
