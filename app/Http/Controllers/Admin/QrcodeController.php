<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\QrCode;
use Excel;
use DB;

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

    /**
     * Export QR Codes Not Printed.
     *
     * @return mixed
     */
    public function exportCSV()
    {
        try {
            $fields = [
                'qrcodes.id',
                'books.name',
                'books.author',
                DB::raw("CONCAT(qrcodes.prefix, qrcodes.code_id) AS QR_Codes")
            ];
            $datas = QrCode::select($fields)->QRCodesNotPrinted()->join('books', 'qrcodes.book_id', 'books.id')->get();
            
            if ($datas->isNotEmpty()) {
                QrCode::where('status', Qrcode::QR_CODE_NOT_PRINTED)
                    ->update(['status' => QrCode::QR_CODE_PRINTED]);

                Excel::create('QRCodes', function ($excel) use ($datas) {
                    $excel->sheet('mySheet', function ($sheet) use ($datas) {
                        $sheet->fromArray($datas);
                    });
                })->export('csv');
            } else {
                flash(__('qrcode.message.fail'))->error();
                return redirect()->route('qrcodes.index');
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
