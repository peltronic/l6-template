<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Account;
use App\Models\Listing;

class AccountsListTest extends TestCase
{

    use RefreshDatabase;

    public function testResponseStructure()
    {
        factory(Account::class, 5)->make()->each(function (Account $account) {
            $account->save();
            $account->listings()->saveMany([
                factory(Listing::class)->create(),
            ]);
        });

        //$response = $this->getJson('/api/accounts');
        //$response = $this->actingAs($user,'web')->ajaxJSON('POST',$url,$payload);
        $response = $this->ajaxJSON('GET','/api/accounts',[]);

        //dd($response->getContent());
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'aname',
                    'adesc',
                    'listings' => [
                        '*' => [
                            'id',
                            'ltitle',
                            'ldesc',
                        ],
                    ],
                ],
            ],
            /*
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ],
             */
        ]);
    }

    /*
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
     */
}
