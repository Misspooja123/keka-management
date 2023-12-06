<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;


class EmailController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
        dispatch(new SendEmailJob($request));
    }
}
