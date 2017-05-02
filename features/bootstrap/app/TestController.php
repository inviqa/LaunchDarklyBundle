<?php

use Inviqa\LaunchDarklyBundle\Client\StaticClient;
use Inviqa\LaunchDarklyBundle\Client\ExplicitUser\StaticClient as UserStaticClient;
use LaunchDarkly\LDUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction() {
        if ($this->get('inviqa_launchdarkly.client')->variation('new-homepage-content')) {
            return new Response("<html><body>the new homepage content</body></html>");
        }
        return new Response("<html><body>the old homepage content</body></html>");
    }

    public function indexUserAction() {
        if ($this->get('inviqa_launchdarkly.user_client')->variation('new-homepage-user-content', new LDUser('user-id'))) {
            return new Response("<html><body>the new homepage user content</body></html>");
        }
        return new Response("<html><body>the old homepage user content</body></html>");
    }

    public function templatedAction() {
        return $this->render('index.html.twig');
    }

    public function serviceAction() {
        return new Response($this->get('inviqa_launchdarkly.test_service')->getContent());
    }

    public function aliasedServiceAction() {
        return new Response($this->get('inviqa_launchdarkly.aliased_test_service')->getContent());
    }

    public function taggedServiceAction() {
        return new Response($this->get('inviqa_launchdarkly.tagged_test_service')->getContent());
    }

    public function staticAction() {
        if (StaticClient::variation('new-static-access-content')) {
            return new Response("<html><body>the new static access content</body></html>");
        }
        return new Response("<html><body>the old static access content</body></html>");
    }

    public function staticUserAction() {
        if (UserStaticClient::variation('new-static-access-user-content', new LDUser('user-id'))) {
            return new Response("<html><body>the new static access user content</body></html>");
        }
        return new Response("<html><body>the old static access user content</body></html>");
    }
}