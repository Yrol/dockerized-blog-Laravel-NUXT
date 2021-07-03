<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class ImageUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'file']
        ]);
        $file = $request->file('file');
        $file_path = $file->getPathName();

        $client = new Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/image', [
        'headers' => [
                'authorization' => 'Client-ID ' . config('keyvalues.imgur'),
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        'form_params' => [
                'image' => base64_encode(file_get_contents($request->file('file')->path($file_path)))
            ],
        ]);
        $response = json_decode($response->getBody()->getContents());
        if ($response->status == 200) {
            return response()->json(['data' => $response], Response::HTTP_OK);
        }
        abort($response->status, $response->statusText);
    }
}
