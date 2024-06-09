<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserConfigController extends Controller
{
    /**
     * Set User locale
     */
    public function locale(Request $request)
    {
        
        //$request->session()->put('locale', $request->get('locale'));
        cookie(name: 'Accept-Language', value: $request->get('locale'));
        return response()->json(['locale' => $request->get('locale')]);
    }
}
