<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // see: vendor//laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php
    public function ajaxJSON($method,$uri, array $data=[]) {
        return $this->json($method,$uri,$data,['HTTP_X-Requested-With'=>'XMLHttpRequest']);
    }
}
