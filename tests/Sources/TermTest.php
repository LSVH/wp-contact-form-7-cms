<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Tests\Sources;

class TermTest extends SourceTest
{
    const OPTION = 'data:wp_term' . self::SEPARATOR;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::loadTerms();
    }

    /** @test */
    public function by_taxonomy()
    {
        $args = 'taxonomy=' . self::TAXONOMY . '&hide_empty=0';
        $this->addSelectToForm(self::OPTION . $args);

        $actual = $this->form->form_elements();

        foreach (self::$terms as $term) {
            $value = self::getTermId($term);
            $label = $term['name'];
            $this->containsSelectOption($value, $label, $actual);
        }
    }
}
