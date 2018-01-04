<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.books.edit');
    }
}
