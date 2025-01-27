@extends('frontend.partner.layout.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tin tức</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm tin tức mới</h4>
                        <div class="card-header-action">
                            <a href="{{ route('partner.news.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('partner.news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ session('user')->id }}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tiêu đề</label>
                                            <input type="text" class="form-control" name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tag</label>
                                            <input type="text" class="form-control" required name="tag_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ảnh đại diện</label>
                                            <input type="file" class="form-control" name="image" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại tin tức</label>
                                            <select class="form-control" name="cate_id" required>
                                                <option value="">Chọn loại tin tức</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea id="summernote" class="form-control summernote" name="content">{{ old('content') }}</textarea>
                                </div>

                            <button type="submit" class="btn btn-primary">Tạo mới</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
