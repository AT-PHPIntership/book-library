<?php

namespace Tests\Browser\Pages\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Category;
use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Http\UploadedFile;
use App\Model\Book;
use Faker\Factory as Faker;
use DB;
use App\Model\Donator;
use Carbon\Carbon;

class EditBookTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->fakeUser();
        $faker = Faker::create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        factory(Donator::class, 10)->create([
            'user_id' => $faker->unique()->randomElement($userIds)
        ]);
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $donatorIds = DB::table('donators')->pluck('id')->toArray();
        $book = factory(Book::class, 15)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'donator_id' => $faker->randomElement($donatorIds),
            'image'      => 'no-image.png',
        ]);
    }

    public function testAccessEditBook()
    {
        $book = Book::findOrFail(1);
        $this->browse(function (Browser $browser) use ($book) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1600, 2000)
                    ->click('.btn-edit-1')
                    ->assertSee('Edit Book')
                    ->assertInputValue('name', $book->name)
                    ->assertInputValue('author', $book->author)
                    ->assertInputValue('price', $book->price)
                    ->assertInputValue('year', $book->year)
                    ->assertSelected('category_id', $book->category->id)
                    ->assertInputValue('employee_code', $book->donator->employee_code)
                    ->assertInputValue('description', $book->description)
                    ->assertSourceHas('no-image.png')->screenshot('abc');
        });
    }  

    /**
     * Example test case
     * 
     * @return array
     */
    public function validationTestCase() {
        return [
            ['', '7', 'Example Author', '10009', 'AT-00001', '2018', 'This is description', $this->fakeImage(), ['The name field is required']],
            ['Example Book', '7', '', '10009', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The author field is required']],
            ['Example Book', '7', 'Example Author', '', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The price field is required']],
            ['Example Book', '7', 'Example Author', 'abc', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The price must be a number']],
            ['Example Book', '7', 'Example Author', '10009', '', '2018', 'This is description', $this->fakeImage(),['The employee code field is required']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '1800', 'This is description', $this->fakeImage(),['The year must be at least 1900']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2020', 'This is description', $this->fakeImage(),['The year may not be greater than ' . Carbon::now()->year]],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2018', '', $this->fakeImage(),['The description field is required']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2018', 'This is description', $this->fakeNotImage(),['The image must be an image']],
        ];
    }

    /**
     * @dataProvider validationTestCase
     * 
     */
    public function testEditBookValidation($name, $category_id, $author, $price, $donator_id, $year, $description, $image,$messages)
    {
        $this->browse(function (Browser $browser) use ($name, $category_id, $author, $price, $donator_id, $year, $description, $image, $messages) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books/create')
                    ->resize(1600, 2000)
                    ->type('name', $name)
                    ->select('category_id', $category_id)
                    ->type('author', $author)
                    ->type('price', $price)
                    ->type('employee_code', $donator_id)
                    ->type('year', $year)
                    ->attach('image', $image);

            $this->typeInCKEditor('#cke_description iframe', $browser, $description);
                        
            $browser->press('Submit');
                
            foreach($messages as $message) {
                $browser->assertSee($message);
            }
        });
    }

    /**
     * Press button edit for edit success book
     *
     * @return void
     */
    public function testEditBookSuccess()
    {
        $category = Category::findOrFail(1);
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/1/edit')
                    ->resize(1600, 2000)
                    ->type('name', 'Example Book')
                    ->select('category_id', $category->id)
                    ->type('author', 'Example Author')
                    ->type('price', '10009')
                    ->type('employee_code', 'Example Author')
                    ->type('year', '2018')
                    ->attach('image', $this->fakeImage());
            $this->typeInCKEditor('#cke_description iframe', $browser, 'This is a description');
                
            $browser->press('Submit')
                    ->assertSee('Edit Success');
        });
    }

    /**
     * Press button edit, then edit book fail
     * 
     * @return void
     */
    public function testEditBookFail()
    {
        $category = Category::findOrFail(1);
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/1/edit')
                    ->resize(1600, 2000)
                    ->type('name', 'Example Book')
                    ->select('category_id', $category->id)
                    ->type('author', 'Example Author')
                    ->type('price', '10009')
                    ->type('employee_code', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lore Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lore')
                    ->type('year', '2018')
                    ->attach('image', $this->fakeImage());
            $this->typeInCKEditor('#cke_description iframe', $browser, 'This is a description');
                
            $browser->press('Submit')
                    ->assertSee('Edit fail. Invalid or unsuitable size data');
        });
    }

    /**
     * Press back button
     *
     * @return void
     */
    public function testPressBackButton() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books')
                    ->resize(1600, 2000)
                    ->clickLink(2)
                    ->click('.btn-edit-11')
                    ->clickLink('Back')
                    ->assertQueryStringHas('page', 2);

            $browser->visit('admin/books/12/edit')
                    ->resize(1600, 2000)
                    ->clickLink('Back')
                    ->assertPathIs('/admin/books');
        });
    }

    /**
     * Press reset button
     *
     * @return void
     */
    public function testPressResetButton() {
        $book = Book::findOrFail(1);
        $category = Category::findOrFail(1);
        $this->browse(function (Browser $browser) use ($book, $category) {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/1/edit')
                    ->resize(1600, 2000)
                    ->type('name', 'Example Book')
                    ->select('category_id', $category->id)
                    ->type('author', 'Example Author')
                    ->type('price', '10009')
                    ->type('employee_code', 'AT-00001')
                    ->type('year', '1996')
                    ->attach('image', $this->fakeImage());
            $this->typeInCKEditor('#cke_description iframe', $browser, 'abc');
                
            $browser->press('Reset')
                    ->assertInputValue('name', $book->name)
                    ->assertNotSelected('category_id', $category->name)
                    ->assertInputValue('author', $book->author)
                    ->assertInputValue('price', $book->price)
                    ->assertInputValue('employee_code', $book->donator->employee_code)
                    ->assertInputValue('year', $book->year)
                    ->assertInputValue('description', $book->description)
                    ->assertSourceHas('no-image.png');
        });
    }

    /**
     * Support function testing for ckeditor
     *
     * @return void
     */
    public function typeInCKEditor ($selector, $browser, $content)
    {
        $ckIframe = $browser->elements($selector)[0];
        $browser->driver->switchTo()->frame($ckIframe);
        $body = $browser->driver->findElement(WebDriverBy::xpath('//body'));
        $body->sendKeys($content);
        $browser->driver->switchTo()->defaultContent();
    }

    /**
     * Fake an image for import
     *
     * @return void
     */
    public function fakeImage() {
        return UploadedFile::fake()->image('image.jpg', 1270, 720)->size(1025000);
    }

    /**
     * Fake a file for import
     *
     * @return void
     */
    public function fakeNotImage() {
        return UploadedFile::fake()->create('image.pdf');
    }

    /**
     * Adding user for testing
     * 
     * @return void
     */
    public function fakeUser() {
        $user = [
            'employee_code' => 'AT0286',
            'name'          => 'SA Dinh Thi.',
            'email'         => 'sa.as@asiantech.vn',
            'team'          => 'SA',
            'role'          => 1,
        ];
        $user = factory(User::class, 1)->create($user);
    }
}
