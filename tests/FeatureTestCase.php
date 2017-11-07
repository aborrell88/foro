<?php

use Tests\CreatesApplication;
use Tests\TestsHelper;
use \Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestCase extends \Laravel\BrowserKitTesting\TestCase
{
    // En lugar de añadir o eliminar migraciones usando "use DatabaseMigrations" que es más lento,
    // elimina los cambios SQL que se han producido en la Base de datos durante el TEST
    use CreatesApplication, TestsHelper, DatabaseTransactions;

    public function seeErrors(array $fields)
    {
        foreach ($fields as $name => $errors) {
            foreach ((array) $errors as $message) {
                $this->seeInElement(
                    "#field_{$name}.has-error .help-block", $message
                );
            }
        }
    }
}