<?php

namespace Inviqa\LaunchDarklyBundle\User;

interface IdProvider
{
    public function userId();
}