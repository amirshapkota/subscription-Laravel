<?php

namespace App\Http\Controllers\Api;

use App\Events\SubscribedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Website;

class SubscriptionController extends Controller
{
    
    public function store(StoreUserRequest $request, $website_name)
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
    
        $user = User::create($request->only('name', 'email'));
        $website->subscribe($user);

        event(new SubscribedEvent($user, $website));

        return response()->json([
            "data" => [
                "message" => "Subscribed Sucessfully",
                "success" => true,
                "user" => UserResource::make($user)
            ]
        ]);

    }
}
