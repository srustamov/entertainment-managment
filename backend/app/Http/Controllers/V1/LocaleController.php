<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LocaleController extends Controller
{
    public function json() : array
    {
        return [
            'locale'   => app()->getLocale(),
            'messages' => json_decode(File::get(storage_path('app/frontend/lang.json')))
        ];
    }
}
