@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Blogs | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Blogs</h2>
                </div>
                <div>
                    <a href="{{ route('Admin.add-blog') }}" class="btn btn-primary btn-sm rounded">Add New Blog</a>
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-5 col-md-5 me-auto">
                            <form class="searchform" method="POST" action="{{ route('Admin.blogs-by-term') }}">
                                @csrf
                                <div class="input-group">
                                    <input list="search_terms" type="text" name="term" class="form-control"
                                        placeholder="Type here">
                                    <button class="btn btn-light bg" type="submit"> <i
                                            class="material-icons md-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <form class="col-lg-6 col-6 col-md-3 d-flex justify-content-end" action="{{ route('Admin.blogs-by-category') }}" method="POST">
                            @csrf
                                <div class="col-lg-4 col-4 col-md-4 mx-1">
                                    <select class="form-select" name="category" onchange="this.form.submit()">
                                        <option value="All" @selected($category == 'All')>All</option>
                                        @foreach ($blog_categories as $blog_category)
                                            <option value="{{ $blog_category->id }}" @selected($category == $blog_category->id)>{{ $blog_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-2 col-md-4">
                                    <select class="form-select" name="record" onchange="this.form.submit()">
                                        <option value="20" @selected($record_perpage == 20)>20</option>
                                        <option value="30" @selected($record_perpage == 30)>30</option>
                                        <option value="40" @selected($record_perpage == 40)>40</option>
                                    </select>
                                </div>                                
                        </form>
                    </div>
                </header>
                <!-- card-header end// -->
                <div class="card-body">
                    @if (!empty($blogs->toArray()))
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                    <th>Trending</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->id }}</td>
                                        <td><b>{{ count_text($blog->title) }}</b></td>
                                        <td>{{ count_text($blog->short_description) }}</td>                                  
                                        <td>{{ $blog->blog_categories->name }}</td>                                  
                                        <td>{{ $blog->views }}</td>                                  
                                        <td>
                                            <select class="form-select" id="trending_select_{{ $blog->id }}"
                                                onchange="change_trending({{ $blog->id }})">
                                                <option value="1" @if ($blog->trending_priority == '1') selected @endif>1</option>
                                                <option value="2" @if ($blog->trending_priority == '2') selected @endif>2</option>
                                                <option value="0" @if ($blog->trending_priority == '0') selected @endif>0</option>
                                            </select>
                                        </td>             
                                        <td class="text-center">
                                            <a class="btn btn-info" href="{{ route('Admin.edit-blog-form',['id'=>$blog->id]) }}"><i class="fas fa-pen text-white"></i></a>
                                            <button id="loader{{ $blog->id }}" class="btn btn-danger" style="display: none">
                                                <span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span>
                                            </button>
                                            <button class="btn btn-danger" id="delete_btn{{ $blog->id }}" onclick="delete_blog({{ $blog->id }})"><i class="fas fa-trash text-white"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive//end -->
                    @else
                    <div class="d-flex justify-content-center align-items-center">
                        <h3>No blogs Yet.</h3>
                    </div>
                    @endif                    
                </div>
                <!-- card-body end// -->
            </div>
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{ $blogs->render() }}
                    </ul>
                </nav>
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
            function change_trending(id) {
                $.ajax({
                    url: "{{ route('Admin.change-trending') }}",
                    data: {
                        'id': id,
                        'periority': $('#trending_select_' + id + ' option:selected').val()
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
            function delete_blog(id) {
                $.ajax({
                    url: "{{ route('Admin.delete-blog') }}",
                    data: {
                        'id': id
                    },
                    type: 'POST',
                    beforeSend: function(){
                        document.getElementById("delete_btn"+id).style.display="none";
                        document.getElementById("loader"+id).style.display="block";
                    },
                    success: function(data) {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                            location.reload();
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
