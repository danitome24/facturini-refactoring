<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{


    /**
     * @Given /^I can see an invoice with name "([^"]*)"$/
     */
    public function iCanSeeAnInvoiceWithName($name) {
        $this->getSession()->visit('/consultar.php');
        $this->assertPageContainsText($name);
    }
}