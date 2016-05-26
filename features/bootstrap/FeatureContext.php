<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkAwareContext;

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
    public function __construct()
    {
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
        assert(strpos($this->mink->getSession()->getPage()->getContent(), $content) !== false);
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
    
}
