@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Sent Mails | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Sent Mails List </h2>
                </div>
            </div>
            @if (count($sent_mails)>0)
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-9 col-md-9 me-auto">
                                <form class="searchform" method="POST" action="{{ route('Admin.sent-mails-search') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input list="search_terms" type="text" name="id" class="form-control" placeholder="type">
                                        <button class="btn btn-light bg" type="submit"> <i
                                                class="material-icons md-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-3 col-3 col-md-3 d-flex justify-content-end">
                                <div class="col-lg-3 col-3 col-md-3">
                                    <form method="POST" action="{{ route('Admin.sent-mails-pagination') }}" class="row">
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
                                        <th scope="col">Subject</th>
                                        <th scope="col">Order Number</th>
                                        <th scope="col">Bill</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody id="ruo-result">
                                    @foreach ($sent_mails as $sent_mail)
                                        <tr>
                                            <td>{{ $sent_mail->mail }}</td>
                                            <td>
                                                <b>
                                                    {{ $sent_mail->name }}
                                                </b>
                                            </td>
                                            <td>{{ $sent_mail->subject }}</td>
                                            <td>{{ $sent_mail->order_number }}</td>
                                            <td>${{ $sent_mail->bill }}</td>
                                            <td>{!! date('d-M-y h:m:s', strtotime($sent_mail->created_at)) !!}</td>
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
                            {{ $sent_mails->render() }}
                        </ul>
                    </nav>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center">
                    <h3>No Mails Yet.</h3>
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
