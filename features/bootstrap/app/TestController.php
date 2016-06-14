<?php

use LaunchDarkly\LDUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction() {
        if ($this->get('inviqa_launchdarkly.client')->getFlag('new-homepage-content', new LDUser('user-id'))) {
            return new Response("the new homepage content");
        }
        return new Response("the old homepage content");
    }

    public function templatedAction() {
        return $this->render('index.html.twig');
    }

    public function serviceAction() {
        return new Response($this->get('inviqa_launchdarkly.test_service')->getContent());
    }
}