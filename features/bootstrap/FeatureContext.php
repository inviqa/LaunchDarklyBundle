<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkAwareContext;
use LaunchDarkly\LDClient;
use LaunchDarkly\LDUser;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext, MinkAwareContext
{
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
    public function __construct(LDClient $ldClient)
    {
        $this->ldClient = $ldClient;
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
        $this->ldClient->getFlag('new-homepage-content', new LDUser('user-id'));
    }

    /**
     * @Then the requester I have configured should be used
     */
    public function theRequesterIHaveConfiguredShouldBeUsed()
    {
        assert(MockFeatureRequester::$usedForKey);
    }

    /**
     * @Then the API key I have configured should be set to :value
     */
    public function theApiKeyIHaveConfiguredShouldBeSetTo($value)
    {
        assert(MockFeatureRequester::$apiKey == $value);
    }

    /**
     * @Then the base uri I have configured should be set to :value
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
     * @Then the capacity I have configured should be set to :arg1
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
        assert(MockFeatureRequester::$events == true);
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
}
