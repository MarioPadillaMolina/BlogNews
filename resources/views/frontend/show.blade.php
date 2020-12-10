@extends('frontbase')

@section('content')

    <div class="card">
        <div class="card-body">
            <img src="{{ asset($post->image ?? 'banner/default.jpg') }}" class="card-img-top" alt="image">
        </div>
    </div>
    <h1>Title: {{ $post->title }}</h1>

    <p>{{ $post->text }}</p>

    <br><br><br><br><br><br><br><br><br><br>
    <hr>
    
    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Leave a reply
                </div>
                <div class="card-body">
                    <form action="{{ route('frontend.store') }}" method="post">
                        @csrf
                        {{-- el id del post --}}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group">
                            <label for="title">Email</label>
                            <input type="email" name="email" id="email" @auth value="{{ Auth::user()->email }}" readonly
                                @endauth>
                        </div>
                        <div class="form-group">
                            <label for="text">Content</label>
                            <textarea class="form-control" rows="6" minlength="20" placeholder="Insert content comment here"
                                id="text" name="text" required></textarea>
                        </div>
                        
                        {{-- captcha --}}
                        @if ($errors->has('g-recaptcha-response'))
                            {{ $errors->first('g-recaptcha-response') }}
                        @endif
                        {!! NoCaptcha::display() !!}


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            @foreach ($comments as $comment)
                <div class="card">
                    <div class="card-header">
                        <strong>Writed by:</strong> {{ $comment->email }}
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>{{ $comment->text }}</p>
                        </blockquote>
                    </div>
                    @auth
                    <div class="card-footer">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modalDelete{{ $comment->id }}">Delete</td>
                    </div>
                    @endauth
                    <!-- modal alert -->
                    <div class="modal fade" id="modalDelete{{ $comment->id }}" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Alert!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>are you sure you want to delete the comment:
                                        <strong>{{ substr($comment->text, 1, 50) }}</strong> ?
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <form id="formDelete" action="{{ route('comments.destroy', $comment) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /modal alert -->
                </div>
            @endforeach

        </div>
    </div>


@endsection
