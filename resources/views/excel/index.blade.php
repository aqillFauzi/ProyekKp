<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Perusahaan</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen text-gray-800">

    <div class="max-w-4xl mx-auto py-10">

        <!-- Judul -->
        <h1 class="text-4xl font-bold mb-8 text-center text-blue-700">
            📊 Manajemen Data Perusahaan
        </h1>

        <!-- Upload Section -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-10">

            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                📤 Upload File Excel
            </h2>

            <form action="{{ route('tenagakerja.import') }}" method="POST" enctype="multipart/form-data"
                class="flex items-center gap-4">
                @csrf

                <input type="file" name="file"
                    class="block w-full text-sm text-gray-700 border rounded-lg p-2 bg-gray-50">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    Upload & Simpan
                </button>
            </form>

            @if ($errors->any())
                <p class="text-red-600 mt-3">{{ $errors->first() }}</p>
            @endif

            @if (session('success'))
                <p class="text-green-600 mt-3">{{ session('success') }}</p>
            @endif
        </div>

        <!-- Search Section -->
        <div class="bg-white shadow-lg rounded-xl p-6">

            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                🔍 Cari Perusahaan Berdasarkan NPP
            </h2>

            <form action="{{ route('tenagakerja.search') }}" method="GET"
                class="flex gap-3 mb-6">

                <input type="text" name="npp"
                    class="flex-1 p-3 border rounded-lg bg-gray-50"
                    placeholder="Masukkan NPP...">

                <button
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow">
                    Cari
                </button>
            </form>

            <!-- Hasil pencarian -->
            @if (isset($tenagakerja))
                <div class="bg-blue-50 p-5 rounded-lg border border-blue-200">

                    <h3 class="text-lg font-semibold mb-3">Hasil Pencarian</h3>

                    <p><strong>NPP:</strong> {{ $tenagakerja->npp }}</p>
                    <p><strong>Nama Perusahaan:</strong> {{ $tenagakerja->nama_perusahaan }}</p>
                    <p><strong>TK Aktif:</strong> {{ $tenagakerja->tk_aktif }}</p>
                    <p><strong>TK Sudah JMO:</strong> {{ $tenagakerja->tk_sudah_jmo }}</p>
                    <p><strong>TK Belum JMO:</strong> {{ $tenagakerja->tk_belum_jmo }}</p>

                </div>
            @endif

        </div>

    </div>

</body>
</html>
