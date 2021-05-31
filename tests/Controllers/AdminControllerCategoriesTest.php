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
        // disableReboot
        // prevents from shutting down the kernel between test request and thus losing transactions
        $this->client->disableReboot();
        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
    public function testTextOnPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertStringContainsString('Electronics', $this->client->getResponse()->getContent());
    }

    public function testEditCategory(): void
    {
        $crawler = $this->client->request('GET', '/admin/edit-category/1');
        $form = $crawler->selectButton('Save')->form([
            'category[parent]' => 0,
            'category[name]' => 'Electronics 2'
        ]);
        $this->client->submit($form);
        $category = $this->entityManager->getRepository(Category::class)->find(1);
        $this->assertSame('Electronics 2', $category->getName());
    }

    public function testDeleteCategory(): void
    {
        $crawler = $this->client->request('GET', '/admin/delete-category/1');
        $category = $this->entityManager->getRepository(Category::class)->find(1);
        $this->assertNull($category);
    }

    public function testNumberOfItems()
    {
        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertCount(18, $crawler->filter('option'));
    }

    public function testNewCategory()
    {
        $crawler= $this->client->request('GET', 'admin/categories');
        $form = $crawler->selectButton('Add')->form([
            'category[parent]' => 1,
            'category[name]' => 'Other electronics'
        ]);
        $this->client->submit($form);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy([
            'name' => 'Other electronics'
        ]);
        $this->assertNotNull($category);
        $this->assertSame('Other electronics', $category->getName());
    }
}
