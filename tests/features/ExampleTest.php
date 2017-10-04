<?php

class ExampleTest extends FeatureTestCase
{

    function test_basic_example()
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
