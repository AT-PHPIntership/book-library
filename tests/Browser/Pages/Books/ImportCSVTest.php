<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\User;
use App\Model\Book;
use App\Model\Category;
use App\Model\Donator;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Excel;

class ImportCSVTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;

    /**
     * Checking database condition
     */
    const HAS = 1;

    /**
     * Checking database condition
     */
    const MISSING = 0;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->fakeUser();
    }

    /**
     * Test validate file type
     * 
     * @return void
     */
    public function testValidateFile()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('admin/books')
                ->resize(1600, 2000)
                ->press('#accordion')
                ->attach('import-data', $this->fakeExcelFile())
                ->press('OK')
                ->assertSee('Only support csv file type');
        });
    }

    /**
     * Test import book success.
     *
     * @return void
     */
    public function testImportBookSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('admin/books')
                ->resize(1600, 2000)
                ->press('#accordion')
                ->attach('import-data', base_path() . "/tests/files/csv/AT-Book List-success.csv")
                ->press('OK')
                ->assertSee('Import list book successfully');
 
            $totalRecord = Book::count();
            $bookRow = $browser->elements('#table-book tbody tr');
            $this->assertCount($totalRecord, $bookRow);
        });

        $data = Excel::load('/tests/files/csv/AT-Book List-success.csv')->get();
        $this->checkExistsDataBase($data, self::HAS);
    }

    /**
     * Test import book success.
     *
     * @return void
     */
    public function testImportBookFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('admin/books')
                ->resize(1600, 2000)
                ->press('#accordion')
                ->attach('import-data', base_path() . "/tests/files/csv/AT-Book List-fail.csv")
                ->press('OK')
                ->assertSee('Import list book failure');
 
            $totalRecord = Book::count();
            $bookRow = $browser->elements('#table-book tbody tr');
            $this->assertCount(1, $bookRow);
        });

        $data = Excel::load('/tests/files/csv/AT-Book List-fail.csv')->get();
        $this->checkExistsDataBase($data, self::MISSING);
    }

    /**
     * Check exists data or not in database
     * 
     * @param array   $data data import
     * @param integer $type checking db type
     * 
     * @return void
     */
    public function checkExistsDataBase($data, $type)
    {
        $donator = Donator::where('employee_code', $data[0]->employee_code)->first();
        $donatorId = 1;
        if ($donator != null){
            $donatorId = $donator->id;
        }
        $dataImported = [
            'category_id' => 1,
            'name' => $data[0]->name,
            'donator_id' => $donatorId,
            'author' => $data[0]->author,
            'pages' => $data[0]->pages,
            'language' => $data[0]->language,
            'description' => '<p>' . $data[0]->description . '</p>',
        ];
        if ($type == self::HAS)
            $this->assertDatabaseHas('books', $dataImported);
        elseif ($type == self::MISSING) {
            $this->assertDatabaseMissing('books', $dataImported);
        }
    }

    /**
     * Adding user for testing
     * 
     * @return void
     */
    public function fakeUser() {
        $user = [
            'employee_code' => 'AT0468',
            'name'          => 'Anh Ngo Q.',
            'email'         => 'sa.as@asiantech.vn',
            'team'          => 'SA',
            'role'          => 1,
        ];
        return $user = factory(User::class, 1)->create($user);
    }

    /**
     * Fake a file for import
     *
     * @return void
     */
    public function fakeExcelFile() {
        return UploadedFile::fake()->create('excel.xlsx');
    }
}
