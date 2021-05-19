<?php

namespace LSVH\WordPress\Plugin\WPCF7CMS\Handlers;

interface Handler
{
    public function getPrefix();
    public function execute($entity, $entity_meta = []);
}
