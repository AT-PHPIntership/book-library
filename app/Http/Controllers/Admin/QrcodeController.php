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
        DB::beginTransaction();
        try {
            $fields = [
                'qrcodes.id',
                'books.name',
                'books.author',
                DB::raw("CONCAT(qrcodes.prefix, qrcodes.code_id) AS QR_Codes")
            ];
            $datas = QrCode::select($fields)->QRCodesNotPrinted()->join('books', 'qrcodes.book_id', 'books.id')->get();
            
            foreach ($datas as $data) {
                $id = $data['id'];
                QrCode::where('id', $id)
                    ->update(['status' => QrCode::QR_CODE_PRINTED]);
            };
            DB::commit();
            
            Excel::create('QRCodes', function ($excel) use ($datas) {
                
                $excel->sheet('mySheet', function ($sheet) use ($datas) {
                    $sheet->fromArray($datas);
                });
            })->export('csv');
            
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
