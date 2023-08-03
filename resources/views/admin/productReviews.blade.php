@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Products Reviews | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Reviews</h2>
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-5 col-md-5 me-auto">
                            <form class="searchform" method="POST" action="{{ route('Admin.reviews-by-id') }}">
                                @csrf
                                <div class="input-group">
                                    <input list="search_terms" type="text" name="id" class="form-control"
                                        placeholder="Search by ID">
                                    <button class="btn btn-light bg" type="submit"> <i
                                            class="material-icons md-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <form class="col-lg-6 col-6 col-md-3 d-flex justify-content-end" action="{{ route('Admin.reviews-by-status') }}" method="POST">
                            @csrf
                               
                                <div class="col-lg-4 col-4 col-md-4 mx-1">
                                    <select class="form-select" name="status" onchange="this.form.submit()">
                                        <option value="All" @selected($status == 'All')>All</option>
                                        <option value="Approved" @selected($status == 'Approved')>Approved</option>
                                        <option value="Disapproved" @selected($status == 'Disapproved')>Disapproved</option>
                                        <option value="Pending" @selected($status == 'Pending')>Pending</option>
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
                    @if (!empty($reviews->toArray()))
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>comment</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td><b>{{ count_text($review->products->title) }}</b></td>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->comment }}</td>
                                        <td>
                                            <ul class="rating-stars">
                                                <li style="width: {{ ($review->rating / 5) * 100 }}%;" class="stars-active">
                                                    <img src="{{ asset('assets/admin/imgs/icons/stars-active.svg') }}"
                                                        alt="stars" />
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/admin/imgs/icons/starts-disable.svg') }}"
                                                        alt="stars" />
                                                </li>
                                            </ul>
                                        </td>
                                        <td>{{ formatted_date($review->created_at, 'd.m.y') }}</td>
                                        <td class="text-center">
                                            <select class="form-select" id="status_select_{{ $review->id }}"
                                                onchange="change_status({{ $review->id }})">
                                                <option value="Approved" @if ($review->status == 'Approved') selected @endif>
                                                    Approved
                                                </option>
                                                <option value="Disapproved"
                                                    @if ($review->status == 'Disapproved') selected @endif>Disapproved
                                                </option>
                                                <option value="Pending" @if ($review->status == 'Pending') selected @endif>
                                                    Pending
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive//end -->
                    @else
                    <div class="d-flex justify-content-center align-items-center">
                        <h3>No Reviews Yet.</h3>
                    </div>
                    @endif                    
                </div>
                <!-- card-body end// -->
            </div>
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{ $reviews->render() }}
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

            function change_status(id) {
                $.ajax({
                    url: "{{ route('Admin.change-review-status') }}",
                    data: {
                        'id': id,
                        'status': $('#status_select_' + id + ' option:selected').val()
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
