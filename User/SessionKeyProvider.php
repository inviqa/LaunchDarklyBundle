<?php

namespace Inviqa\LaunchDarklyBundle\User;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionKeyProvider implements KeyProvider
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function userKey()
    {
        return $this->session()->getId();
    }

    private function request()
    {
        if (!$request = $this->requestStack->getCurrentRequest()) {
            throw new \RuntimeException($this->noSessionMessage());
        }

        return $request;
    }

    private function session()
    {
        if (!$session = $this->request()->getSession()) {
            throw new \RuntimeException($this->noSessionMessage());
        }

        return $session;
    }

    private function noSessionMessage()
    {
        return "No request or session was available in order to use the session ID as the user key for LaunchDarkly. 
        You can set the user_key_provider_service in the inviqa_launch_darkly bundle config to use a custom service to 
        provide the user key if required";
    }

}