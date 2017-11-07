<?php

use App\{
    Mail\TokenMail, User, Token
};
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
    function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
            ->type('aborrell88@styde.net', 'email')
            ->type('aborrell88', 'username')
            ->type('Alejandro', 'first_name')
            ->type('Borrell', 'last_name')
            ->press('Regístrate');

        $this->seeInDatabase('users', [
           'email' => 'aborrell88@styde.net',
           'username' => 'aborrell88',
           'first_name' => 'Alejandro',
           'last_name' => 'Borrell'
        ]);

        $user = User::first();

        $this->seeInDatabase('tokens', [
           'user_id' => $user->id
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSent(TokenMail::class, function ($mail) use ($token, $user) {
            return $mail->hasTo($user) && $mail->token->id == $token->id;
        });

        // todo: finish this feature!
        return;

        $this->seeRouteIs('register_confirmation')
            ->see('Gracias por registrarte')
            ->see('Se ha enviado a tu email un enlace para que inices sesión');

    }
}
