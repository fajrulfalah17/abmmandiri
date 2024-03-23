<script src="{{ asset('Admin/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Admin/dist/assets/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ asset('Admin/dist/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('Admin/dist/assets/libs/eva-icons/eva.min.js') }}"></script>

<!-- swiper js -->
<script src="{{ asset('Admin/dist/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<script src="{{ asset('Admin/dist/assets/js/pages/ecommerce-product-detail.init.js') }}"></script>

<script src="{{ asset('Admin/dist/assets/js/app.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.min.js"></script>

{{-- <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script> --}}

<!-- color picker js -->
<script src="{{ asset('Admin/dist/assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
<script src="{{ asset('Admin/dist/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

<!-- datepicker js -->
<script src="{{ asset('Admin/dist/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

<!-- init js -->
<script src="{{ asset('Admin/dist/assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ asset('Admin/dist/assets/libs/fullcalendar/main.min.js') }}"></script>

<!-- Calendar init -->
<script src="{{ asset('Admin/dist/assets/js/pages/calendar.init.js') }}"></script>
<script>
    function displayTime() {
        const now = new Date();
        const options = {
            timeZone: 'Asia/Jakarta'
        };
        const formattedTime = now.toLocaleString('id-ID', options);
        $('#tanggalwaktu').text(formattedTime);
    }

    $(document).ready(function() {
        displayTime();
        setInterval(displayTime, 1000);
    });
</script>

