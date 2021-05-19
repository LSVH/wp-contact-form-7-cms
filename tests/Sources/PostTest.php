<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class PostTest extends SourceTest
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadPosts();
    }

    /** @test */
    public function by_post_type()
    {
        $this->form->set_properties([
            'form' =>
            '[select testing data:wp_post?post_type=' . self::POST_TYPE . '&order=ASC&orderby=title]',
        ]);

        $actual = $this->form->form_elements();

        foreach (self::$posts as $post) {
            $value = self::getPostId($post);
            $label = $post['post_title'];
            $this->assertStringContainsString('<option value="' . $value . '">' . $label . '</option>', $actual);
        }
    }
}
