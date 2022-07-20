<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function countAll()
    {
        //https://stackoverflow.com/questions/20110757/laravel-pass-more-than-one-variable-to-view
        $userCount = User::query()->count();
        $users = User::query()->take(10)->orderBy('created_at', 'desc')->get();
        $ads = Ad::query()->take(10)->orderBy('created_at', 'desc')->get();
        $adcount = Ad::query()->count();
//        dd($users, $ads);
        return Inertia::render('Dashboard',  compact('userCount', 'adcount', 'ads', 'users'));
    }
}
