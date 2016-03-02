<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testShowtask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showTask');
    }

    public function testShowalltasks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllTasks');
    }

}
