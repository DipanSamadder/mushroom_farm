<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SupportController extends Controller
{
    public function room_productions()
    {
        $page['title'] = 'Support';
        return view('backend.modules.supports.room_productions', compact('page'));
    }
}

