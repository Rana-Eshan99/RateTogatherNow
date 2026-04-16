@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success'
        });
    </script>
@endif

@if (session('error'))
    {{ session('error') }}
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error'
        });
    </script>
@endif

@if (session('info'))
    <script>
        Swal.fire({
            title: 'Info!',
            text: "{{ session('info') }}",
            icon: 'info'
        });
    </script>
@endif

@if (session('warning'))
    <script>
        Swal.fire({
            title: 'Warning!',
            text: "{{ session('warning') }}",
            icon: 'warning'
        });
    </script>
@endif

@if (session('invalid'))
    <script>
        Swal.fire({
            title: 'Warning!',
            text: "{{ session('invalid') }}",
            icon: 'warning'
        });
    </script>
@endif
