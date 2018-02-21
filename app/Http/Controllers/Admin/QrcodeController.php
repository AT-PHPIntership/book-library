<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\QrCode;

class QrcodeController extends Controller
{
    /**
     * Display a list of QR Codes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'qrcodes.id',
            'books.name',
            'books.author',
            'qrcodes.prefix',
            'qrcodes.code_id',
        ];

        $qrcodes = QrCode::select($fields)
                          ->QRCodesNotPrinted()
                          ->join('books', 'qrcodes.book_id', 'books.id')
                          ->paginate(config('define.page_length'));
        return view('backend.qrcodes.index', compact('qrcodes'));
    }
}
