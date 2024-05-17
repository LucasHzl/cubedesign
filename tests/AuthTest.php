<?php

namespace App\Tests;

 use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class AuthTest extends WebTestCase
// {
//     public function testAuth(): void
//     {
//         $client = static::createClient();
//         $crawler = $client->request('GET', '/');

//         $this->assertResponseIsSuccessful();
//         $this->assertSelectorTextContains('h1', 'Hello World');
//     }
// }

 
// use PHPUnit\Framework\TestCase;
// use Symfony\Component\Validator\Validation;
// use Symfony\Component\Validator\Constraints\Regex;
// class PasswordValidationTest extends TestCase
// {
// public function testValidPassword()
// {
// $validator = Validation::createValidator();
// $password = 'MyStrongPassword123';
// $constraint = new Regex([
// 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/',
// 'message' => 'Le mot de passe doit contenir au moins une lettre
// majuscule, une lettre minuscule, un chiffre et avoir une longueur minimale de 8
// caractères.',
// ]);
// $violations = $validator->validate($password, $constraint);
// $this->assertCount(0, $violations);
// }
// public function testInvalidPassword()
// {
// $validator = Validation::createValidator();
// $password = 'weak';
// $constraint = new Regex([
// 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/',
// 'message' => 'Le mot de passe doit contenir au moins une lettre
// majuscule, une lettre minuscule, un chiffre et avoir une longueur minimale de 8
// caractères.',
// ]);
// $violations = $validator->validate($password, $constraint);
// $this->assertCount(1, $violations);
// }
// }


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class MyFirstTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testGoodLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Connexion')->form([
            'email' => 'lucas@gmail.com',
            'password' => '',
        ]);
        
        $this->client->submit($form);

        $this->assertResponseRedirects('/'); 
        $this->client->followRedirect();

        $this->assertSelectorTextContains('.flashMessage', 'Bonjour, vous êtes bien connecté');
        $this->assertResponseIsSuccessful();


    }

    public function testWrongLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
    
        $form = $crawler->selectButton('Connexion')->form([
            'email' => 'lucas@gmail.com',
            'password' => '',
        ]);
        
        $this->client->submit($form);
    
        $this->assertResponseRedirects('/login');
    
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('.italic', 'Veuillez saisir votre mot de passe');
    }
    
}