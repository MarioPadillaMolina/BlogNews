@extends('adminbase')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                    <a href="#" class="btn btn-primary">Show Posts</a>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Insert new Post
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('posts.store') }}" method="post" id="createPostForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" required maxlength="200" minlength="2" class="form-control" name="title"
                                id="title" placeholder="Title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="text">Content</label>
                            <textarea class="form-control" rows="6" minlength="20" placeholder="Insert content here"
                                id="text" name="text" required>{{ old('text') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Creation date</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ old('date') }}">
                        </div>
                        <div class="form-group">
                            <label for="time">Creation time</label>
                            <input type="time" class="form-control" name="time" id="time"
                                value="{{ old('time') }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Image Header</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
