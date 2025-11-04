@extends('admin_layout')
@section('content_dash')

<?php use Illuminate\Support\Facades\Session; ?>

<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Thêm Thương Hiệu</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{URL::to('/submit-add-brand')}}" method="POST" enctype="multipart/form-data" data-toggle="validator">
                            @csrf
                            <div class="row"> 
                                <div class="col-md-12">                  
                                    <div class="form-group">
                                        <label>Tên thương hiệu</label>
                                        <input type="text" name="BrandName" class="form-control slug" onkeyup="ChangeToSlug()" placeholder="Nhập tên thương hiệu" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                        <label>Ảnh thương hiệu</label>
                                        <input type="file" name="BrandImage" id="BrandImage" class="form-control" accept="image/*" required>
                                        <img id="previewImage" src="#" alt="Ảnh xem trước" style="display:none; margin-top:10px; max-height:150px; border:1px solid #ddd; border-radius:6px;">
                                        
                                    <!--  Phần chọn danh mục -->
                                    <div class="form-group mt-3">
                                        <label>Chọn danh mục</label><br>
                                        @foreach($list_category as $category)
                                            <label style="margin-right:15px;">
                                                <input type="checkbox" name="categories[]" value="{{ $category->idCategory }}">
                                                {{ $category->CategoryName }}
                                            </label>
                                        @endforeach
                                        <div class="help-block with-errors"></div>
                                        
                                    </div>

                                    <input type="hidden" name="BrandSlug" class="form-control" id="convert_slug">
                                </div>    
                            </div>                             
                            <input type="submit" name="addbrand" class="btn btn-primary mr-2" value="Thêm thương hiệu">
                            <a href="{{URL::to('/manage-brand')}}" class="btn btn-light mr-2">Trở Về</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @if(Session::has('message'))
        Swal.fire({
            title: '{{ Session::get('message') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location = "{{ url('manage-brand') }}";
        });
    @endif
</script>

@endsection
