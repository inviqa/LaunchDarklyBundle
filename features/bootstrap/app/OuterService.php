<?php

class OuterService
{
    private $inner;

    public function __construct($inner)
    {
        $this->inner = $inner;
    }

    public function getContent()
    {
        return $this->inner->getContent();
    }
}