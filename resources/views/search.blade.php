@extends('layout')

@section('content')
    {{-- <section class="section howitworks__v1" id="upload">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-1 text-center mx-auto">
                    <span class="subtitle text-uppercase mb-2" data-aos="fade-up" data-aos-delay="0">Upload</span>
                    <h2 data-aos="fade-up" data-aos-delay="100" class="mb-2">Upload File Excel</h2>
                    <p data-aos="fade-up" data-aos-delay="200" class="mb-3">
                        Pilih file Excel (.xlsx) untuk dianalisis. Data akan tersedia untuk dicari di bawah setelah
                        diunggah.
                    </p>
                </div>
            </div>

            <div class="row g-md-5">
                <div class="col-12">
                    <div class="upload-card text-center h-100 d-flex flex-column justify-content-start position-relative p-4 rounded-4">

                        @if (session('success_upload'))
                            <div class="alert alert-success">{{ session('success_upload') }}</div>
                        @endif
                        @if ($errors->has('file'))
                            <div class="alert alert-danger">{{ $errors->first('file') }}</div>
                        @endif

                        <form action="{{ route('tenagakerja.import') }}" method="post" enctype="multipart/form-data" class="mt-2">
                            @csrf 
                            <div class="mb-2">
                                <input type="file" name="file" accept=".xlsx" required class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary px-4 py-2">Upload & Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section pricing__v2" id="search">
        <div class="container mt-custom">

            <div class="row mb-5">
                <div class="col-md-5 mx-auto text-center">
                    <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">BPJS
                        Ketenagakerjaan</span>
                    <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Cari Data Pekerja Disini</h2>
                    <p class="mb-2" data-aos="fade-up" data-aos-delay="200">Silahkan masukkan nomor NPP untuk mulai mencari data 
                        pekerja yang dibutuhkan pada kolom dibawah.
                    </p>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-8 mb-3 mx-auto" data-aos="fade-up" data-aos-delay="400">
                    <div class="pt-3 px-5 pb-4 rounded-4 price-table h-100 text-center">

                        {{-- <h3 class="mb-3">Cari Data Pekerja Berdasarkan Nomor NPP</h3> --}}

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('tenagakerja.search') }}" method="POST">
                            @csrf <div class="mb-3">
                                <input type="text" name="npp" class="form-control" placeholder="Masukkan Nomor NPP..."
                                    required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Cari</button>
                        </form>

                    </div>
                </div>
            </div>

            @if (session('tenagakerja'))
                @php $tk = session('tenagakerja'); @endphp

                <div class="row mt-4">
                    <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-delay="450">

                        <div class="p-5 rounded-4 text-center text-white" style="background-color: #144e4a;">

                            <h3 class="mb-5 fs-3 fw-normal text-white">
                                {{ $tk->nama_perusahaan }}
                            </h3>

                            <div class="row">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <span class="d-block fw-bold display-4 mb-2 fs-1">{{ $tk->tk_aktif }}</span>
                                    <span class="fs-5 opacity-75">Tenaga Kerja Aktif</span>
                                </div>

                                <div class="col-md-4 mb-4 mb-md-0">
                                    <span class="d-block fw-bold display-4 mb-2 fs-1">{{ $tk->tk_sudah_jmo }}</span>
                                    <span class="fs-5 opacity-75">Terdaftar JMO</span>
                                </div>

                                <div class="col-md-4">
                                    <span class="d-block fw-bold display-4 mb-2 fs-1">{{ $tk->tk_belum_jmo }}</span>
                                    <span class="fs-5 opacity-75">Belum JMO</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
