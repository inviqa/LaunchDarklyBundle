<?php

use Inviqa\LaunchDarklyBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

class ConfigTest  extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testApiKeyIsRequired()
    {
        $this->assertConfigurationIsInvalid(
            [[]],
            'api_key'
        );
    }
}