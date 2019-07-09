Feature: See a single existing invoice.
  In order to see existing single invoices
  As a user
  I need to be able to see already inserted invoices

  Scenario: I can see an given invoice
    Given I am on "/"
    And An existing random invoice
    When I follow "Consultar"
    And I fill in "num_reg" with "1"
    And I press "Acceptar"
    Then I should be on "/consulta_anterior.php"
    And I should see "Consulta factura (FACTURINI)"
    And the "tipus" checkbox in radio button with value "0" should be checked
    And I should see "The random invoice"
    And I should see "Av. Random, 24"
    And I should see "77885544K" at input "nif"
    And I should see "2019-05-05" at input "fecha_solicitud"
    And I should see "Some random details that no matter"
    And I should see "78.9" at input "factura"
    And the "cobrada" checkbox in radio button with value "0" should be checked
    And I should see "None comments"
