<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarksheetRequest;
use Illuminate\Http\Request;
use App\Interfaces\MarksheetInterface;
use App\Models\Marksheet;
use Illuminate\Support\Facades\Auth;
use PDF;


class MarksheetController extends Controller
{
    private $marksheetRepository;

    public function __construct(MarksheetInterface $marksheetRepository)
    {
        $this->marksheetRepository = $marksheetRepository;
    }

    public function index()
    {
        $marksheets = $this->marksheetRepository->getAll();
        $marks = Marksheet::where('user_id', Auth()->user()->id)->with('user')->first();
        return view('marksheet', compact('marksheets', 'marks'));
    }


    public function update(Request $request)
    {
        return $this->marksheetRepository->updateMarks($request);
    }
    public function download($id)
    {
        return $this->marksheetRepository->downloadMarksheet($id);
    }
}
