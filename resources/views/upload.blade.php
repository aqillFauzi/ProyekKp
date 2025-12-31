@extends('layout')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Monitoring Data Tenaga Kerja</h4>

            <div class="row g-6 mb-6">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Perusahaan</span>
                                    <div class="d-flex align-items-center my-1">
                                        <h4 class="mb-0 me-2">{{ number_format($total_perusahaan) }}</h4>
                                    </div>
                                    <small class="text-muted mb-0">NPP Terdaftar</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-buildings"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Peserta</span>
                                    <div class="d-flex align-items-center my-1">
                                        <h4 class="mb-0 me-2">{{ number_format($total_tk_aktif) }}</h4>
                                    </div>
                                    <small class="text-muted mb-0">Orang (Aktif)</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="bx bx-group"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Sudah JMO</span>
                                    <div class="d-flex align-items-center my-1">
                                        <h4 class="mb-0 me-2 text-success">{{ number_format($total_sudah_jmo) }}</h4>
                                    </div>
                                    <small class="text-success mb-0">Terverifikasi</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-check-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Belum JMO</span>
                                    <div class="d-flex align-items-center my-1">
                                        <h4 class="mb-0 me-2 text-danger">{{ number_format($total_belum_jmo) }}</h4>
                                    </div>
                                    <small class="text-danger mb-0">Pending</small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-x-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success_upload'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    <i class='bx bx-check-circle me-1'></i> {{ session('success_upload') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mt-4">
                {{-- HEADER TABLE --}}
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        
                        <h5 class="mb-0">DAFTAR PESERTA</h5>

                        {{-- FORM FILTER & PENCARIAN GABUNGAN --}}
                        <form action="{{ route('upload.index') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                            
                            {{-- 1. Dropdown Jumlah Data (Per Page) --}}
                            <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 Data</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Data</option>
                            </select>

                            {{-- 2. Dropdown Filter Status (BARU) --}}
                            <select name="filter_status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="">- Semua Status -</option>
                                <option value="Belum JMO" {{ request('filter_status') == 'Belum JMO' ? 'selected' : '' }}>Hanya Belum JMO</option>
                                <option value="Sudah JMO" {{ request('filter_status') == 'Sudah JMO' ? 'selected' : '' }}>Hanya Sudah JMO</option>
                            </select>

                            {{-- 3. Input Pencarian --}}
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama/NPP..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>

                        </form>

                        
                        {{-- GRUP TOMBOL (Download & Import) --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('upload.export.belumjmo', ['search' => request('search')]) }}" class="btn btn-success btn-sm">
                                <i class="bx bx-download me-1"></i> Download Belum JMO
                            </a>

                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">
                                <i class="bx bx-upload me-1"></i> Import
                            </button>
                        </div>
                        
                    </div>
                </div>
                {{-- / HEADER TABLE --}}

                <div class="table-responsive text-nowrap">
                   {{-- ... (lanjutan tabel ke bawah tetap sama) ... --}}

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kode TK</th>        <th>Nama Peserta</th>
                                <th>NPP</th>            <th>Nama Perusahaan</th>
                                <th>Segmen</th>
                                <th>Kontak</th>
                                <th>Status JMO</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($data as $item)
                                <tr>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $item->kode_tk }}</span>
                                    </td>

                                    <td class="fw-bold">
                                        {{ $item->nama_tk }}
                                    </td>
                                    
                                    <td>
                                        {{ $item->npp }}
                                    </td>

                                    <td>
                                        {{ Str::limit($item->nama_perusahaan, 30) }}
                                    </td>

                                    <td>
                                        {{ $item->kode_segmen ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->handphone ?? '-' }}
                                    </td>

                                    <td>
                                        @if($item->status_jmo == 'Sudah JMO')
                                            <span class="badge bg-label-success">
                                                <i class='bx bx-check-circle me-1'></i>Sudah
                                            </span>
                                        @else
                                            <span class="badge bg-label-danger">
                                                <i class='bx bx-x-circle me-1'></i>Belum
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">Belum ada data. Silakan upload file Excel.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center m-3">
                    <small class="text-muted">
                        Menampilkan {{ $data->firstItem() }} s/d {{ $data->lastItem() }} dari {{ $data->total() }} data
                    </small>
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>
            
            <hr class="my-5" />

            <div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Import Data Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('upload.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="fileExcel" class="form-label">Pilih File Excel (.xlsx / .csv)</label>
                                        <input class="form-control" type="file" id="fileExcel" name="file" required>
                                        <small class="text-muted">Pastikan format kolom sesuai data BPJS.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
    </div>
@endsection