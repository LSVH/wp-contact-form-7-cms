<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Components;

use LSVH\WordPress\Plugin\WPCF7CMS\Handlers\EditProfile;

class Handlers extends BaseComponent
{
    const PREFIX = 'cms_';
    const META_PREFIX = 'meta_';

    public function install()
    {
        $handlers = [
            'edit_profile' => EditProfile::class,
        ];

        add_action('wpcf7_before_send_mail', function ($form, $abort, $submission) use ($handlers) {
            $posted_data = $submission->get_posted_data();
            foreach ($handlers as $setting => $handler) {
                if ($form->is_true($setting)) {
                    $instance = new $handler($this->plugin);
                    $prefix = self::PREFIX . $instance->getPrefix();
                    $entity = self::batchRemovePrefix($prefix, $posted_data);
                    $entity_meta = self::batchRemovePrefix($prefix . self::META_PREFIX, $posted_data);
                    $instance->execute($entity, $entity_meta);
                }
            }
        }, 10, 3);
    }

    private static function batchRemovePrefix($needle, $haystacks) {
        $filtered = array_filter($haystacks, function ($haystack) use ($needle) {
            return self::removePrefix($needle, $haystack) !== false;
        }, ARRAY_FILTER_USE_KEY);

        $formatted = [];
        foreach ($filtered as $key => $value) {
            $formatted[self::removePrefix($needle, $key)] = $value;
        }

        return $formatted;
    }

    private static function removePrefix($needle, $haystack)
    {
        $split = explode($needle, $haystack);
        [$shouldBeNull, $value] = count($split) <= 1 ? [null, null] : $split;
        return empty($shouldBeNull) && !empty($value) ? $value : false;
    }
}
