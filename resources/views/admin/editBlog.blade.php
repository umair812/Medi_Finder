@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Edit Blog | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel='stylesheet' href='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'>
        <script src="https://cdn.tiny.cloud/1/6mwwhw1qnclmda4v5y7vmobvi2ieeyszxm98vjsqbacuc198/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
        <style type="text/css">
            .bootstrap-tagsinput .tag {
                margin-right: 2px;
                color: white !important;
                background-color: #088178;
                padding: .2em .6em .3em;
                font-size: 100%;
                vertical-align: baseline;
                border-radius: .25em;
            }
        </style>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <form action="{{ route('Admin.update-blog') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title">Edit Blog</h2>
                            <div>
                                <input type="hidden" name="id" value="{{ $blog->id }}" />
                                <input type="submit" class="btn btn-md rounded font-sm hover-up" value="Update" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Basic</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Blog title</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ $blog->title }}" id="name" name="name" required>
                                    <small class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Blog Categories</label>
                                    <select class="form-select" id="category" name="category" required>
                                        @foreach ($blog_categories as $blog_category)
                                            <option value="{{ $blog_category->id }}" @selected($blog_category->id == $blog->blog_categories_id)>
                                                {{ $blog_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Blog Priority</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="0" @selected($blog->trending_priority == '0')>0</option>
                                        <option value="1" @selected($blog->trending_priority == '1')>1</option>
                                        <option value="2" @selected($blog->trending_priority == '2')>2</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">Short description</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ $blog->short_description }}" id="content" name="content">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Full description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="description" name="description">{!! $blog->description !!}</textarea>
                                </div>
                            </div>
                        </div> <!-- card end// -->
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Media</h4>
                            </div>
                            <div class="card-body">
                                <div class="input-upload">
                                    <div id="main_img_div">
                                        <img id="main_img" src="{{ asset('uploads/' . $blog->media) }}" alt="">
                                    </div>
                                    <label for="main_img" class="form-label">Main Image</label>
                                    <input class="form-control" type="file" id="main_media" name="main_media"
                                        onchange="readURL(this);" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                    </div>
                </div>
            </form>
        </section>
    @endsection
    @push('footer')
        <script src='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#main_img')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script>
            $(function() {
                $('#tags').on('change', function(event) {

                    var $element = $(event.target);
                    var $container = $element.closest('.example');

                    if (!$element.data('tagsinput'))
                        return;

                    var val = $element.val();
                    if (val === null)
                        val = "null";
                    var items = $element.tagsinput('items');

                    $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val
                        .replace('"', '\\"') + "\""));
                    $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));


                }).trigger('change');
            });
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
