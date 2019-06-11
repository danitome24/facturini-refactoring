<?php
/**
 * This software was built by:
 * Daniel Tomé Fernández <danieltomefer@gmail.com>
 * GitHub: danitome24
 */

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Facturini\Database\Mysqli\MysqliConnection;
use Facturini\Database\Mysqli\MysqliQuery;

class FeatureContext extends MinkContext
{
    private $db;

    private $dbConnection;

    public function __construct()
    {
        require __DIR__ . '/../../../config.php';

        $this->dbConnection = MysqliConnection::create($dbhost, $dbuname, $dbpass, $dbname);
        $this->db = new MysqliQuery($this->dbConnection, false);
    }

    /**
     * @Given /^I can see an invoice with name "([^"]*)"$/
     */
    public function iCanSeeAnInvoiceWithName($name)
    {
        $this->getSession()->visit('/consultar.php');
        $this->assertPageContainsText($name);
    }

    /**
     * @Given /^An existing invoice with name "([^"]*)"$/
     */
    public function anExistingInvoiceWithName($name)
    {
        $createdOn = date('Y-m-d H:i:s');
        $this->anExistingInvoiceWithNameAndApplicationDate($name, $createdOn);
    }

    /**
     * @Given An existing invoice with name :arg1 and application date :arg2
     */
    public function anExistingInvoiceWithNameAndApplicationDate($name, $applicationDate)
    {
        $createdOn = date('Y-m-d H:i:s');
        $sqlQuery = "INSERT INTO factura (nom, fecha, fecha_solicitud) VALUES ('" . $name . "', '" . $createdOn . "', '" . $applicationDate . "');";
        $this->db->query($sqlQuery);
    }

    /**
     * @Given An existing invoice with name :arg1 and state :arg2
     */
    public function anExistingInvoiceWithNameAndState($name, $state)
    {
        $createdOn = date('Y-m-d H:i:s');
        $sqlQuery = "INSERT INTO factura (nom, fecha, modificat) VALUES ('" . $name . "', '" . $createdOn . "', '" . $state . "')";
        $this->db->query($sqlQuery);
    }

    /**
     * @Given An existing random invoice
     */
    public function anExistingRandomInvoice()
    {
        $createdOn = '2019-05-05';
        $name = 'The random invoice';
        $address = 'Av. Random, 24';
        $idNumber = '77885544K';
        $details = 'Some random details that no matter';
        $cost = 78.9;
        $hasBeenCharged = 0;
        $commments = 'None comments';
        $type = 0;
        $sqlQuery = "insert into factura values ('1','" . $name . "','" . $address . "','" . $idNumber . "'," .
            "'" . $details . "','" . $cost . "','" . $commments . "','" . $type . "','" . $createdOn . "'," .
            "'" . $createdOn . "','" . $hasBeenCharged . "', DEFAULT)";
        $this->db->query($sqlQuery);
    }

    /**
     * @Then /^the "([^"]*)" checkbox in radio button with value "([^"]*)" should be checked$/
     */
    public function assertRadioButtonValueIsChecked($radio, $value)
    {
        $radio = $this->fixStepArgument($radio);
        $radioButtons = $this->getSession()->getPage()->findAll(
            'css',
            'input[type="RADIO"][name="' . $radio . '"]'
        );
        $isChecked = false;
        foreach ($radioButtons as $radioButton) {
            if ($radioButton->getAttribute('value') == $value) {
                $isChecked = $radioButton->isChecked();
            }
        }
        if (!$isChecked) {
            throw new Exception(
                sprintf('Radio button %s with value %d is not checked and should be', $radio, $value)
            );
        }
    }

    /**
     * @Then /^I should see "([^"]*)" at input "([^"]*)"$/
     */
    public function assertInputContains($value, $inputName)
    {
        $inputName = $this->fixStepArgument($inputName);
        $input = $this->getSession()->getPage()->find('css', 'input[name="' . $inputName . '"]');
        $expectedValue = $input->getAttribute('value');
        if ($expectedValue !== $value) {
            throw new Exception(
                sprintf('Input name %s expects to have %s instead of %s', $inputName, $value, $expectedValue)
            );
        }
    }

    /**
     * @AfterScenario
     */
    public function clearAndDisconnectDb(AfterScenarioScope $scope)
    {
        $this->db->query('TRUNCATE TABLE factura');
        $this->dbConnection->disconnect();
    }
}