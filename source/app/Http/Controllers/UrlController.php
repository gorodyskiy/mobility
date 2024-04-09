<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class UrlController extends Controller
{
    /**
     * @var int. Length of short url.
     */
    private $length = 6;

    /**
     * @var string. Allowed chars for short url.
     */
    private $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Redirects from short url or return error.
     * @param string $short code for short url.
     * @return Redirect|Response.
     */
    public function redirect(string $short) {

        if(!preg_match("/^[A-z]+$/", $short)) {
            return response([
                'success' => false,
                'message' => 'Incorrect short link provided',
            ], 400)->header('Content-Type', 'application/json');
        }

        $url = Url::where('short', $short)->pluck('url')->first();

        if (empty($url)) {
            return response([
                'success' => false,
                'message' => 'Short link not found',
            ], 404)->header('Content-Type', 'application/json');
        }

        return redirect()->away($url);
    }

    /**
     * Creates short link record in DB.
     * @param Request $request.
     * @return Response.
     */
    public function shortener(Request $request): Response {
        $validator = Validator::make(
            $request->all(),
            ['url' => 'required|url']
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Incorrect url provided',
            ], 400)->header('Content-Type', 'application/json');
        }

        $short = $this->generate();
        $obj = new Url;
        $obj->url = $request->url;
        $obj->short = $short;
        $obj->save();

        return response([
            'success' => true,
            'message' => 'http://'.request()->getHttpHost().'/'.$short
        ], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Generates random string [A-z]. Try again if already exists.
     * @return string.
     */
    private function generate(): string {
        $random = '';
        for ($i = 0; $i < $this->length; $i++)
            $random .= $this->chars[rand(0, strlen($this->chars) - 1)];
        if (Url::where('short', $random)->exists())
            $this->generate();
        return $random;
    }
}
