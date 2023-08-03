@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Blog CMS | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tiny.cloud/1/8oeks8k7g5tttl2iblee9nuom6rbatrupkj5fs1c23k9gn11/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="row">
                <div class="col-12">
                    <div class="content-header">
                        <h2 class="content-title">Blog CMS</h2>
                    </div>
                </div>            
                <div class="col-lg-6">
                    <form action="{{ route('Admin.update-cms-ad') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-4">                            
                            <div class="card-header">
                                <h4>Ads</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category"
                                        onchange="show_sub_category()">
                                        <option value="" readonly hidden> Select Category </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_slug }}" @selected($category->category_slug==$content->category_slug)>{{ $category->category_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Sub-category</label>
                                    <select class="form-select" id="sub_category" name="sub_category">
                                        <option value="" readonly hidden>Select Sub Category</option>
                                    </select>
                                </div>
                                <div class="input-upload mb-4">
                                    <div id="main_img_div">
                                        <img id="main_img" src="{{ asset('/uploads/'.$content->ad) }}" alt="">
                                    </div>
                                    <label for="main_img" class="form-label">Main Image</label>
                                    <input class="form-control" type="file" id="main_media" name="main_media"
                                    onchange="readURL(this);" required/>
                                </div>
                                <div class="mb-4 d-flex justify-content-center">
                                    <input type="hidden" value="{{ $content->id }}" name="id">
                                    <input type="submit" class="btn btn-md rounded font-sm hover-up" value="Update" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Ads Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Wanna Show</label>
                                <select class="form-select" id="show" name="show"
                                    onchange="show_ad({{ $content->id }})" required>
                                    <option value="Show" @selected($content->ad_status=='Show')> Show </option>
                                    <option value="Hide" @selected($content->ad_status=='Hide')> Hide </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                $.ajax({
                    url: "{{ url('/admin/get-sub-categories-by-slug') }}",
                    data: {
                        'id': '{{ $content->category_slug }}'
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            data = data.data;
                            $('#sub_category').empty();
                            if (data.length !== 0) {
                                $('#sub_category').append($('<option>', {
                                    text: 'Select Sub Category',
                                    value: '',
                                    selected: true
                                }));
                                data.forEach(e => {
                                    if (e.sub_category_slug == '{{ $content->sub_category_slug }}') {
                                        $('#sub_category').append($('<option>', {
                                            value: e.sub_category_slug,
                                            text: e.sub_category_title,
                                            selected: true
                                        }));
                                    } else {
                                        $('#sub_category').append($('<option>', {
                                            value: e.sub_category_slug,
                                            text: e.sub_category_title
                                        }));
                                    }
                                });
                            } else {
                                $('#sub_category').append($('<option>', {
                                    text: 'No Sub Category',
                                    value: '',
                                    selected: true
                                }));
                            }
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    }
                });
            });
            function show_sub_category() {                
                $.ajax({
                    url: "{{ url('/admin/get-sub-categories-by-slug') }}",
                    data: {
                        'id': $('#category option:selected').val()
                    },
                    type: 'POST',
                    beforeSend: function() {
                        $('#sub_category').empty();
                        $('#sub_category').append($('<option>', {
                            text: 'Loading...'
                        }));
                    },
                    success: function(data) {
                        if (data.success) {
                            data = data.data;
                            $('#sub_category').empty();
                            if (data.length !== 0) {
                                $('#sub_category').append($('<option>', {
                                    value: '',
                                    text: 'Select Sub Category',
                                }));
                                data.forEach(e => {
                                    if(e.sub_category_slug=='{{ $content->sub_category_slug }}'){
                                        $('#sub_category').append($('<option>', {
                                            value: e.sub_category_slug,
                                            text: e.sub_category_title,
                                            selected:true
                                        }));
                                    }else{
                                        $('#sub_category').append($('<option>', {
                                            value: e.sub_category_slug,
                                            text: e.sub_category_title
                                        }));
                                    }
                                });
                            } else {
                                $('#sub_category').append($('<option>', {
                                    value: '',
                                    text: 'No Sub Category',
                                }));
                            }
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    }
                });
            }
            function show_ad(id) {
                $.ajax({
                    url: "{{ route('Admin.show-ad') }}",
                    data: {
                        'id': id,
                        'status': $('#show option:selected').val()
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    }
                });
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
