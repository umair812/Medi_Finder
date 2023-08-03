@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Account Setting | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        <section class="content-main">
            <div class="content-header">
                <h2 class="content-title">Account setting </h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row gx-5">
                        <div class="col-lg-12">
                            <section class="content-body p-xl-4">
                                <form action="{{ route('Admin.update-profile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row gx-3">
                                                <div class="col-6  mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input class="form-control" type="text" placeholder="Type here"
                                                        value="{{ $admin->username }}" readonly>
                                                </div> <!-- col .// -->
                                                <div class="col-6  mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" placeholder="Type here"
                                                        value="{{ $admin->email }}" readonly>
                                                </div> <!-- col .// -->
                                                <div class="col-lg-6  mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input class="form-control" type="text" name="name"
                                                        placeholder="Type here" value="{{ $admin->name }}">
                                                </div> <!-- col .// -->
                                                <div class="col-lg-6  mb-3">
                                                    <label class="form-label">Role</label>
                                                    <input class="form-control" type="text" placeholder="Role"
                                                        value="{{ $admin->role }}" readonly>
                                                </div> <!-- col .// -->
                                            </div> <!-- row.// -->
                                        </div> <!-- col.// -->
                                        <aside class="col-lg-4">
                                            <figure class="text-lg-center">
                                                <img id="media_img" class="img-lg mb-3 img-avatar"
                                                    src="{{ asset('uploads/'.$admin->media) }}"
                                                    alt="User Photo" onerror="this.src='{{ asset('assets/admin/imgs/people/avatar2.jpg') }}'">
                                                <figcaption>
                                                    <a class="" href="javascript:;">
                                                        <input type="file" name="media" id="media" class="btn btn-light rounded font-md"
                                                            name="media" onchange="readURL(this);" />
                                                    </a>
                                                </figcaption>
                                            </figure>
                                        </aside> <!-- col.// -->
                                    </div> <!-- row.// -->
                                    <br>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                                <hr class="my-5">
                                <div class="row" style="max-width:920px">
                                    <div class="col-md">
                                        <article class="box mb-3 bg-light">
                                            <form action="{{ route('Admin.change-password') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row gx-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">New Password</label>
                                                                <input class="form-control" type="password"
                                                                    placeholder="Type here" name="password" required>
                                                            </div> <!-- col .// -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Retype Password</label>
                                                                <input class="form-control" type="password"
                                                                    placeholder="Type here" name="password_confirmation" required>
                                                            </div> <!-- col .// -->
                                                        </div> <!-- row.// -->
                                                    </div> <!-- col.// -->
                                                </div> <!-- row.// -->
                                                <br>
                                                <button class="btn btn-primary" type="submit">Change Password</button>
                                            </form>
                                        </article>
                                    </div> <!-- col.// -->
                                </div> <!-- row.// -->
                            </section> <!-- content-body .// -->
                        </div> <!-- col.// -->
                    </div> <!-- row.// -->
                </div> <!-- card body end// -->
            </div> <!-- card end// -->
        </section>
    @endsection
    @push('footer')
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#media_img')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
