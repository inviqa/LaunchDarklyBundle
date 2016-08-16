<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Inviqa\LaunchDarklyBundle\Client\SimpleClient;
use LaunchDarkly\LDClient;
use LaunchDarkly\LDUser;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext, MinkAwareContext
{
    use KernelDictionary;
    /**
     * @var \Behat\Mink\Mink
     */
    private $mink;
    private $minkParameters;
    /**
     * @var LDClient
     */
    private $ldClient;

    /**
     * Sets Mink instance.
     *
     * @param \Behat\Mink\Mink $mink Mink session manager
     */
    public function setMink(\Behat\Mink\Mink $mink)
    {
        $this->mink = $mink;
    }

    /**
     * Sets parameters provided for Mink.
     *
     * @param array $parameters
     */
    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(SimpleClient $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->getKernel()->clearConfig();
    }

    /**
     * @When I visit the homepage
     */
    public function iVisitTheHomepage()
    {
        $this->mink->getSession()->visit('/');

    }

    /**
     * @Then I should see :content
     */
    public function iShouldSee($content)
    {
        if(strpos($this->mink->getSession()->getPage()->getContent(), $content) === false) {
            throw new RuntimeException("Expected content not found ($content)");
        }
    }


    /**
     * @Given the :name flag is turned off
     */
    public function theFlagIsTurnedOff($name)
    {
        MockFeatureRequester::setOff($name);
    }

    /**
     * @Given the :name flag is turned on
     */
    public function theFlagIsTurnedOn($name)
    {
        MockFeatureRequester::setOn($name);
    }


    /**
     * @When I ask if a flag is on for a user
     */
    public function iAskIfAFlagIsOnForAUser()
    {
        $this->ldClient->isOn('new-homepage-content', new LDUser('user-id'));
    }

    /**
     * @Then the requester I have configured should be used
     */
    public function theRequesterIHaveConfiguredShouldBeUsed()
    {
        assert(MockFeatureRequester::$usedForKey);
    }

    /**
     * @Then the api_key I have configured should be set to :value
     */
    public function theApiKeyIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$apiKey == $value);
    }

    /**
     * @Then the base_uri I have configured should be set to :value
     */
    public function theBaseUriIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$baseUri == $value);
    }

    /**
     * @Then the timeout I have configured should be set to :value
     */
    public function theTimeoutIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$timeout == $value);
    }

    /**
     * @Then the connect_timeout I have configured should be set to :value
     */
    public function theConnectTimeoutIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$connectTimeout == $value);
    }

    /**
     * @Then the capacity I have configured should be set to :value
     */
    public function theCapacityIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$capacity == $value);
    }

    /**
     * @Then the events I have configured should be set to :value
     */
    public function theEventsIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$events == $value);
    }

    /**
     * @Then the defaults I have configured should be used
     */
    public function theDefaultsIHaveConfiguredShouldBeUsed()
    {
        assert(MockFeatureRequester::$defaults == ['flag_one' => true, 'flag_two' => false]);
    }

    /**
     * @When I visit the template page
     */
    public function iVisitTheTemplatePage()
    {
        $this->mink->getSession()->visit('/templated');
    }

    /**
     * @When I visit the service page
     */
    public function iVisitTheServicePage()
    {
        $this->mink->getSession()->visit('/service');
    }

    /**
     * @Given I have configured :arg1 as :arg2
     */
    public function iHaveConfiguredAs($arg1, $arg2)
    {
        $this->getKernel()->loadConfig(function(ContainerBuilder $container) use ($arg1, $arg2){
            $container->loadFromExtension('inviqa_launch_darkly', [$arg1 => $arg2]);
        });
    }

    /**
     * @Given I have configured :key of :type as :value
     */
    public function iHaveConfiguredOfAs($key, $type, $value)
    {
        switch ($type) {
            case 'int':
                $castValue = (int) $value;
                break;
            case 'boolean':
                if ($value === "true") $castValue = true; else $castValue = false;
                break;
            default:
                $castValue = $value;
        }

        $this->getKernel()->loadConfig(function(ContainerBuilder $container) use ($key, $castValue){
            $container->loadFromExtension('inviqa_launch_darkly', [$key => $castValue]);
        });
    }

    /**
     * @Given I have configured defaults
     */
    public function iHaveConfiguredDefaults()
    {
        $this->getKernel()->loadConfig(function(ContainerBuilder $container) {
            $container->loadFromExtension('inviqa_launch_darkly', ['defaults' => [
                'flag_one' =>  true,
                'flag_two' =>  false,
            ]]);
        });
    }

    /**
     * @Given I fix the user key to :key
     */
    public function iFixTheUserKeyTo($key)
    {
        StaticKeyProvider::setUserKey($key);
        $this->getKernel()->loadConfig(function(ContainerBuilder $container) {
            $container->loadFromExtension('inviqa_launch_darkly', ['user_key_provider_service' => 'inviqa_launchdarkly.static_key_provider']);
        });

    }

    /**
     * @Then :key should have been used to identify me
     */
    public function shouldHaveBeenUsedToIdentifyMe($key)
    {
        assert(LDClientWrapper::$lastUser->getKey() == $key);
    }

    /**
     * @Given I fix the user ip to :ip
     */
    public function iFixTheUserIpTo($ip)
    {
        IPUserFactory::$ip = $ip;
        $this->getKernel()->loadConfig(function(ContainerBuilder $container) {
            $container->loadFromExtension('inviqa_launch_darkly', ['user_factory_service' => 'inviqa_launchdarkly.ip_user_factory']);
        });
    }

    /**
     * @Then :ip should have been used as the ip address
     */
    public function shouldHaveBeenUsedAsTheIpAddress($ip)
    {
        assert(LDClientWrapper::$lastUser->getIp() == $ip);
    }

    /**
     * @When I visit the static method page
     */
    public function iVisitTheStaticMethodPage()
    {
        $this->mink->getSession()->visit('/static');
    }

    /**
     * @When I visit the aliased service page
     */
    public function iVisitTheAliasedServicePage()
    {
        $this->mink->getSession()->visit('/aliased');
    }

    /**
     * @When I visit the tagged service page
     */
    public function iVisitTheTaggedServicePage()
    {
        $this->mink->getSession()->visit('/tagged');
    }
}
