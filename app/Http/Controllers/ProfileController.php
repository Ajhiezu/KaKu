<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(){
        return view("pages.profile");
    }

    public function contact(){
        return view("pages.contact");
    }

    public function faq(){
        return view("pages.faq");
    }
}
