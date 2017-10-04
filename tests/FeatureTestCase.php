<?php

use \Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestCase extends TestCase
{
    // Ejecuta "migrate" al inicio del TEST y "migrate:rollback" antes de finalizar
    // De este modo la ejecucion del TEST no depende de la ejecucion anterior
    //use DatabaseMigrations;

    // En lugar de añadir o eliminar migraciones (que es mas lento),
    // elimina los cambios SQL que se han producido en la Base de datos durante el TEST
    use DatabaseTransactions;
}