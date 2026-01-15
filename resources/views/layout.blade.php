<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>BPJSTK-JMO</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Page CSS -->
    {{-- costum css -> theme hijau --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/assets/js/config.js') }}"></script>
</head>

<body>

    @include('components.header')

    @include('components.navbar')

    @yield('content')
    @include('components.footer')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Page JS -->
    <!-- <script src="{{asset('assets/js/dashboards-analytics.js') }}"></script> -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->

    <script>
        function confirmReset() {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Semua data peserta akan DIHAPUS PERMANEN! Database akan dikosongkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d', // Warna Merah (Sesuai tema template Anda)
                cancelButtonColor: '#8592a3', // Warna Abu-abu
                confirmButtonText: 'Ya, Hapus Data!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Posisi tombol dibalik agar tidak salah klik
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik "Ya", submit form secara manual
                    document.getElementById('formResetDb').submit();
                }
            })
        }
    </script>

    <script>
        // Fungsi untuk Hapus Per Item
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Peserta Ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d', // Merah
                cancelButtonColor: '#8592a3', // Abu-abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cari form berdasarkan ID unik lalu submit
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    <script>
        async function openImportModal() {
            // 1. Tampilkan Popup Input File
            const {
                value: file
            } = await Swal.fire({
                title: 'Import Data Excel',
                text: 'PILIH FILE EXCEL (.XLSX / .CSV)', // Sub-judul
                input: 'file', // Ini yang membuat input file muncul otomatis
                inputAttributes: {
                    'accept': '.xlsx, .csv, .xls',
                    'aria-label': 'Upload file excel anda'
                },
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#008c78', // Warna Teal/Hijau (sesuai gambar Anda)
                cancelButtonColor: '#8592a3', // Warna Abu-abu
                showLoaderOnConfirm: true, // Muncul loading saat klik Upload

                // 2. Logic saat tombol Upload ditekan
                preConfirm: (file) => {
                    if (!file) {
                        Swal.showValidationMessage('Anda belum memilih file!');
                        return;
                    }

                    // Membuat Form Data Virtual (Pengganti <form> HTML)
                    const formData = new FormData();
                    formData.append('file', file); // name="file"
                    formData.append('_token', '{{ csrf_token() }}'); // CSRF Token Laravel

                    // Kirim ke Backend (Route Laravel)
                    return fetch("{{ route('upload.import') }}", {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response; // Sukses
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Gagal Upload: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })

            // 3. Jika Upload Berhasil
            if (file) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Excel sedang diproses.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(); // Refresh halaman otomatis
                });
            }
        }
    </script>

    {{-- 2. TAMBAHKAN BARIS INI (WAJIB) --}}
    @stack('scripts')

</body>

</html>