<?php

use Inviqa\LaunchDarklyBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

class ConfigTest  extends \PHPUnit\Framework\TestCase
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

    public function testBaseUrlIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'base-uri' => 'http://example.con',
            ]]
        );
    }

    public function testRequesterIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'feature_requester_class' => 'MockRequester',
            ]]
        );
    }

    public function testTimeoutIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'timeout' => 20,
            ]]
        );
    }

    public function testTimeoutHasToBeAnInteger()
    {
        $this->assertConfigurationIsInvalid(
            [[
                'api_key' => 'APIKEY',
                'timeout' => '20',
            ]], 'timeout'
        );
    }

    public function testConnectTimeoutIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'connect_timeout' => 30,
            ]]
        );
    }

    public function testConnectTimeoutHasToBeAnInteger()
    {
        $this->assertConfigurationIsInvalid(
            [[
                'api_key' => 'APIKEY',
                'connect_timeout' => '30',
            ]], 'connect_timeout'
        );
    }

    public function testCapacityIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'capacity' => 800,
            ]]
        );
    }

    public function testCapacityHasToBeAnInteger()
    {
        $this->assertConfigurationIsInvalid(
            [[
                'api_key' => 'APIKEY',
                'capacity' => '800',
            ]], 'capacity'
        );
    }

    public function testEventsIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'events' => true,
            ]]
        );
    }

    public function testEventsHasToBeABoolean()
    {
        $this->assertConfigurationIsInvalid(
            [[
                'api_key' => 'APIKEY',
                'events' => 'false',
            ]], 'events'
        );
    }

    public function testDefaultsIsAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'defaults' => ['flag_one' => true],
            ]]
        );
    }

    public function testEventsHasToBeAnArray()
    {
        $this->assertConfigurationIsInvalid(
            [[
                'api_key' => 'APIKEY',
                'defaults' => 'false',
            ]], 'defaults'
        );
    }

    public function testUserFactoryServiceAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'user_factory_service' => 'my_service_id',
            ]]
        );
    }

    public function testUserFactoryServiceHasDefault()
    {
        $this->assertProcessedConfigurationEquals(
            [[
                'api_key' => 'APIKEY',
            ]],
            [
                'api_key' => 'APIKEY',
                'defaults' => [],
                'user_factory_service' => 'inviqa_launchdarkly.simple_user_factory',
                'user_key_provider_service' => 'inviqa_launchdarkly.session_key_provider',
            ]
        );
    }

    public function testUserIdProviderServiceAllowed()
    {
        $this->assertConfigurationIsValid(
            [[
                'api_key' => 'APIKEY',
                'user_key_provider_service' => 'my_service_id',
            ]]
        );
    }

    public function testUserIdProviderServiceHasDefault()
    {
        $this->assertProcessedConfigurationEquals(
            [[
                'api_key' => 'APIKEY',
            ]],
            [
                'api_key' => 'APIKEY',
                'defaults' => [],
                'user_factory_service' => 'inviqa_launchdarkly.simple_user_factory',
                'user_key_provider_service' => 'inviqa_launchdarkly.session_key_provider',
            ]
        );
    }
}
