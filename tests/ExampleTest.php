<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    // Ejecuta "migrate" al inicio del TEST y "migrate:rollback" antes de finalizar
    // De este modo la ejecucion del TEST no depende de la ejecucion anterior
    //use DatabaseMigrations;

    // En lugar de añadir o eliminar migraciones (que es mas lento),
    // elimina los cambios SQL que se han producido en la Base de datos durante el TEST
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Alejandro Borrell',
            'email' => 'aborrell@animalear.com'
        ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('Alejandro Borrell')
            ->see('aborrell@animalear.com');
    }
}
