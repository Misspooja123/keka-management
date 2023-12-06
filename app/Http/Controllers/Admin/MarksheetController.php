<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MarksheetDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;


use App\Models\Marksheet;

class MarksheetController extends Controller
{

    public function index(MarksheetDataTable $dataTable)
    {
        return $dataTable->render('admin.auth.marksheet.marksheet_index');
    }
    public function download($id) {
        $marksheet = Marksheet::with('user')->find($id);

        if (!$marksheet) {
            abort(404);
        }
        $pdf = PDF::loadView('admin.auth.marksheet.marksheetpdf', compact('marksheet'));
        return $pdf->download('marksheet_' . $marksheet->id . '.pdf');
    }
}
