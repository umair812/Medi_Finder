@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Marketing Template | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tiny.cloud/1/8oeks8k7g5tttl2iblee9nuom6rbatrupkj5fs1c23k9gn11/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <form action="{{ route('Admin.marketing-set') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title">Marketing Template</h2>
                            <div>
                                <a class="btn btn-md rounded font-sm hover-up" onclick="show_modal()"> View Template</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Basic</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label">Template</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="extra_content" name="extra_content">{{ $template->extra_content }}</textarea>
                                </div>
                                <div class="mb-4 d-flex justify-content-center">
                                    <input type="submit" class="btn btn-md rounded font-sm hover-up" value="Set Template" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                    </div>
                </div>
            </form>
        </section>
        <section>
            <div class="modal fade custom-modal" id="Modal" tabindex="-1"
                aria-labelledby="quickViewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="modal-body bg-transparent">
                            <div id="content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            });
        </script>
        <script>
            function show_modal(){
                var ed = tinyMCE.get('extra_content');
                console.log(ed.getContent());
                $('#content').html(ed.getContent());
                $('#Modal').modal('show');
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
