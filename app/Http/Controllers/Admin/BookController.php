<?php

namespace App\Http\Controllers\Admin;

use App\Model\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\User;
use App\Model\Donator;
use App\Http\Requests\BookEditRequest;
use File;
use Illuminate\Pagination\Paginator;
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
        if ($request->hasFile('image') && ($book->image != config('image.books.no_image_name'))) {
            $oldPath = config('image.books.path_upload') . $book->image;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
            $image = $request->image;
            $name = config('image.name_prefix') . "-" . $image->hashName();
            $folder = config('image.books.path_upload');
            $image->move($folder, $name);
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

        $result = $book->update($bookData);

        if ($result) {
            flash(__('Edit success'))->success();
            return redirect()->route('books.index');
        } else {
            flash(__('Edit failure'))->error();
            return redirect()->back()->withInput();
        }
    }
}
