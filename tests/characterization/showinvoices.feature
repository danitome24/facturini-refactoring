Feature: See a list of existing invoice.
  In order to see existing invoices
  As a user
  I need to be able to see already inserted invoices

  Scenario: I can see an given invoice
    Given I am on "/"
    And An existing invoice with name "The most expensive invoice"
    Then I follow "Consultar"
    And I should see "The most expensive invoice"

  Scenario: I can see application date in a given invoice
    Given I am on "/"
    And An existing invoice with name "The most expensive invoice" and application date "2019-05-05"
    Then I follow "Consultar"
    And I should see "The most expensive invoice"
    And I should see "05/05/2019"

  Scenario: I can see application pending state in a given invoice
    Given I am on "/"
    And An existing invoice with name "The most expensive invoice" and state "0"
    Then I follow "Consultar"
    And I should see "The most expensive invoice"
    And I should see "Pendent"

  Scenario: I can see application state in a given invoice
    Given I am on "/"
    And An existing invoice with name "The most expensive invoice" and state "1"
    Then I follow "Consultar"
    And I should see "The most expensive invoice"
    And I should see "Verificat"
