<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction() {
        if ($this->get('inviqa_launchdarkly.blah')->on('new-homepage-content')) {
            return new Response("the new homepage content");
        }
        return new Response("the old homepage content");
    }
}