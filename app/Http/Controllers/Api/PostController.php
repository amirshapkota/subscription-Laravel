<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Jobs\SendPostEmail;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    
    public function index()
    {
        $currentPage = request()->get('page', 1);

        return PostResource::collection(

            Cache::remember('posts' . $currentPage, 86400, function () {
                return Post::paginate(5);
            })
        );

    }

    public function show($website_name)
    {
        global $website;
        $website = Website::where('slug', $website_name)->first();

        if (!$website)
        {
           return response()->json([
               "data" => [
                    "success" => false,
                    "message" => "No such website found"
               ]
           ], 404); 
        }
        
        $currentPage = request()->get('page', 1);

        return PostResource::collection(
            
            Cache::remember($website_name . $currentPage, 86400, function () {
                global $website;
                return $website->posts()->paginate(5);
            })
        );

    }

    public function create(StorePostRequest $request, $website_name)
    {
        $website = Website::where('slug', $website_name)->first();

        if ($website == null)
        {
           return response()->json([
               "data" => [
                    "success" => false,
                    "message" => "No such website found"
               ]
           ], 404); 
        }

        $post = Post::create(array_merge($request->only('title', 'description'), ['website_id' => $website->id]));

        dispatch(new SendPostEmail($website->subscriptions, $post));

        return response()->json([
            "data" => [
                "post" => PostResource::make($post),
                "success" => true,
                "message" => "Posted Sucessfully"
        ]]);
    }
}
