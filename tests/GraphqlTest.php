<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class GraphqlTest extends ApiTestCase
{
    public function testGetBook()
    {
        $client = static::createClient();

        $query = '{
            book(id: "api/books/1") {
                id 
                title
            }
        }';

        $response = $client->request('POST', '/api/graphql', [
            'json' => [
                'query' => $query,
            ],
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertIsString($data['data']['book']['title']);
        $this->assertNotEmpty($data['data']['book']['title']);
    }

    public function testCreateBook()
    {
        $client = static::createClient();

        $query = 'mutation {
        createBook(input: {
            title: "Mon nouveau livre",
            isbn: "1234567890",
            description: "Une description de mon livre",
            author: "api/authors/1"
        }) {
            book {
                id
                title
                isbn
                description
                author {
                    id
                    name
                    birthdate
                }
            }
        }
    }';

        $response = $client->request('POST', '/api/graphql', [
            'json' => [
                'query' => $query,
            ],
        ]);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $result = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('createBook', $result['data']);
        $this->assertArrayHasKey('book', $result['data']['createBook']);
        $this->assertEquals('Mon nouveau livre', $result['data']['createBook']['book']['title']);
        $this->assertEquals('1234567890', $result['data']['createBook']['book']['isbn']);
    }
}
