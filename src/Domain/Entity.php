<?php

namespace SpeackWithUs\Domain;

abstract class Entity
{
    protected ?int $_id;
    public $props;

    public function get()
    {
        return $this->_id;
    }

    public function __construct(
        $props,
        ?int $id = null
    ) {
        $this->props = $props;
        $this->_id = $id;
    }
}
