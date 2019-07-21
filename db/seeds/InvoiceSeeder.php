<?php

use Phinx\Seed\AbstractSeed;

class InvoiceSeeder extends AbstractSeed
{
    private const TABLE_NAME = 'factura';

    public function run()
    {
        $numInvoicesToSeed = 10;
        $seedInvoices = [];
        $fakerFactory = Faker\Factory::create('es_ES');
        for ($counter = 0; $counter < $numInvoicesToSeed; $counter++) {
            $seedInvoices[] = [
                'nom' => $fakerFactory->words(3, true),
                'adreca' => $fakerFactory->address,
                'nif' => $fakerFactory->randomNumber(8),
                'detalls' => $fakerFactory->text(20),
                'factura' => $fakerFactory->randomFloat(2, 0, 150),
                'observacions' => $fakerFactory->text(15),
                'tipus' => $fakerFactory->numberBetween(0, 1),
                'fecha_solicitud' => $fakerFactory->date(),
                'fecha' => $fakerFactory->date(),
                'cobrada' => $fakerFactory->numberBetween(0, 1),
                'modificat' => $fakerFactory->numberBetween(0, 1)
            ];
        }

        $this->table(self::TABLE_NAME)->insert($seedInvoices)->save();
    }
}
