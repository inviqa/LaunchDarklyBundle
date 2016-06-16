<?php

namespace Inviqa\LaunchDarklyBundle\User;

interface UserFactory
{
    public function create($key);
}