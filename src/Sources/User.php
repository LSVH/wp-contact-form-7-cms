<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Sources;

class User extends BaseSource
{
    public function query($args)
    {
        $loop = new \WP_User_Query(array_merge($args, [
            'fields' => ['ID', 'display_name'],
        ]));

        $users = [];
        $results = $loop->get_results();
        if (!empty($results)) {
            foreach ($results as $user) {
                $users[$user->ID] = $user->display_name;
            }
        }

        return $users;
    }
}
