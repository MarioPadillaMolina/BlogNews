@extends('adminbase')

@section('postscript')
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
                "Item <strong>#{{ session()->get('id') }} {{ session()->get('name') }} </strong>has been successfully {{ session()->get('op') }}",
                "Success")
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
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Show Posts</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table table-hover">
                    <tr>
                        <th scope="col">id#</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Email</th>
                        <th scope="col">Post</th>
                    </tr>
                    @foreach ($comments as $comment)
                        <tr>
                            <td scope="row">{{ $comment->id }}</td>
                            <td>{{ $comment->text }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ $comment->post->title }}</td>{{-- porque en el modelo he
                            declarado la relación --}}
                            <td class="text-center"><i data-toggle="modal" data-target="#modalDelete{{ $comment->id }}"
                                    class="fas fa-trash" style="color: darkred; cursor: pointer"></i></td>
                        </tr>
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
                                        <p>are you sure you want to delete the post:
                                            <strong>{{ $comment->text }}</strong> ?
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
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
