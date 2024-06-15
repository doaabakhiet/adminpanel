<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Setting;
use App\Models\User;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }
    public function homeData(){
        $settings=Setting::pluck('value', 'key');
        $icons=Icon::all();
        return view('adminPanel.homePage.index',compact('settings','icons'));
    }
    // public function checkPassword()
    // {
    //     $user = User::find(request()->user()->id);
    //     if (Hash::check(request()->value, $user->password)) {
    //         return ['success' => true];
    //     }
    //     return ['success' => false];
    // }
}
