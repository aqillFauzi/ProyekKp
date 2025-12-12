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
                                        <span class="text-heading">Users</span>
                                        <div class="d-flex align-items-center my-1">
                                            <h4 class="mb-0 me-2">3</h4>
                                            <p class="text-success mb-0">(100%)</p>
                                        </div>
                                        <small class="mb-0">Total Users</small>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="icon-base bx bx-group icon-lg"></i>
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
                                        <span class="text-heading">Verified Users</span>
                                        <div class="d-flex align-items-center my-1">
                                            <h4 class="mb-0 me-2">0</h4>
                                            <p class="text-success mb-0">(+95%)</p>
                                        </div>
                                        <small class="mb-0">Recent analytics </small>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-danger">
                                            <i class="icon-base bx bx-user-plus icon-lg"></i>
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
                                        <span class="text-heading">Duplicate Users</span>
                                        <div class="d-flex align-items-center my-1">
                                            <h4 class="mb-0 me-2">0</h4>
                                            <p class="text-success mb-0">(0%)</p>
                                        </div>
                                        <small class="mb-0">Recent analytics</small>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class="icon-base bx bx-user-check icon-lg"></i>
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
                                        <span class="text-heading">Verification Pending</span>
                                        <div class="d-flex align-items-center my-1">
                                            <h4 class="mb-0 me-2">3</h4>
                                            <p class="text-danger mb-0">(+6%)</p>
                                        </div>
                                        <small class="mb-0">Recent analytics</small>
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class="icon-base bx bx-user-voice icon-lg"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Basic Bootstrap Table -->
                <div class="card mt-4">
    <h5 class="card-header">DATA TENAGA KERJA</h5>
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
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->kode_kantor }}</td>
                    <td><strong>{{ $item->npp }}</strong></td>
                    <td>{{ $item->divisi }}</td>
                    <td>{{ $item->nama_perusahaan }}</td>
                    <td>
                        <span class="badge bg-label-primary me-1">{{ $item->tk_aktif }}</span>
                    </td>
                    <td>
                        <span class="badge bg-label-success me-1">{{ $item->tk_sudah_jmo }}</span>
                    </td>
                    <td>
                        <span class="badge bg-label-danger me-1">{{ $item->tk_belum_jmo }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data yang diupload.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end m-3">
        {{ $data->links() }}
    </div>

</div>
                <!--/ Basic Bootstrap Table -->

                <hr class="my-5" />
@endsection
            <!-- / Content -->