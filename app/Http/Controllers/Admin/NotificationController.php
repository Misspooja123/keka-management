<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{

    // public function index()
    // {
    //     return view('admin.auth.notification.view_notification');
    // }

    public function update($id)
    {
        // dd($id);
        $data = User::find($id);
        // dd($data);
        if ($data) {
            $data->is_read = '1';
            $data->save();

        }

    }
}
