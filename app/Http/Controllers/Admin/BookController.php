<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use DB;
use App\Model\User;
use App\Model\Donator;
use App\Http\Requests\BookEditRequest;
use File;
use App\Model\QrCode;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Database\QueryException;
use Exception;
use Storage;
use Excel;
use App\Http\Requests\ImportBookRequest;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = [
            'id',
            'name'
        ];
        $categories = Category::select($fields)->where('id', '<>', Book::DEFAULT_CATEGORY)->get();
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Store a newly book created resource in storage.
     *
     * @param App\Http\Requests\BookCreateRequest $request create request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $book = new Book($request->toArray());
            // save image path, move image to directory
            $hasFile = $request->hasFile('image');
            if ($hasFile) {
                $book->image = $book->uploadImage($request);
            } else {
                $book->image = config('image.books.default_path') . config('image.books.no_image_name');
            }
            //save new donator, save book
            $book->donator_id = Donator::updateDonator($request->employee_code);
            $book->save();
            //save new qrcode
            $book->qrcode()->save(QrCode::generateQRCode());
            DB::commit();
            flash(__('book.message.create_success'))->success();
            return redirect()->route('books.index');
        } catch (FileException $e) {
            $errMessage = __('book.message.create_fail') . __('book.message.err_upload_image');
        } catch (QueryException $e) {
            $errMessage = __('book.message.create_fail') . __('book.message.err_long_data');
        } catch (Exception $e) {
            $errMessage = __('book.message.create_fail');
        }
        if (isset($errMessage)) {
            DB::rollBack();
            if ($hasFile) {
                Storage::disk('public')->delete($book->image);
            }
            flash($errMessage)->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display list book with filter ( if have ).
     *
     * @param Request $request requests
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            'books.id',
            'name',
            'author',
            'avg_rating',
            'total_rating',
            'qrcodes.prefix',
            'qrcodes.code_id',
        ];

        $books = Book::select($columns)->join('qrcodes', 'qrcodes.book_id', '=', 'books.id')->leftJoin('borrowings', 'borrowings.book_id', 'books.id');
        if ($request->has('search') && $request->has('choose')) {
            $search = $request->search;
            $choose = $request->choose;
            $books = Book::search($search, $choose);
        }

        $books = $books->withCount('borrowings')->sortable()->orderby('id', 'desc')->paginate(config('define.page_length'));

        if ($request->has('uid') && $request->has('filter')) {
            $uid = $request->uid;
            $filter = $request->filter;
            $books = Book::whereHas(config('define.filter.' . $filter), function ($query) use ($uid) {
                $query->where('user_id', '=', $uid);
            })->withCount('borrowings')->sortable()->orderby('id', 'desc')->paginate(config('define.page_length'));
        }

        return view('backend.books.list', compact('books'));
    }

    /**
     * Show the form with book data for edit book.
     *
     * @param App\Model\Book          $book    pass book object
     * @param Illuminate\Http\Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book, Request $request)
    {
        $categoryFields = [
            'id',
            'name'
        ];
        if (!empty($request->input('page'))) {
            $backPath = $request->input('page');
        } else {
            $backPath = config('define.list_book_path');
        }
        $categories = Category::select($categoryFields)->where('id', '<>', Book::DEFAULT_CATEGORY)->get();
        return view('backend.books.edit', compact('book', 'categories', 'backPath'));
    }


    /**
     * Save data book edited.
     *
     * @param App\Http\Requests\BookEditRequest $request book edit information
     * @param App\Model\Book                    $book    pass book object
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BookEditRequest $request, Book $book)
    {
        DB::beginTransaction();
        try {
            $bookData = $request->except('_token', '_method', 'image');
            // save image path, move image to directory
            $hasImage = $request->hasFile('image');
            if ($hasImage) {
                $oldImage = $book->image;
                $defaultPath = config('image.books.default_path');
                $defaultImage = config('image.books.no_image_name');
                $isNotDefaultImage = ($oldImage != ($defaultPath . $defaultImage)) ? true : false;
                $bookData['image'] = $book->uploadImage($request, $oldImage);
            }
            //save new donator
            $bookData['donator_id'] = Donator::updateDonator($request->employee_code);
            $book->update($bookData);
            DB::commit();
            if ($hasImage && $isNotDefaultImage) {
                Storage::disk('public')->delete($oldImage);
            }
            flash(__('book.message.edit_success'))->success();
            return redirect()->to($request->back_path);
        } catch (Exception $e) {
            $errMessage = __('book.message.edit_fail');
            if ($e instanceof FileException) {
                $errMessage = __('book.message.edit_fail') . __('book.message.err_upload_image');
            } elseif ($e instanceof QueryException) {
                $errMessage = __('book.message.edit_fail') . __('book.message.err_long_data');
            }
            DB::rollBack();
            if ($hasImage) {
                Storage::disk('public')->delete($bookData['image']);
            }
            flash($errMessage)->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Load vcs file and save list into db
     *
     * @param Request $request get request
     *
     * @return \Illuminate\Http\Response
     */
    public function import(ImportBookRequest $request)
    {
        DB::beginTransaction();
        try {
            Excel::load($request->file('import-data'), function ($reader) {
                $reader->ignoreEmpty()->each(function ($cell) {
                    $this->addBookImport($cell->toArray());
                });
            });
            DB::commit();
            flash(__('book.import.success'))->success();
            return redirect()->route('books.index');
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('book.import.fail'))->error();
            return redirect()->back();
        }
    }

    /**
     * Insert list into db
     *
     * @param array $attributes attribute list
     *
     * @return void
     */
    public function addBookImport($attributes)
    {
        $qrcodeList = explode(',', $attributes['qrcode']);
        for ($i = 0, $length = sizeof($qrcodeList); $i < $length; $i++) {
            $qrCode = trim($qrcodeList[$i], ' ');
            $qrCode = [
                'prefix' => substr($qrCode, config('define.qrcode.begin_prefix_pos'), config('define.qrcode.end_prefix_pos')),
                'code_id' => substr($qrCode, config('define.qrcode.end_prefix_pos'))
            ];
            $bookData = Book::updateOrCreateBook($qrCode, $this->convertFitData($attributes));
            QrCode::saveImportQRCode($qrCode, $bookData);
        }
    }

    /**
     * Get data excel and revert it to book attributes array
     *
     * @param array $attributes book's attribute
     *
     * @return array
     */
    public function convertFitData($attributes)
    {
        $employeeCode = ($attributes['employee_code'] != "NULL") ? $attributes['employee_code'] : Donator::DEFAULT_DONATOR;
        return [
            'name' => $attributes['name'],
            'category_id' => Category::lockForUpdate()->firstOrCreate(['name' => $attributes['category']])->id,
            'status' => (isset($attributes['status']) && $attributes['status'] == 'available') ? QrCode::QR_CODE_NOT_PRINTED : QrCode::QR_CODE_PRINTED,
            'donator_id' => Donator::updateDonator($employeeCode, $attributes['user_name']),
            'author' => isset($attributes['author']) ? $attributes['author'] : BOOK::DEFAULT_AUTHOR,
            'image' => config('image.books.default_path') . config('image.books.no_image_name'),
            'year' => isset($attributes['year']) ? $attributes['year'] : Carbon::now()->year,
            'description' => isset($attributes['description']) ? '<p>' . $attributes['description'] . '</p>' : BOOK::DEFAULT_DESCRIPTION,
            'language' => $attributes['language'],
            'pages' => isset($attributes['pages']) ? $attributes['pages'] : Book::DEFAULT_PAGES,
            'price' => isset($attributes['price']) ? $attributes['price'] : Book::DEFAULT_PRICE
        ];
    }
}
