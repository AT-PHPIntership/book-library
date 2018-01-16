<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Book;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes

class BookController extends Controller
{
	/**
	* Delete book and its relationship.
	*
	* @param int $id id of book
	*
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$book = Book::findOrFail($id);
		$book->softDeletes();
		$data = [
		];
		return response()->json($data);
	}
}
