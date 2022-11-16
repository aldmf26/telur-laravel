@if (session()->has('sukses'))
    <script>
        $(document).ready(function() {
            iziToast.success({
                title: 'Sukses !',
                message: "{{ session()->get('sukses') }}",
                position: 'topRight'
            });
        });
    </script>
@endif

@if (session()->has('error'))
    <script>
        $(document).ready(function() {
            iziToast.error({
                title: 'ERROR GAGAL HAPUS DATA !',
                message: "{{ session()->get('error') }}",
                position: 'topRight'
            });
        });
    </script>
@endif
