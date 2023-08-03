<footer class="main-footer font-xs">
    <div class="row pb-30 pt-15">
        <div class="col-sm-6">
            <script>
            document.write(new Date().getFullYear())
            </script> ©, Baggage Factory - All rights reserved .
        </div>
    </div>
</footer>
</main>
<script src="{{ asset('assets/admin/js/vendors/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/vendors/select2.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/vendors/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('assets/admin/js/vendors/jquery.fullscreen.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/vendors/chart.js')}}"></script>
<!-- Main Script -->
<script src="{{ asset('assets/admin/js/main.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/js/custom-chart.js')}}" type="text/javascript"></script>
<!-- IZI Toast -->
<script src="{{ asset('js/iziToast.js') }}"></script>
@include('vendor.lara-izitoast.toast')
</body>
@stack('footer')
</html>
