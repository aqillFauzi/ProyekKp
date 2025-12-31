@extends('layout')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            
            <div class="col-lg-8 mb-4 order-0">
                <div class="card mb-4">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang Admin! 🎉</h5>
                                <p class="mb-4">
                                    Saat ini terdapat <span class="fw-bold">{{ number_format($total_tk_aktif) }}</span> tenaga kerja aktif yang terdata di sistem.
                                </p>
                                <a href="{{ route('upload.index') }}" class="btn btn-sm btn-outline-primary">Lihat Data</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Statistik Kepesertaan</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            2025
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                            <a class="dropdown-item" href="javascript:void(0);">2024</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">Progress Data</div>

                            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-success p-2"><i class="bx bx-check-circle text-success"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>Sudah</small>
                                        <h6 class="mb-0">{{ number_format($total_sudah_jmo) }}</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-danger p-2"><i class="bx bx-x-circle text-danger"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>Belum</small>
                                        <h6 class="mb-0">{{ number_format($total_belum_jmo) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="bx bx-buildings"></i>
                                        </span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Perusahaan</span>
                                <h3 class="card-title mb-2">{{ number_format($total_perusahaan) }}</h3>
                                <small class="text-primary fw-semibold"><i class="bx bx-check"></i> Active</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class="bx bx-group"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">TK Aktif</span>
                                <h3 class="card-title text-nowrap mb-1">{{ number_format($total_tk_aktif) }}</h3>
                                <small class="text-info fw-semibold">Total</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Sudah JMO</h5>
                                            <span class="badge bg-label-success rounded-pill">Terdaftar</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0 text-success">{{ number_format($total_sudah_jmo) }}</h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div> </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Belum JMO</h5>
                                            <span class="badge bg-label-danger rounded-pill">Pending</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0 text-danger">{{ number_format($total_belum_jmo) }}</h3>
                                        </div>
                                    </div>
                                    <div class="avatar flex-shrink-0" style="width: 50px; height: 50px;">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class="bx bx-x-circle fs-2"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
    </div>
</div>
@endsection