@extends('frontbase')

@section('postscript')
    {{-- script borrado --}}
    <script src="{{ url('assets/backend/js/script.js?=' . uniqid()) }}"></script>
    <!-- Toastr -->
    <script src="{{ url('assets/backend/plugins/toastr/toastr.min.js') }}"></script>

    @if (session()->get('r') == '1')
        <script type="text/javascript">
            Command: toastr["success"](
                "Item <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
                "Success")

        </script>
    @endif

    @if (session()->get('r') == '0')
        <script type="text/javascript">
            Command: toastr["error"](
                "Item <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>hasn't been successfully {{ session()->get('op') }}",
                "Error")

        </script>
    @endif
@endsection

@section('poststyle')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/toastr/toastr.min.css') }}">
@endsection

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

    @if ($errors->any())
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
                            <button class="btn btn-danger launchModal" data-toggle="modal" data-id="{{ $comment->id }}"
                            data-content="{{ $comment->text }}" data-toggle="modal" data-target="#modalDelete">Delete</td>
                        </div>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>

    <!-- modal alert -->
    <div class="modal fade" id="modalDelete" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the comment:
                        <strong>ID: <span id="objId"></span> - Comment: <span id="objContent"></span></strong> ?
                    </p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="modalConfirmation" class="btn btn-primary">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /modal alert -->
    <form id="formDelete" action="{{ url('comments') }}" method="post">
        @csrf
        @method('delete')
    </form>
@endsection
