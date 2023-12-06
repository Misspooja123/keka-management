<?php

namespace App\Interfaces;
use App\Models\Marksheet;
use Illuminate\Http\Request;

interface MarksheetInterface
{
    public function getAll();

    public function updateMarks(Request $request);
    public function downloadMarksheet($id);
}


