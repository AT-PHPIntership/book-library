<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Model\Category;
use Illuminate\Pagination\Paginator;
use App\Model\User;
use App\Model\Donator;
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
        $categories = Category::select($fields)->get();
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
        if ($user === null) {
            $donatorData = [
                'employee_code' => $request->employee_code,
            ];
        } else {
            $donatorData = [
                'user_id' => $user->id,
                'employee_code' => $user->employee_code,
                'email' => $user->email,
            ];
        }
        $donator = Donator::updateOrCreate(['employee_code' => $request->employee_code], $donatorData);
        $book->donator_id = $donator->id;

        $result = $book->save();

        //save new qrcode
        $lastestCodeId = QrCode::select('code_id')->orderby('code_id', 'desc')->first();
        if ($lastestCodeId === null) {
            $lastestCodeId = QrCode::DEFAULT_CODE_ID;
        } else {
            $lastestCodeId = $lastestCodeId->code_id + 1;
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
     * Display list book.
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
        return view('backend.books.list', compact('books'));
    }
}
