<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction() {
        if ($this->get('inviqa_launchdarkly.client')->isOn('new-homepage-content')) {
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