<?php

namespace Tests\Functional;

use App\Helpers\HttpClient;
use PHPUnit\Framework\TestCase;

class HomepageTest extends TestCase
{
    public function testItCanVisitHomePageAndSeeRelevantData()
    {
        $client = new HttpClient();
        $response = $client->get("http://localhost/bug-tracker/index.php");

        $response = json_decode($response);
        self::assertEquals(200, $response->statusCode);
        self::assertStringContainsString('Bug Report Manager', $response->content);
        self::assertStringContainsString("<h2>Manage <b>Bug Reports</b></h2>", $response->content);
    }
}
