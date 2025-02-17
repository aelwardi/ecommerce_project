<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $client->submitForm('Valider', [
            'register_user[email]' => 'julien@gmail.com',
            'register_user[plainPassword][first]' => '123456789',
            'register_user[plainPassword][second]' => '123456789',
            'register_user[firstName]' => 'Julien',
            'register_user[lastName]' => 'Dupont'
        ]);
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("Votre compte est correctement créé, veuillez vous connecter.")');
    }
}
