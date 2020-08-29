<?php

namespace App\Traits;

use App\Like;

/**
 * Likeable Trait
 */
trait Likeable
{
    /**
     * Boot the trait.
     */
    protected static function bootLikeable()
    {
        static::deleting(function ($model) {
            $model->likes->each->delete();
        });
    }

    /**
     * A post can be liked.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    
    /**
     * Like the current post
     */
    public function like($user = null, $like = true)
    {
        $attributes = [
            'user_id' => $user ? $user->id : auth()->id(),
            'likeable_id' => $this->id,
            'likeable_type' => 'App\Post'
        ];

        return $this->likes()->UpdateOrCreate(
            $attributes,
            [
                'user_id' => $attributes['user_id'],
                'like' => $like
            ]
        );
    }

    /**
     * Dislike the current post
     */
    public function dislike($user = null)
    {
        return $this->like($user, false);
    }

    /**
     * Unlike the current post.
     */
    public function unlike($user = null, $like = true)
    {
        $attributes = ['user_id' => $user->id ?? auth()->id()];

        $this->likes
        ->where('user_id', $user ? $user->id : auth()->id())
        ->where('like', $like)
        ->each
        ->delete();
    }

    /**
     * Undislike the current post.
     */
    public function undislike($user = null)
    {
        $this->unlike($user, false);
    }

    /**
     * Determine if the current post has been liked.
     *
     * @return boolean
     */
    public function isLiked()
    {
        return ! ! $this->likes()->where(['user_id' => auth()->id(), 'like' => 1])->count();
    }

    /**
     * Determine if the current post has been disliked.
     *
     * @return boolean
     */
    public function isDisLiked()
    {
        return ! ! $this->likes()->where(['user_id' => auth()->id(), 'like' => 0])->count();
    }

    /**
     * Fetch the liked status as a property.
     *
     * @return bool
     */
    public function getIsLikedAttribute()
    {
        // return $this->isLiked();
        return ! ! $this->likes->where('user_id', auth()->id())->where('like', 1)->count();
    }

    /**
     * Fetch the disliked status as a property.
     *
     * @return bool
     */
    public function getIsDisLikedAttribute()
    {
        // return $this->isDisLiked();
        return ! ! $this->likes->where('user_id', auth()->id())->where('like', 0)->count();
    }

    /**
     * Get the number of likes for the post.
     *
     * @return integer
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->where('like', 1)->count();
    }

    /**
     * Get the number of dislike for the post.
     *
     * @return integer
     */
    public function getDisLikesCountAttribute()
    {
        return $this->likes->where('like', 0)->count();
    }
}
