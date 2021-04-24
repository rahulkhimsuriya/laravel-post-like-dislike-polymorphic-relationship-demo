<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeDislikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_like_and_dislike_anything()
    {
        $post = factory('App\Post')->create();

        $this->post('/posts/' . $post->id . '/like')->assertRedirect('/login');
        $this->post('/posts/' . $post->id . '/dislike')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_like_post()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory('App\Post')->create();

        $this->actingAs($user)->post('/posts/' . $post->id . '/like');

        $this->assertEquals(1, $post->fresh()->likesCount);
    }

    /** @test */
    public function user_can_unlike_the_liked_post()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory('App\Post')->create();

        $this->actingAs($user)->post('/posts/' . $post->id . '/like');
        $this->assertEquals(1, $post->likesCount);

        $this->actingAs($user)->post('/posts/' . $post->id . '/like');
        $this->assertEquals(0, $post->fresh()->likesCount);
    }

    /** @test */
    public function user_can_dislike_post()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory('App\Post')->create();

        $this->actingAs($user)->post('/posts/' . $post->id . '/dislike');

        $this->assertEquals(1, $post->dislikesCount);
    }

    /** @test */
    public function user_can_undislike_the_disliked_post()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory('App\Post')->create();

        $this->actingAs($user)->post('/posts/' . $post->id . '/dislike');
        $this->assertEquals(1, $post->dislikesCount);

        $this->actingAs($user)->post('/posts/' . $post->id . '/dislike');
        $this->assertEquals(0, $post->fresh()->dislikesCount);
    }

    /** @test */
    public function user_can_not_like_or_dislike_a_post_twice()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory('App\Post')->create();

        $this->assertCount(0, $post->likes);

        $this->actingAs($user)->post('/posts/' . $post->id . '/like');
        $this->assertCount(1, $post->fresh()->likes);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => 'App\Post',
            'like' => 1
        ]);

        $this->actingAs($user)->post('/posts/' . $post->id . '/dislike');
        $this->assertCount(1, $post->fresh()->likes);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => 'App\Post',
            'like' => 0
        ]);
    }
}
