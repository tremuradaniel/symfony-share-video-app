<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Category;

class AdminControllerCategoriesTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }
    public function testTextOnPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertStringContainsString('Electronics', $this->client->getResponse()->getContent());
    }
}
