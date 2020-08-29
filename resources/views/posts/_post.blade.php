<div class="{{ !$loop->first ? 'mt-4' : '' }} card">
    <div class="card-header">{{ $post->title }}</div>

    <div class="card-body">
       {{ $post->body }}
    </div>

    <div class="card-footer d-flex">
        <form action="{{ route('post.like', $post) }}" method="POST">
            @csrf
            <button class="btn btn-sm {{ $post->isLiked ? 'btn-primary': 'btn-light' }} mr-2">
                LIKE {{ $post->likesCount }}
            </button>
        </form>

        <form action="{{ route('post.dislike', $post) }}" method="POST">
            @csrf
            <button  href="" class="btn btn-sm {{ $post->isDisLiked ? 'btn-danger': 'btn-light' }}">
                DISLIKE {{ $post->dislikesCount }}
            </button>        
        </form>
    </div>
</div>
