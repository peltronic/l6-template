<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Account;
use App\Models\Listing;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // see: vendor//laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php
    public function ajaxJSON($method,$uri, array $data=[]) {
        return $this->json($method,$uri,$data,['HTTP_X-Requested-With'=>'XMLHttpRequest']);
    }

    protected function accountToResourceArray(Account $obj)
    {
        return [
            'id' => $obj->id,
            'aname' => $obj->aname,
            'adesc' => $obj->adesc,
            'listings' => [],
        ];
        /*
        return [
            'id' => $account->id,
            'isbn' => $account->isbn,
            'title' => $account->title,
            'description' => $account->description,
            'authors' => $account->authors->map(function (Author $author) {
                return ['id' => $author->id, 'name' => $author->name, 'surname' => $author->surname];
            })->toArray(),
            'review' => [
                'avg' => (int) round($account->reviews->avg('review')),
                'count' => (int) $account->reviews->count(),
            ],
        ];
         */
    }
}
