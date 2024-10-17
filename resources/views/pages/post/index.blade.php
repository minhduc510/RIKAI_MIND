@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách bài viết</h2>


        <form action="{{ route('posts.index') }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Tìm kiếm bài viết..." id="search" name="keyword"
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="status" name="sort">
                        <option value="1" {{ request('sort') == '1' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="0" {{ request('sort') == '0' ? 'selected' : '' }}>Cũ nhất</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="mb-2 d-flex justify-content-end">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Tạo bài viết</a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Danh sách bài viết -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="post_list">
                @if (isset($posts) && count($posts) > 0)
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->published_at }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm class-delete"
                                        onclick="return confirm('Are you sure you want to delete this post?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">Không có bài viết nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if (isset($posts) && count($posts) > 0)
            <div class="d-flex justify-content-center">
                {{ $posts->appends(request()->all())->links() }}
            </div>
        @endif
    </div>
@endsection
