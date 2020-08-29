<?php

namespace App;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Likeable;

    protected $guarded = [];

    protected $appends = ['isLiked', 'isDisLiked', 'likesCount', 'dislikesCount'];

    protected $with = ['likes'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
