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
        $book = new Book($request->toArray());
        // save image path, move image to directory
        if (isset($request->image)) {
            $image = $request->image;
            $name = config('image.name_prefix') . "-" . $image->hashName();
            $folder = config('image.books.path_upload');
            $saveImageResult = $image->move($folder, $name);

            $book->image = $name;
        } else {
            $book->image = config('image.books.no_image_name');
            $saveImageResult = true;
        }

        //save new donator
        $user = User::where('employee_code', $request->employee_code)->first();
        if (empty($user)) {
            $donatorData = [
                'employee_code' => $request->employee_code,
            ];
        } else {
            $donatorData = [
                'user_id' => $user->id,
                'employee_code' => $user->employee_code,
                'email' => $user->email,
                'name' => $user->name,
            ];
        }
        $donator = Donator::updateOrCreate(['employee_code' => $request->employee_code], $donatorData);
        $book->donator_id = $donator->id;

        $result = $book->save();

        //save new qrcode
        $lastestQRCode = QrCode::select('code_id')->withTrashed()->orderby('code_id', 'desc')->first();
        if (empty($lastestQRCode)) {
            $lastestCodeId = QrCode::DEFAULT_CODE_ID;
        } else {
            $lastestCodeId = $lastestQRCode->code_id + 1;
        }
        $book->qrcode()->save(
            new QrCode([
                'prefix' => QrCode::QRCODE_PREFIX,
                'code_id'=> $lastestCodeId,
            ])
        );

        if ($result && $saveImageResult) {
            flash(__('Create success'))->success();
            return redirect()->route('books.index');
        } else {
            flash(__('Create failure'))->error();
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
     * @param App\Model\Book $book pass book object
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categoryFields = [
            'id',
            'name'
        ];
        $categories = Category::select($categoryFields)->where('id', '<>', Book::DEFAULT_CATEGORY)->get();
        return view('backend.books.edit', compact('book', 'categories'));
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
        $bookData = $request->except('_token', '_method', 'image');
        // save image path, move image to directory
        if ($request->hasFile('image')) {
            $oldImage= config('image.books.path_upload') . $book->image;
            $notDefaultImage = ($book->image != config('image.books.no_image_name'));
            $image = $request->image;
            $name = config('image.name_prefix') . "-" . $image->hashName();
            $bookData['image'] = $name;
        }

        //save new donator
        $user = User::where('employee_code', $request->employee_code)->first();
        if (empty($user)) {
            $donatorData = [
                'employee_code' => $request->employee_code,
            ];
        } else {
            $donatorData = [
                'user_id' => $user->id,
                'employee_code' => $user->employee_code,
                'email' => $user->email,
                'name' => $user->name,
            ];
        }
        $donator = Donator::updateOrCreate(['employee_code' => $request->employee_code], $donatorData);
        $bookData['donator_id'] = $donator->id;

        if ($book->update($bookData)) {
            if ($request->hasFile('image')) {
                if (File::exists($oldImage) && $notDefaultImage) {
                    File::delete($oldImage);
                }
                $folder = config('image.books.path_upload');
                if ($image->move($folder, $name)) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $result = true;
            }
        } else {
            $result = false;
        }

        if ($result) {
            flash(__('Edit success'))->success();
            return redirect('/admin/books');
        } else {
            flash(__('Edit failure'))->error();
            return redirect()->back()->withInput();
        }
    }
}
