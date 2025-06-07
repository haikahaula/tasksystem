<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SystemUpdate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    //Notifications
    public function notifySystemUpdate(Request $request)
    {
        $message = $request->input('message'); // system update message
        $users = User::all(); // or filter by role

        foreach ($users as $user) {
            $user->notify(new SystemUpdate($message));
        }

        return back()->with('success', 'System update notification sent.');
    }
}
