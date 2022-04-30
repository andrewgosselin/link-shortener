<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ShortCode;

class LinkController extends Controller
{
    public function welcome()
    {
        return view('pages.short-code.store');
    }

    public function createShortCode(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        $shortCode = ShortCode::create([
            'url' => $request->url,
            'unsuspicious' => ($request["unsuspicious"] ?? false) == "true" ? true : false,
        ]);

        return [
            "url" => url("/{$shortCode->code}")
        ];
    }

    public function resolveCode($code) {
        $shortCode = ShortCode::where('code', $code)->first();
        if ($shortCode) {
            return redirect($shortCode->url);
        }
        abort(404);
    }
}
