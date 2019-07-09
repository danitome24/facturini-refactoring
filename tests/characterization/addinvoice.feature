Feature: Create a new invoice and add it to our system.
  In order to add new invoice
  As a user
  I need to be able to fill the form with invoice data.

  Scenario: I can go back to menu
    Given I am on "/insertar.htm"
    When I follow "Anar a la plana inicial"
    Then I should be on "/index.htm"
    And I should see "SOL·LICITUD FACTURA -FACTURINI-"

  Scenario: I am redirected to home when empty invoice is added
    Given I am on "/insertar.htm"
    When I press "Insertar"
    Then I should be on "/index.htm"
    And I can see an invoice with name ""

  Scenario: I am redirected to home when full invoice is added
    Given I am on "/insertar.htm"
    And I select "0" from "tipus"
    And I fill in "nom" with "Software architecture in PHP"
    And I fill in "adreca" with "Remote"
    And I fill in "nif" with "99999999"
    And I fill in "fecha_solicitud" with "2019-05-05"
    And I fill in "detalls" with "DDD, Hexagonal architecture, Clean Code, SOLID Principles"
    And I fill in "factura" with "99.99"
    And I select "0" from "cobrada"
    When I press "Insertar"
    Then I should be on "/index.htm"
    And I can see an invoice with name "Software architecture in PHP"
