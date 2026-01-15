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
                                <h5 class="card-title text-primary">
                                    Selamat Datang, <span class="fw-bold">{{ auth()->user()->name }}</span>! 🎉
                                </h5>
                                <p class="mb-4">
                                    Saat ini terdapat <span class="fw-bold">{{ number_format($total_tk_aktif) }}</span> tenaga kerja aktif.
                                </p>
                                <a href="{{ route('upload.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data Excel</a>
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

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Perbandingan Data JMO</h5>
                        <small class="text-muted">Updated {{ date('Y-m-d') }}</small>
                    </div>
                    <div class="card-body">
                        <div id="mainBarChart"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Total Perusahaan</h5>
                                            <span class="badge bg-label-primary rounded-pill">NPP Aktif</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0">{{ number_format($total_perusahaan) }}</h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Total Tenaga Kerja</h5>
                                            <span class="badge bg-label-info rounded-pill">Peserta Aktif</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <h3 class="mb-0">{{ number_format($total_tk_aktif) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 order-1">
                
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="text-center fw-semibold mb-2">Pencapaian Registrasi</div>
                        <div id="radialChart"></div>
                        <p class="text-center text-muted mt-2">Persentase tenaga kerja yang sudah memiliki akun JMO.</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="d-block">Sudah JMO</span>
                            <span class="badge bg-label-success">Terregistrasi</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 text-success">{{ number_format($total_sudah_jmo) }}</h3>
                            <div id="sparklineSudah"></div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="d-block">Belum JMO</span>
                            <span class="badge bg-label-danger">Pending</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 text-danger">{{ number_format($total_belum_jmo) }}</h3>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-x-circle fs-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    
    // --- DATA DARI CONTROLLER ---
    const totalSudah = {{ $total_sudah_jmo ?? 0 }};
    const totalBelum = {{ $total_belum_jmo ?? 0 }};
    const totalSemua = {{ $total_tk_aktif ?? 0 }};
    const persentaseSukses = totalSemua > 0 ? Math.round((totalSudah / totalSemua) * 100) : 0;

    // --------------------------------------------------------------------
    // 1. GRAFIK BATANG BESAR (Comparison Bar)
    // --------------------------------------------------------------------
    const barEl = document.querySelector('#mainBarChart');
    if (barEl) {
      const barOpt = {
        series: [totalSudah, totalBelum], // Data langsung array
        chart: {
          type: 'donut', // Ganti jadi Donut
          height: 350,
        },
        labels: ['Sudah JMO', 'Belum JMO'],
        colors: ['#71dd37', '#ff3e1d'],
        plotOptions: {
          pie: {
            startAngle: -90, // Membuat bentuk setengah lingkaran
            endAngle: 90,
            offsetY: 10,
            donut: {
              size: '70%', // Ketebalan donut
              labels: {
                show: true,
                name: { show: true, offsetY: -20 },
                value: { 
                    show: true, 
                    fontSize: '24px', 
                    fontWeight: 'bold', 
                    offsetY: -10,
                    formatter: function (val) { return val.toLocaleString(); }
                },
                total: {
                  show: true,
                  label: 'Total TK',
                  fontSize: '16px',
                  color: '#566a7f',
                  formatter: function (w) {
                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString();
                  }
                }
              }
            }
          }
        },
        dataLabels: { enabled: false }, // Label kecil dimatikan biar bersih
        legend: { position: 'bottom' },
        grid: { padding: { bottom: -80 } } // Hapus ruang kosong di bawah
      };
      new ApexCharts(barEl, barOpt).render();
    }

    // --------------------------------------------------------------------
    // 2. GRAFIK PERSENTASE (Radial Chart)
    // --------------------------------------------------------------------
    const radialEl = document.querySelector('#radialChart');
    if (radialEl) {
      const radialOpt = {
        series: [persentaseSukses],
        chart: { height: 250, type: 'radialBar' },
        plotOptions: {
          radialBar: {
            hollow: { size: '60%' },
            dataLabels: {
              name: { show: false },
              value: { offsetY: 10, fontSize: '24px', fontWeight: 'bold', color: '#566a7f', formatter: val => val + '%' }
            },
            track: { background: '#f2f2f5' }
          }
        },
        stroke: { lineCap: 'round' },
        colors: [persentaseSukses > 50 ? '#696cff' : '#ffab00'] // Biru jika >50, Kuning jika kurang
      };
      new ApexCharts(radialEl, radialOpt).render();
    }

    // --------------------------------------------------------------------
    // 3. GRAFIK GELOMBANG KECIL (Sparkline - Seperti di Gambar Anda)
    // --------------------------------------------------------------------
    const sparkEl = document.querySelector('#sparklineSudah');
    if (sparkEl) {
      const sparkOpt = {
        series: [{ data: [10, 25, 15, 30, 20, 45, 35, 50] }], // Data dummy untuk efek gelombang visual
        chart: { type: 'area', height: 50, width: 100, sparkline: { enabled: true } },
        stroke: { curve: 'smooth', width: 2 },
        fill: { opacity: 0.3 },
        colors: ['#ffab00'], // Warna Kuning/Oranye seperti gambar
        tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => '' } }, marker: { show: false } }
      };
      new ApexCharts(sparkEl, sparkOpt).render();
    }

  });
</script>
@endpush