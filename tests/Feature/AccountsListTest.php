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

    public function testAnameFilter()
    {
        $account1 = factory(Account::class)->create(['aname' => 'PHP for beginners']);
        $account2 = factory(Account::class)->create(['aname' => 'Javascript for dummies']);
        $account3 = factory(Account::class)->create(['aname' => 'Advanced Python']);

        $searches = [ 'PHP', 'for', 'nothing' ];

        foreach ( $searches as $querystr ) {
            $response = $this->ajaxJSON('GET','/api/accounts',['filters'=>['aname'=>$querystr]]);
            $response->assertStatus(200);
            $content = json_decode($response->content(),true); //dd($content['data']);
            foreach ( $content['data'] as $i => $d ) {
                $this->assertRegExp('/'.$querystr.'/', $d['aname']); // test that each result contains query string
            }
        }

        /*
        $a = $content['data'];
        $s = [$this->accountToResourceArray($account1)];
        self::assertArraySubset( $s, $a ); //dd( $a, $s );
         */

    }

    public function testSearch()
    {
        $account1 = factory(Account::class)->create(['aname' => 'PHP for beginners']);
        $account2 = factory(Account::class)->create(['aname' => 'Javascript for dummies']);
        $account3 = factory(Account::class)->create(['aname' => 'Advanced Python']);
        list($guid2) = explode('-',$account2->guid);

        $searches = [
            'guid' => $guid2,  // %TODO: make these arrays, to test case for no matches, etc
            'aname' => 'PHP',
            'slug' => 'for',
        ];

        foreach ( $searches as $field => $searchstr ) {
            $response = $this->ajaxJSON('GET','/api/accounts',['search'=>$searchstr]);
            $response->assertStatus(200);
            $content = json_decode($response->content(),true); //dd($content);
            foreach ( $content['data'] as $i => $d ) {
                $this->assertRegExp('/'.$searchstr.'/', $d[$field]); // test that each result contains query string
            }
        }
    }

    public function testSearchNotFound()
    {
        $account1 = factory(Account::class)->create(['aname' => 'PHP for beginners']);
        $account2 = factory(Account::class)->create(['aname' => 'Javascript for dummies']);
        $account3 = factory(Account::class)->create(['aname' => 'Advanced Python']);
        list($guid2) = explode('-',$account2->guid);

        $searches = [
            'guid' => 'nothing',
        ];

        foreach ( $searches as $field => $searchstr ) {
            $response = $this->ajaxJSON('GET','/api/accounts',['search'=>$searchstr]);
            $response->assertStatus(200);
            $content = json_decode($response->content(),true); //dd($content);
            foreach ( $content['data'] as $i => $d ) {
                $this->assertRegExp('/'.$searchstr.'/', $d[$field]); // test that each result contains query string
            }
        }
    }

    public function testAnameSort()
    {
        $account1 = factory(Account::class)->create(['aname' => 'PHP for begginers']);
        $account2 = factory(Account::class)->create(['aname' => 'Javascript for dummies']);
        $account3 = factory(Account::class)->create(['aname' => 'Advanced Python']);

        // ---

        $response = $this->ajaxJSON('GET','/api/accounts?sort_on=aname');
        $response->assertStatus(200);

        $content = json_decode($response->content(),true); //dd($content)
        //dd($content);

        $this->assertResponseContainsAccounts($response, $account3, $account2, $account1);

        // ---

        $response = $this->ajaxJSON('GET','/api/accounts?sort_on=aname&is_sort_asc=0');
        $response->assertStatus(200);

        $content = json_decode($response->content(),true); //dd($content)
        //dd($content);

        $this->assertResponseContainsAccounts($response, $account1, $account2, $account3);
    }

    public function testPagination()
    {
        $accounts = factory(Account::class, 30)->create();
        $firstPageAccounts = $accounts->forPage(1, 15);
        $secondPageAccounts = $accounts->forPage(2, 15);

        $response = $this->ajaxJSON('GET','/api/accounts?page=1');
        $response->assertStatus(200);

        $this->assertResponseContainsAccounts($response, ...$firstPageAccounts);

        $response = $this->ajaxJSON('GET','/api/accounts?page=2');
        $response->assertStatus(200);

        $this->assertResponseContainsAccounts($response, ...$secondPageAccounts);
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
