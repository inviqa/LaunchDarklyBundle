<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

use Inviqa\LaunchDarklyBundle\Client\StaticClient;
use Inviqa\LaunchDarklyBundle\Client\ExplicitUser\StaticClient as UserStaticClient;
use LaunchDarkly\LDUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    private $client;
    private $userClient;
    private $testService;
    private $aliasedTestService;
    private $taggedTestService;

    public function __construct(
        $client,
        $userClient,
        $testService,
        $aliasedTestService,
        $taggedTestService
    ) {
        $this->client = $client;
        $this->userClient = $userClient;
        $this->testService = $testService;
        $this->aliasedTestService = $aliasedTestService;
        $this->taggedTestService = $taggedTestService;
    }

    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $this->container = $container;
        return $container;
    }

    public function indexAction() {
        if ($this->client->variation('new-homepage-content')) {
            return new Response("<html><body>the new homepage content</body></html>");
        }
        return new Response("<html><body>the old homepage content</body></html>");
    }

    public function indexUserAction() {
        if ($this->userClient->variation('new-homepage-user-content', new LDUser('user-id'))) {
            return new Response("<html><body>the new homepage user content</body></html>");
        }
        return new Response("<html><body>the old homepage user content</body></html>");
    }

    public function templatedAction() {
        return $this->render('index.html.twig');
    }

    public function serviceAction() {
        return new Response($this->testService->getContent());
    }

    public function aliasedServiceAction() {
        return new Response($this->aliasedTestService->getContent());
    }

    public function taggedServiceAction() {
        return new Response($this->taggedTestService->getContent());
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
