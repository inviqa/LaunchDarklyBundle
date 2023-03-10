<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

use Inviqa\LaunchDarklyBundle\Client\StaticClient;
use Inviqa\LaunchDarklyBundle\Client\ExplicitUser\StaticClient as UserStaticClient;
use LaunchDarkly\LDUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TestController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $client;
    private $userClient;
    private $testService;
    private $aliasedTestService;
    private $taggedTestService;
    private Environment $twig;

    public function __construct(
        Environment $twig,
        $client,
        $userClient,
        $testService,
        $aliasedTestService,
        $taggedTestService
    ) {
        $this->twig = $twig;
        $this->client = $client;
        $this->userClient = $userClient;
        $this->testService = $testService;
        $this->aliasedTestService = $aliasedTestService;
        $this->taggedTestService = $taggedTestService;
    }

    public function indexAction(): \Symfony\Component\HttpFoundation\Response {
        if ($this->client->variation('new-homepage-content')) {
            return new Response("<html><body>the new homepage content</body></html>");
        }
        return new Response("<html><body>the old homepage content</body></html>");
    }

    public function indexUserAction(): \Symfony\Component\HttpFoundation\Response {
        if ($this->userClient->variation('new-homepage-user-content', new LDUser('user-id'))) {
            return new Response("<html><body>the new homepage user content</body></html>");
        }
        return new Response("<html><body>the old homepage user content</body></html>");
    }

    public function templatedAction(): \Symfony\Component\HttpFoundation\Response {
        return new Response($this->twig->render('index.html.twig'));
    }

    public function serviceAction(): \Symfony\Component\HttpFoundation\Response {
        return new Response($this->testService->getContent());
    }

    public function aliasedServiceAction(): \Symfony\Component\HttpFoundation\Response {
        return new Response($this->aliasedTestService->getContent());
    }

    public function taggedServiceAction(): \Symfony\Component\HttpFoundation\Response {
        return new Response($this->taggedTestService->getContent());
    }

    public function staticAction(): \Symfony\Component\HttpFoundation\Response {
        if (StaticClient::variation('new-static-access-content')) {
            return new Response("<html><body>the new static access content</body></html>");
        }
        return new Response("<html><body>the old static access content</body></html>");
    }

    public function staticUserAction(): \Symfony\Component\HttpFoundation\Response {
        if (UserStaticClient::variation('new-static-access-user-content', new LDUser('user-id'))) {
            return new Response("<html><body>the new static access user content</body></html>");
        }
        return new Response("<html><body>the old static access user content</body></html>");
    }
}
