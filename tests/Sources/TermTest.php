<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class TermTest extends SourceTest
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadTerms();
    }

    /** @test */
    public function by_taxonomy()
    {
        $this->form->set_properties([
            'form' =>
            '[select testing data:wp_term?taxonomy=' . self::TAXONOMY . '&hide_empty=0]',
        ]);

        $actual = $this->form->form_elements();

        foreach (self::$terms as $term) {
            $value = self::getTermId($term);
            $label = $term['name'];
            $this->assertStringContainsString('<option value="' . $value . '">' . $label . '</option>', $actual);
        }
    }
}
