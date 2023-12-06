<?php

namespace App\Repositories;

use App\Interfaces\MarksheetInterface;

use App\Models\Marksheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF;


class MarksheetRepository implements MarksheetInterface
{
    public function getAll()
    {
        return Marksheet::all();
    }


    public function updateMarks(Request $request)
    {
        $total = $request->bio + $request->mathematics + $request->science + $request->socialscience + $request->english;
        $user_id = auth()->user()->id;
        $percentage = ($request->bio + $request->mathematics + $request->science + $request->socialscience + $request->english) / 5;

        if (
            $request->bio <= 25 || $request->mathematics <= 25 || $request->science <= 25 || $request->socialscience <= 25 ||
            $request->english <= 25
        ) {
            $status = '0';
        } else {
            $status = '1';
        }

        $marks = Marksheet::where('user_id', auth()->user()->id)->first();

        if ($marks != null) {
            $marks->user_id = $user_id;
            $marks->bio = $request->input('bio');
            $marks->mathematics = $request->input('mathematics');
            $marks->science = $request->input('science');
            $marks->socialscience = $request->input('socialscience');
            $marks->english = $request->input('english');
            $marks->gujarati = $request->input('gujarati');
            $marks->hindi = $request->input('hindi');
            $marks->total = $total;
            $marks->percentage = $percentage;
            $marks->status = $status;
            $marks->save();

            return ['success' => true];
        } else {
            $marks = new Marksheet();
            $marks->user_id = $user_id;
            $marks->bio = $request->input('bio');
            $marks->mathematics = $request->input('mathematics');
            $marks->science = $request->input('science');
            $marks->socialscience = $request->input('socialscience');
            $marks->english = $request->input('english');
            $marks->gujarati = $request->input('gujarati');
            $marks->hindi = $request->input('hindi');
            $marks->total = $total;
            $marks->percentage = $percentage;
            $marks->status = $status;
            $marks->save();

            return ['success' => true];
        }

        return ['error' => true];
    }

    public function downloadMarksheet($id)
    {
        $marksheet = Marksheet::with('user')->find($id);

        if (!$marksheet) {
            abort(404);
        }

        $pdf = PDF::loadView('admin.auth.marksheet.marksheetpdf', compact('marksheet'));
        return $pdf->download('marksheet_' . $marksheet->id . '.pdf');
    }
}
