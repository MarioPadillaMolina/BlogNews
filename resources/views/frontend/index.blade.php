@extends('frontbase')

@section('content')
    @if (isset($author))
        <h3>Posts Writed by <em>{{ $author->name }}</em></h3>
    @endif
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-sm-6">
                <div class="card">
                <img src="{{ asset($post->image ?? 'banner/default.jpg') }}" class="card-img-top" alt="image">
                    <div class="card-body">
                        <h4 class="card-title"><strong>{{ $post->title }}</strong></h4>
                        <p class="card-text">{{ $post->text }}.</p>
                        <a href="{{ route('frontend.show', $post) }}" class="btn btn-primary">View more</a>
                    </div>
                    <div class="card-footer">Writed by: <a
                            href="{{ route('frontend.author', $post->user_id) }}">{{ $post->user->name }}</a>
                         - Created at: {{ $post->date }}, {{ $post->time }}
                    </div>
                </div>
            </div>
        @endforeach
        {{ $posts->appends(['orderby' => 'id'])->onEachSide(2)->links() }}
    </div>
@endsection
