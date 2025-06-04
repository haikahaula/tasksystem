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
        public function sendSystemUpdate(Request $request)
    {
        $users = User::whereIn('role', ['academic_head', 'academic_staff'])->get();
        Notification::send($users, new SystemUpdate($request->input('details')));

        return back()->with('success', 'System update notification sent.');
    }
}
