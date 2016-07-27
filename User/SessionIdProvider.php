<?php

namespace Inviqa\LaunchDarklyBundle\User;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionIdProvider implements IdProvider
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function userId()
    {
        return $this->requestStack->getCurrentRequest()->getSession()->getId();
    }

}