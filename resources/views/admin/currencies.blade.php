@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Currencies | Baggage Factory</title>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Currencies </h2>
                    <p>Add, Edit or Delete a Currency</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <form action="{{ url('/admin/add-currency') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="product_name" class="form-label">Name</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="name" name="name" required/>
                                    <small class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="symbol" class="form-label">Symbol</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="symbol" name="symbol" required/>
                                    <small class="text-danger">
                                        @error('symbol')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="exchange_rate" class="form-label">Exchange Rate</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="exchange_rate" name="exchange_rate" required/>
                                    <small class="text-danger">
                                        @error('exchange_rate')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="code" name="code" required/>
                                    <small class="text-danger">
                                        @error('code')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <small class="text-danger">
                                        @error('show')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Create currency</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Symbol</th>
                                            <th>Exchange Rate (£ 1=?)</th>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencies as $currency)
                                            <tr id="row{{ $currency->id }}">
                                                <td id="name_row{{ $currency->id }}">{{ $currency->name }}</td>
                                                <td id="symbol_row{{ $currency->id }}">{{ $currency->symbol }}</td>
                                                <td id="exchange_rate_row{{ $currency->id }}">{{ $currency->exchange_rate }}</td>
                                                <td id="code_row{{ $currency->id }}">{{ $currency->code }}</td>
                                                <td class="mb-1">
                                                    <div class="mb-1">
                                                        <select class="form-select" id="show_select_{{ $currency->id }}"
                                                            onchange="show_currency('{{ $currency->id }}')">
                                                            <option value="Active"
                                                                @if ($currency->status == 'Active') Selected @endif>Active
                                                            </option>
                                                            <option value="Inactive"
                                                                @if ($currency->status == 'Inactive') Selected @endif>Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center align-items-center">
                                                    <button id="edit_button{{ $currency->id }}" class="btn btn-info m-2" onclick="edit_row({{ $currency->id }})"><i class="fas fa-pen text-white"></i></button>
                                                    <button id="save_button{{ $currency->id }}" class="btn btn-success m-2" onclick="save_row({{ $currency->id }})" style="display: none"><i class="fas fa-check text-white"></i></button>
                                                    <button id="loader{{ $currency->id }}" class="btn btn-success m-2" style="display: none">
                                                        <span class="spinner-border spinner-border-sm text-white m-2" role="status" aria-hidden="true"></span>
                                                    </button>
                                                    <button class="btn btn-danger" onclick="delete_currency({{ $currency->id }})"><i class="fas fa-trash text-white"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col// -->
                    </div> <!-- .row // -->
                </div> <!-- card body .// -->
            </div> <!-- card .// -->
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{ $currencies->render() }}
                    </ul>
                </nav>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            function show_currency(id) {
                $.ajax({
                    url: "{{ url('/admin/show-currency') }}",
                    data: {
                        'id': id,
                        'status': $('#show_select_' + id + ' option:selected').val(),
                        '_token':'{{ csrf_token() }}'
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
            function delete_currency(id) {
                $.ajax({
                    url: "{{ url('/admin/delete-currency') }}",
                    data: {
                        'id': id,
                        '_token':'{{ csrf_token() }}'
                    },
                    type: 'POST',
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
            function edit_row(no) {
                document.getElementById("edit_button"+no).style.display="none";
                document.getElementById("save_button"+no).style.display="block";

                var name=document.getElementById("name_row"+no);
                var symbol=document.getElementById("symbol_row"+no);
                var exchange_rate=document.getElementById("exchange_rate_row"+no);
                var code=document.getElementById("code_row"+no);

                var name_data=name.innerHTML;
                var symbol_data=symbol.innerHTML;
                var exchange_rate_data=exchange_rate.innerHTML;
                var code_data=code.innerHTML;

                name.innerHTML="<input type='text' class='mb-2' id='name_text"+no+"' value='"+name_data+"'>";
                symbol.innerHTML="<input type='text' class='mb-2' id='symbol_text"+no+"' value='"+symbol_data+"'>";
                exchange_rate.innerHTML="<input type='text' class='mb-2' id='exchange_rate_text"+no+"' value='"+exchange_rate_data+"'>";
                code.innerHTML="<input type='text' class='mb-2' id='code_text"+no+"' value='"+code_data+"'>";
            }
            function save_row(no) {
                var name_val=document.getElementById("name_text"+no).value;
                var symbol_val=document.getElementById("symbol_text"+no).value;
                var exchange_rate_val=document.getElementById("exchange_rate_text"+no).value;
                var code_val=document.getElementById("code_text"+no).value;
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/edit-currency') }}",
                    data: {
                        'id':no,
                        'name':name_val,
                        'symbol':symbol_val,
                        'exchange_rate':exchange_rate_val,
                        'code':code_val,
                        '_token':'{{ csrf_token() }}'
                    },
                    beforeSend: function(){
                        document.getElementById("save_button"+no).style.display="none";
                        document.getElementById("loader"+no).style.display="block";
                    },
                    success: function (response) {
                        if(response.success==true){
                            iziToast.success({
                                position: 'topRight',
                                message: response.message,
                            });
                            document.getElementById("name_row"+no).innerHTML=name_val;
                            document.getElementById("symbol_row"+no).innerHTML=symbol_val;
                            document.getElementById("exchange_rate_row"+no).innerHTML=exchange_rate_val;
                            document.getElementById("code_row"+no).innerHTML=code_val;

                            document.getElementById("edit_button"+no).style.display="block";
                            document.getElementById("save_button"+no).style.display="none";
                            document.getElementById("loader"+no).style.display="none";
                        }else{
                            iziToast.error({
                                position: 'topRight',
                                message: response.message,
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
