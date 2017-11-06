<?php

use App\Token;
use Illuminate\Support\Facades\Mail;

class RequestTokenTest extends FeatureTestCase
{
    function test_a_guest_user_can_request_a_token()
    {
        // Having
        Mail::fake();

        $user = $this->defaultUser(['email' => 'admin@styde.net']);

        // When
        $this->visitRoute('token')
            ->type('admin@styde.net', 'email')
            ->press('Solicitar token');

        // Then: a new token is created in database
        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token, 'A token was not created');

        // And sent to the user
        Mail::assertSentTo($user, \App\Mail\TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Enviamos a tu email un enlace para que inicies sesión');
    }

    function test_a_guest_user_can_request_a_token_without_an_email()
    {
        // Having
        Mail::fake();

        // When
        $this->visitRoute('token')
            ->press('Solicitar token');

        // Then: a new token is NOT created in database
        $token = Token::first();

        $this->assertNull($token, 'A token was created');

        // And sent to the user
        Mail::assertNotSent(\App\Mail\TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'El camp correu electrònic és obligatori'
        ]);
    }

    function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
        // When
        $this->visitRoute('token')
            ->type('aborrell', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correu electrònic no és un e-mail vàlid'
        ]);
    }

    function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        $this->defaultUser(['email' => 'admin@styde.net']);

        // When
        $this->visitRoute('token')
            ->type('aborrell@styde.net', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correu electrònic és invàlid.'
        ]);
    }
}
