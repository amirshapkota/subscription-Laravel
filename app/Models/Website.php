<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'website_id');
    }

    public function subscribe(User $user)
    {
        $data = [
            'user_id' => $user->id,
            'website_id' => $this->id
        ];

        Subscription::create($data);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'website_id');
    }

}
