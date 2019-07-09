Feature: See a list of existing invoice filtered.
  In order to see existing invoices filtered by fields
  As a user
  I need to be able to see already inserted invoices

  Scenario: I am able to go to menu page
    Given I am on "/llistar.php"
    When I follow "Anar a la plana inicial"
    Then I should be on "/index.htm"
    And I should see "SOL·LICITUD FACTURA -FACTURINI-"

  Scenario: I can not see any invoice when no one was added
    Given I am on "/llistar.php"
    And There are no invoices on system
    When I press "Acceptar"
    Then I should be on "/llistar.php"
    And I should see "No hi ha registres que satisfacin la cerca."

  Scenario: I can see invoices filtered by date
    Given I am on "/llistar.php"
    And There are five invoices on system
    When I fill in "data_inici" with "2019-05-01"
    And I fill in "data_fi" with "2019-05-06"
    And I press "Acceptar"
    Then I should see "First invoice"
    And I should see "05/05/2019"
    And I should see "1"

  Scenario: I can see five invoices filtered by identifiers
    Given I am on "/llistar.php"
    And There are five invoices on system
    When I fill in "reg_inici" with "1"
    And I fill in "reg_fi" with "6"
    And I press "Acceptar"
    Then I should see "Fifth invoice"
    And I should see "Fourth invoice"
    And I should see "Third invoice"
    And I should see "Second invoice"
    And I should see "First invoice"

  Scenario: I can see an invoice filtered by name
    Given I am on "/llistar.php"
    And There are five invoices on system
    When I fill in "nom" with "First"
    And I press "Acceptar"
    Then I should see "First invoice"

  Scenario: I can see an invoice filtered if has been charged
    Given I am on "/llistar.php"
    And There are five invoices on system
    When I select "1" from "cobrada"
    And I press "Acceptar"
    Then I should see "Third invoice"
    And I should see "First invoice"

  Scenario: I can see an invoice filtered if has not been charged
    Given I am on "/llistar.php"
    And There are five invoices on system
    When I select "0" from "cobrada"
    And I press "Acceptar"
    Then I should see "Fourth invoice"
    And I should see "Second invoice"
    And I should see "Fifth invoice"