<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testAddcategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addCategory');
    }

}
