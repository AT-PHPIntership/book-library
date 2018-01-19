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
     * @param App\Http\Requests\BookCreateRequest $request get create request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $book = new Book($request->toArray());
            // save image path, move image to directory
            if (isset($request->image)) {
                $book->image = $book->uploadImage($request);
            } else {
                $book->image = config('image.books.no_image_name');
            }
            //save new donator, save book
            $donator = new Donator();
            $book->donator_id = $donator->updateDonator($request->employee_code);
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
        } catch (\Exception $e) {
            $errMessage = __('book.message.create_fail');
        }
        if (isset($errMessage)) {
            DB::rollBack();
            flash($errMessage)->error();
            return redirect()->back()->withInput();
        }
    }
    
    /**
     *  * Display list book with filter ( if have ).
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            'id',
            'name',
            'author',
            'avg_rating',
            'total_rating'
        ];
        $books = Book::select($columns);

        if ($request->name) {
            $books = $books->searchname($request->name);
        }
        if ($request->author) {
            $books = $books->searchauthor($request->author);
        }

        $books = $books->withCount('borrowings')
            ->sortable()
            ->paginate(config('define.page_length'));
      
        if ($request->has('uid') && $request->has('filter')) {
            $uid = $request->uid;
            $filter = $request->filter;

            if ($filter == Book::DONATED) {
                $books = Book::whereHas('donator', function ($query) use ($uid) {
                    $query->where('user_id', '=', $uid);
                })->withCount('donator')->sortable()->paginate(config('define.page_length'));
            } elseif ($filter == Book::BORROWED) {
                $books = Book::whereHas('borrowings', function ($query) use ($uid) {
                    $query->where('user_id', '=', $uid);
                })->withCount('borrowings')->sortable()->paginate(config('define.page_length'));
            }
        } else {
            $books  = Book::with('borrowings')->withCount('borrowings')->sortable()->paginate(config('define.page_length'));
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
            if ($request->hasFile('image')) {
                $bookData['image'] = $book->uploadImage($request, $book);
            }
            //save new donator
            $donator = new Donator();
            $bookData['donator_id'] = $donator->updateDonator($request->employee_code);
            
            $book->update($bookData);
            DB::commit();
            flash(__('book.message.edit_success'))->success();
            return redirect()->to($request->back_path);
        } catch (FileException $e) {
            $errMessage = __('book.message.edit_fail') . __('book.message.err_upload_image');
        } catch (QueryException $e) {
            $errMessage = __('book.message.edit_fail') . __('book.message.err_long_data');
        } catch (\Exception $e) {
            $errMessage = __('book.message.edit_fail');
        }
        if (isset($errMessage)) {
            DB::rollBack();
            flash($errMessage)->error();
            return redirect()->back()->withInput();
        }
    }
}
