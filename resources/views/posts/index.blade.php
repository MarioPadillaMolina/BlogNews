@extends('adminbase')

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
    <h3>index posts</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Insert new
                        Post</a>{{-- segundo parámetro el resto de la url
                    --}}
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table table-hover">
                    <tr>
                        {{-- ['id', 'title', 'date', 'time',
                        'author']--}}

                        <th scope="col">
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'asc', 'orderby' => '0']) }}">↓</a>
                            id#

                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'desc', 'orderby' => '0']) }}">↑</a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'asc', 'orderby' => '1']) }}">↓</a>
                            title
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'desc', 'orderby' => '1']) }}">↑</a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'asc', 'orderby' => '2']) }}">↓</a>
                            date
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'desc', 'orderby' => '2']) }}">↑</a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'asc', 'orderby' => '3']) }}">↓</a>
                            time
                            <a
                                href="{{ route('posts.index', ['search' => $search, 'sort' => 'desc', 'orderby' => '3']) }}">↑</a>
                        </th>
                        <th scope="col">
                            author
                        </th>
                    </tr>
                    @foreach ($posts as $post)
                        <tr>
                            <td scope="row">{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->date }}</td>
                            <td>{{ $post->time }}</td>
                            <td>{{ $post->user->name }}</td>{{-- porque en el modelo he
                            declarado la relación --}}
                            <td class="text-center"><a target="_blank" href="{{ route('frontend.show', $post) }}"><i
                                        class="fas fa-eye" aria-hidden="true"></i></a></td>
                            <td class="text-center"><a href="{{ route('posts.edit', $post) }}"><i class="fas fa-edit"
                                        aria-hidden="true"></i></a></td>
                            <td class="text-center"><a href="#" class="launchModal"><i data-id="{{ $post->id }}"
                                        data-content="{{ $post->title }}" data-toggle="modal" data-target="#modalDelete"
                                        class="fas fa-trash" style="color: darkred; cursor: pointer"></i></a></td>
                        </tr>
                    @endforeach
                </table>
                <div class="card-footer">
                    {{ $posts->links() }}
                </div>
            </div>
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
                    <p>Are you sure you want to delete the post:
                        <strong>ID: <span id="objId"></span> - Title: <span id="objContent"></span></strong> ?
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
    <form id="formDelete" action="{{ url('posts') }}" method="post">
        @csrf
        @method('delete')
    </form>
@endsection
