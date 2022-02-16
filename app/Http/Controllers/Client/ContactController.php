<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $generalSetting = GeneralSetting::first();
        return view('client.contact.index', compact('generalSetting'));
    }
}