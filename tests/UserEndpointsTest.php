<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\HeaderBag;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;

class UserEndpointsTest extends ApiTestCase
{
    protected $baseUrl = 'http://127.0.0.1:8000';

    protected function tearDown(): void
    {
        parent::tearDown();
        restore_exception_handler();
    }

    public function testCreateUser(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', $this->baseUrl . '/api/users', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'dateOfBirth' => '1990-01-01',
                'email' => 'john.doe@example.com'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ]
        ]);
    
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);

        $this->assertJson($response->getContent());
        $this->assertIsArray($content);
        $this->assertArrayHasKey('id', $content);
        $this->assertEquals('John', $content['firstName']);
        $this->assertEquals('Doe', $content['lastName']);
    }

    public function testGetAllUsers(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', $this->baseUrl . '/api/users');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);

        $this->assertJson($response->getContent());
        $this->assertIsArray($content);
    }

    public function testGetUserById(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', $this->baseUrl . '/api/users/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);

        $this->assertJson($response->getContent());
        $this->assertIsArray($content);
        $this->assertEquals(1, $content['id']);
    }

    public function testUpdateUserPut(): void
    {
        $client = static::createClient();
        $response = $client->request('PUT', $this->baseUrl . '/api/users/1', [
            'json' => [
                'firstName' => 'Joseph',
                'lastName' => 'Smith',
                'dateOfBirth' => '1990-01-01',
                'email' => 'joseph.smith@example.com'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Joseph', $content['firstName']);
    }

    public function testUpdateUserPatch(): void
    {
        $client = static::createClient();
        $response = $client->request('PATCH', $this->baseUrl . '/api/users/1', [
            'json' => ['email' => 'joseph.smith2@example.com'],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('joseph.smith2@example.com', $content['email']);
    }

    public function testDeleteUser(): void
    {
        $client = static::createClient();

        // Create a user first
        $response = $client->request('POST', $this->baseUrl . '/api/users', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'dateOfBirth' => '1990-01-01',
                'email' => 'john.doe@example.com'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ]
        ]);
        
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $content = json_decode($response->getContent(), true);
        $userId = $content['id'];

        // Proceed to delete the user
        $response = $client->request('DELETE', $this->baseUrl . '/api/users/' . $userId);
        $this->assertResponseStatusCodeSame(204); // 204 No Content on successful delete

        // Verify that the user is deleted
        $response = $client->request('GET', $this->baseUrl . '/api/users/' . $userId);
        $this->assertResponseStatusCodeSame(404); // Not Found after deletion
    }
}
