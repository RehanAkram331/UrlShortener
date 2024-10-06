<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Http\Requests\StoreShortUrlRequest;
use App\Http\Requests\UpdateShortUrlRequest;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ShortUrl::where('user_id',auth()->user()->id)->get();
        return response()->json(["success"=>true,"data"=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortUrlRequest $request)
    {
        try{
            $originalUrl=$request->url;
            // Check if the URL is already shortened
            $existing = ShortUrl::where('original_url', $originalUrl)->first();
            if ($existing) {
                return response()->json(["success"=>true,"data"=>$existing,"message"=>"Shorturl Already Created"],200);
            }

            // Generate a unique short URL
            $shortUrl = substr(md5(uniqid()), 0, 10);
            $data= ShortUrl::create([
                'original_url' => $originalUrl,
                'short_url' => $shortUrl,
                'user_id' => auth()->user()->id
            ]);
            return response()->json(["success"=>true, "data"=>$data,"message"=>"Successfully Created Shorturl"],201);
        }catch(\Exception $e){
            dd($e);
            return response()->json(["success"=>false,"message"=>"Failed to shorten url"]);
        }
        
    }

    /**
     * redirect To Original
     */
    public function redirectToOriginal($shortUrl)
    {
        $url = ShortUrl::where('short_url', $shortUrl)->firstOrFail();
        if($url){
            $url->Number_of_clicks=$url->Number_of_clicks+1;
            $url->save(); 
            // Redirect to the original URL
            return redirect()->away($url->original_url);
        }else{
            return view('errors.404');  
        }
    }
}
