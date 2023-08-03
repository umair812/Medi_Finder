@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Contact Us Messages | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Contact Us Messages</h2>
                </div>
            </div>
            @if (count($messages)>0)
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-9 col-md-9 me-auto">
                            </div>
                            <div class="col-lg-3 col-3 col-md-3 d-flex justify-content-end">
                                <div class="col-lg-3 col-3 col-md-3">
                                    <form method="POST" action="{{ route('Admin.contact-us-page') }}" class="row">
                                        @csrf
                                        <select class="form-select" name="record" onchange="this.form.submit()">
                                            <option value="20" @selected($record_perpage=="20")>20</option>
                                            <option value="30" @selected($record_perpage=="30")>30</option>
                                            <option value="40" @selected($record_perpage=="40")>40</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </header> <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone No.</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody id="ruo-result">
                                    @foreach ($messages as $message)
                                        <tr>
                                            <td>{{ $message->email }}</td>
                                            <td>
                                                <b>
                                                    {{ $message->name }}
                                                </b>
                                            </td>
                                            <td>{{ $message->phone }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{!! date('d-M-y h:m', strtotime($message->created_at)) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive //end -->
                    </div> <!-- card-body end// -->
                </div> <!-- card end// -->
                <div class="pagination-area mt-30 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{ $messages->render() }}
                        </ul>
                    </nav>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center">
                    <h3>No Message Yet.</h3>
                </div>
            @endif
        </section> <!-- content-main end// -->
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
