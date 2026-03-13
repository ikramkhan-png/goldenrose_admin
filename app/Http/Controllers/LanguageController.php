<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Validate the locale is supported
        $supported = ['en', 'ar'];
        if (!in_array($locale, $supported)) {
            abort(400, 'Unsupported locale');
        }

        // Store in session
        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()->back();
    }
}
