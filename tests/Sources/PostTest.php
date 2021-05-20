<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class PostTest extends SourceTest
{
    const OPTION = 'data:wp_post' . self::SEPARATOR;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadPosts();
    }

    /** @test */
    public function by_post_type()
    {
        $args = 'post_type=' . self::POST_TYPE . '&order=ASC&orderby=title';
        $this->addSelectToForm(self::OPTION . $args);

        $actual = $this->form->form_elements();

        foreach (self::$posts as $post) {
            $value = self::getPostId($post);
            $label = $post['post_title'];
            $this->containsSelectOption($value, $label, $actual);
        }
    }
}
