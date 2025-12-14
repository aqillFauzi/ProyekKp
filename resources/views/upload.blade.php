@extends('layout')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Upload Data Tenaga Kerja</h4>

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
                                    <small class="text-muted mb-0">Total Data NPP</small>
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
                                    <span>Tenaga Kerja Aktif</span>
                                    <div class="d-flex align-items-center my-1">
                                        <h4 class="mb-0 me-2">{{ number_format($total_tk_aktif) }}</h4>
                                    </div>
                                    <small class="text-muted mb-0">Total Seluruh TK</small>
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
                                    <small class="text-success mb-0">Terdaftar</small>
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
                                    <small class="text-danger mb-0">Belum Terdaftar</small>
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

            {{-- alert --}}
            @if(session('success_upload'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    {{ session('success_upload') }}
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
            {{-- /alert --}}

            {{-- table data --}}
            <div class="card mt-4">
                {{-- header table --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">DATA TENAGA KERJA</h5>

                        {{-- pagination control menu --}}
                        <form action="{{ route('upload.index') }}" method="GET">
                            <div class="d-flex align-items-center">
                                <span class="me-2 small text-muted">Show:</span>
                                <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    {{-- / pagination control menu --}}

                    {{-- tombol import excel --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalImport">
                        <i class="bx bx-upload me-1"></i> Import Excel
                    </button>
                    {{-- / tombol import excel --}}
                </div>
                {{-- / header table --}}

                {{-- isi table --}}
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Kantor</th>
                                <th>NPP</th>
                                <th>Divisi</th>
                                <th>Nama Perusahaan</th>
                                <th>TK Aktif</th>
                                <th>TK Sudah JMO</th>
                                <th>TK Belum JMO</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            {{-- query isi table --}}
                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $item->kode_kantor }}</td>
                                    <td><strong>{{ $item->npp }}</strong></td>
                                    <td>{{ $item->divisi }}</td>
                                    <td>{{ $item->nama_perusahaan }}</td>
                                    <td><span class="badge bg-label-primary me-1">{{ $item->tk_aktif }}</span></td>
                                    <td><span class="badge bg-label-success me-1">{{ $item->tk_sudah_jmo }}</span></td>
                                    <td><span class="badge bg-label-danger me-1">{{ $item->tk_belum_jmo }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data.</td>
                                </tr>
                            @endforelse
                            {{-- / query isi table --}}
                        </tbody>
                    </table>
                </div>
                {{-- / isi table --}}

                {{-- pagination info --}}

                <div class="d-flex justify-content-between align-items-center m-3">
                    <small class="text-muted">
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                    </small>
                    {{ $data->links() }}
                </div>
                {{-- / pagination info --}}

            </div>
            <hr class="my-5" />
            {{-- / table data --}}

            {{-- modal import excel --}}
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
                                        <small class="text-muted">Pastikan format kolom sesuai template.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- / modal import excel --}}
@endsection
        <!-- / Content -->