Feature: Home page
  In order to choose one feature
  As a user
  I need to be able to see a menu with options

  Options availables:
  - Insertar
  - Consultar
  - Llistar
  - Imprimir

  Scenario: Seeing menu on homepage
    Given am on "/"
    When I go to "/"
    Then should see "Insertar"
    And should see "Consultar"
    And should see "Llistar"
    And should see "Imprimir"

  Scenario: See app title
    Given am on "/"
    When I go to "/"
    Then should see "SOL·LICITUD FACTURA -FACTURINI-"

  Scenario: Insertar link show insert new invoice page
    Given am on "/"
    When I follow "Insertar"
    Then should see "Insertar nova factura (FACTURINI)"

  Scenario: Consultar link show invoice list
    Given am on "/"
    When I follow "Consultar"
    Then should see "Consultar factures (FACTURINI)"

  Scenario: Llistar link show form to show single invoice
    Given am on "/"
    When I follow "Llistar"
    Then should see "Llistar factures (FACTURINI)"

  Scenario: Imprimir link show form to print single or multiple invoices
    Given am on "/"
    When I follow "Imprimir"
    Then should see "Imprimir factures (FACTURINI)"

