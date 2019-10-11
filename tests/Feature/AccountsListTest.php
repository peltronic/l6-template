<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

use App\Models\Account;
use App\Models\Listing;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class AccountsListTest extends TestCase
{
    use RefreshDatabase, ArraySubsetAsserts;

    public function testResponseStructure()
    {
        $accounts = factory(Account::class, 5)->make()->each(function (Account $account) {
            $account->save();
            $account->listings()->saveMany([
                factory(Listing::class)->create(),
            ]);
        });

        //$response = $this->getJson('/api/accounts');
        //$response = $this->actingAs($user,'web')->ajaxJSON('POST',$url,$payload);
        $response = $this->ajaxJSON('GET','/api/accounts',[]);

        //$content = json_decode($response->content());
        //dd($content);

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
        ]);
    }

    public function testListWithoutFilters()
    {
        $accounts = factory(Account::class, 5)->make()->each(function (Account $account) {
            $account->save();
            $account->listings()->saveMany([
                factory(Listing::class)->create(),
            ]);
        });
        //dd($accounts);

        $response = $this->ajaxJSON('GET','/api/accounts',[]);

        $response->assertStatus(200);
        $this->assertResponseContainsAccounts($response, ...$accounts);
    }

    // %TODO: impl filtering using Query Scopes
    public function testNameFilter()
    {
        $account1 = factory(Account::class)->create(['aname' => 'PHP for beginners']);
        $account2 = factory(Account::class)->create(['aname' => 'Javascript for dummies']);
        $account3 = factory(Account::class)->create(['aname' => 'Advanced Python']);

        $querystr = 'for';
        $response = $this->ajaxJSON('GET','/api/accounts',['filters'=>['aname'=>$querystr]]); // %FIXME: should fail
        $response->assertStatus(200);
        $content = json_decode($response->content(),true);
        //dd($content['data']);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'aname',
                    ],
                ],
        ]);

        foreach ( $content['data'] as $i => $d ) {
            $this->assertRegExp('/'.$querystr.'/', $d['aname']); // contains string
        }

        /*
        $account1->aname = 'blah';
        $account2->aname = 'blah';
         */

        $a = $content['data'];
        $s = [$this->accountToResourceArray($account1)];
        //dd( $a );
        //dd( $s );
        //$this->assertArraySubset( $s, $a );
        self::assertArraySubset( $s, $a );

    }

    // ---------------------------------------------


    private function assertResponseContainsAccounts(TestResponse $response, ...$accounts): void
    {
        $response->assertJson([
            'data' => array_map(function (Account $account) {
                return $this->accountToResourceArray($account);
            }, $accounts),
        ]);
        // The assertJson method converts the response to an array and utilizes PHPUnit::assertArraySubset to verify that the given array exists within the JSON response returned by the application. So, if there are other properties in the JSON response, this test will still pass as long as the given fragment is present.
    }


    /*
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
     */
}
