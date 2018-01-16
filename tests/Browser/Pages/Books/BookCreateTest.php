<?php

namespace Tests\Browser\Pages\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Category;
use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Http\UploadedFile;

class BookCreateTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * Validate all field empty
     *
     * @return void
     */
    public function testValidate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))->screenshot('a')
                    ->visit('admin/books/create')
                    ->resize(900, 1200)
                    ->press('Submit')
                    ->assertSee('The name field is required')
                    ->assertSee('The author field is required')
                    ->assertSee('The price field is required')
                    ->assertSee('The employee code field is required')
                    ->assertSee('The year field is required')
                    ->assertSee('The description field is required');
        });
    }

    public function validationTestCase() {
        return [
            ['', '7', 'Example Author', '10009', 'AT-00001', '2018', 'This is description', $this->fakeImage(), ['The name field is required']],
            ['Book', '7', 'Example Author', '10009', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The name must be at least 8 characters']],
            ['Example Book', '7', '', '10009', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The author field is required']],
            ['Example Book', '7', 'Example Author', '', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The price field is required']],
            ['Example Book', '7', 'Example Author', 'abc', 'AT-00001', '2018', 'This is description', $this->fakeImage(),['The price must be a number']],
            ['Example Book', '7', 'Example Author', '10009', '', '2018', 'This is description', $this->fakeImage(),['The employee code field is required']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '1800', 'This is description', $this->fakeImage(),['The year must be at least 1900']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2020', 'This is description', $this->fakeImage(),['The year may not be greater than 2019']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2018', '', $this->fakeImage(),['The description field is required']],
            ['Example Book', '7', 'Example Author', '10009', 'AT-00001', '2018', 'This is description', $this->fakeNotImage(),['The image must be an image']],
        ];
    }

    /**
     * @dataProvider validationTestCase
     * 
     */
    public function testCreateBookValidation($name, $category_id, $author, $price, $donator_id, $year, $description, $image,$messages)
    {
        $this->browse(function (Browser $browser) use ($name, $category_id, $author, $price, $donator_id, $year, $description, $image,$messages) {

            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
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
     * Press button create for create success book
     *
     * @return void
     */
    public function testCreateBookSuccess()
    {
        $this->browse(function (Browser $browser) {
            $category = factory(Category::class, 10)->create()->get(1);
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
                    ->resize(900, 1200)
                    ->type('name', 'Example Book')
                    ->select('category_id', $category->name)
                    ->type('author', 'Example Author')
                    ->type('price', '10009')
                    ->type('employee_code', 'AT-00001')
                    ->type('year', '2019')
                    ->attach('image', $this->fakeImage());
            $this->typeInCKEditor('#cke_description iframe', $browser, 'This is a description');
                
            $browser->press('Submit')
                    ->assertSee('Create success');
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
                    ->visit('admin/books/create')
                    ->resize(900, 1200)
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
        $this->browse(function (Browser $browser) {
            $category = factory(Category::class, 10)->create()->get(7);

            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
                    ->resize(900, 1200)
                    ->type('name', 'Example Book')
                    ->select('category_id', $category->name)
                    ->type('author', 'Example Author')
                    ->type('price', '10009')
                    ->type('employee_code', 'AT-00001')
                    ->type('year', '2018');
            $this->typeInCKEditor('#cke_description iframe', $browser, 'abc');
                
            $browser->press('Reset')
                    ->assertInputValue('name', '')
                    ->assertNotSelected('category_id', $category->name)
                    ->assertInputValue('author', '')
                    ->assertInputValue('price', '')
                    ->assertInputValue('employee_code', '')
                    ->assertInputValue('year', '')
                    ->assertInputValue('description', '');
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
}
