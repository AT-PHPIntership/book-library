<?php

namespace Tests\Browser\Pages\Backend\Qrcodes;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Backend\Users\BaseTestUser;
use Faker\Factory as Faker;
use App\Model\QrCode;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use DB;

class AdminQRCodesTest extends BaseTestUser
{
    use DatabaseMigrations;

    private $adminUserToLogin;
    
    /**
    * Override function setUp()
    *
    * @return void
    */
    public function setUp()
    {
        parent::setUp();
        $this->adminUserToLogin = $this->makeAdminUserToLogin();
    }

    /**
     * A Dusk test route to page list QR Codes.
     *
     * @return void
     */
    public function testRouteListQRCodes()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin')
                    ->clickLink('QR Codes')
                    ->assertPathIs('/admin/qrcodes')
                    ->assertSee('List QR Codes');
        });
    }

    /**
     * Test layout of List QR Codes.
     *
     * @return void
     */
    public function testLayoutListQRCodes()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->assertSee('List QR Codes')
                    ->assertSeeLink('Admin')
                    ->assertSeeIn('#table-qrcodes thead tr th:nth-child(1)', 'ID')
                    ->assertSeeIn('#table-qrcodes thead tr th:nth-child(2)', 'Name of Book')
                    ->assertSeeIn('#table-qrcodes thead tr th:nth-child(3)', 'Author')
                    ->assertSeeIn('#table-qrcodes thead tr th:nth-child(4)', 'QR Codes')
                    ->assertSeeLink('Export');
        });
    }

    /**
     * Check the list of QR Codes without data
     *
     * @return void
     */
    public function testShowListQRCodesWithoutData()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes');
            $elements = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     * Check list QR Codes with showing only 8 rows
     *
     * @return void
     */
    public function testListQRCodesWithoutPagination()
    {
        $this->makeDataOfListQRCodes(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes');
            $elements = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(8, $elements);
        });
    }

    /**
     * A Dusk test Pagination
     *
     * @return void
     */
    public function testListQRCodesWithPagination()
    {
        $this->makeDataOfListQRCodes(25);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes');
            $elements = $browser->elements('.pagination li');
            $numberPage = count($elements) - 2;
            $this->assertTrue($numberPage == ceil(25 / (config('define.page_length'))));
        });
    }


    /**
     * Check list QR Codes with showing than 10 rows
     *
     * @return void
     */
    public function testListQRCodesHavePagination()
    {
        $this->makeDataOfListQRCodes(15);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes')
                    ->click('.pagination li:nth-child(3) a');
            $elements = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(5, $elements);
            $browser->assertQueryStringHas('page', 2);
            $this->assertNotNull($browser->element('.pagination'));
        });
    }

    /**
     * Test see button export QR Codes.
     *
     * @return void
     */
    public function testSeeButtonExportInListQRCodes()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->assertSee('List QR Codes')
                    ->assertSeeIn('.content-wrapper .content .export', 'Export')
                    ->assertSeeLink('Export');
        });
    }

    /**
     * Test list QR Codes after export.
     *
     * @return void
     */
    public function testAfterExport()
    {
        $this->makeDataOfListQRCodes(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->assertSee('List QR Codes');
            $elementBeforeExport = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(8, $elementBeforeExport);
            $browser->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes')
                    ->clickLink('Export')
                    ->pause(3000)
                    ->visit('/admin/qrcodes')
                    ->pause(3000);
            $elementAfterExport = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(0, $elementAfterExport);
        });
    }

    /**
     * Test export QR Codes fail.
     *
     * @return void
     */
    public function testExportQRCodesFail()
    {
        $this->makeDataOfListQRCodes(8);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUserToLogin)
                    ->visit('/admin/qrcodes')
                    ->resize(1200, 1600)
                    ->assertSee('List QR Codes')
                    ->assertDontSee('Export failed - Data is empty')
                    ->clickLink('Export')
                    ->pause(5000)
                    ->visit('/admin/qrcodes')
                    ->clickLink('Export')
                    ->pause(2000)
                    ->assertSee('Export failed - Data is empty');
            $ExportEmptyData = $browser->elements('#table-qrcodes tbody tr');
            $this->assertCount(0, $ExportEmptyData);
        });
    }

    /**
     * Create virtual data to test
     *
     * @return void
     */
    public function makeDataOfListQRCodes($row)
    {
        $faker = Faker::create();

        for ($i = 0; $i <= 20; $i++) {
            factory(Book::class)->create([
                'category_id'   => function () {
                    return factory(Category::class)->create()->id;
                },
                'donator_id'    => function () {
                    return factory(Donator::class)->create()->id;
                },
                'name'          =>  str_random(10),
                'author'        =>  str_random(8),
            ]);
        }
        $bookIds = DB::table('books')->pluck('id')->toArray();

        for ($i = 1; $i <= $row; $i++) {
            factory(QrCode::class)->create([
                'book_id'   => $faker->randomElement($bookIds),
                'prefix'    => str_random(3).'-',
                'code_id'   => $i,
                'status'    => 1,
            ]);
        }
        $qrcodeIds = DB::table('qrcodes')->pluck('id')->toArray();
    }
}
