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
                        Edit Post
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('posts.update', $post) }}" method="post" id="createPostForm" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" maxlength="200" minlength="2" class="form-control" name="title" id="title"
                                placeholder="Title" value="{{ old('title', $post->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="text">Content</label>
                            <textarea class="form-control" rows="6" minlength="20" placeholder="Insert content here"
                                id="text" name="text" required>{{ old('text', $post->text) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Creation date</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ old('date', $post->date) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Creation time</label>
                            <input type="time" class="form-control" name="time" id="time"
                                value="{{ old('date', $post->time) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Image Header</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
