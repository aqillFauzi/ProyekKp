@extends('layout')
@section('content')
    <!-- ======= About =======-->
    <section class="about__v4 section" id="about">
        <div class="container mt-custom">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <div class="row justify-content-end">
                        <div class="col-md-11 mb-4 mb-md-0"><span class="subtitle text-uppercase mb-3" data-aos="fade-up"
                                data-aos-delay="0">BPJS Ketenagakerjaan</span>
                            <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100">Sejarah Terbentuknya BPJS Ketenagakerjaan</h2>
                            <div data-aos="fade-up" data-aos-delay="200">
                                <p>BPJS Ketenagakerjaan merupakan lembaga penyelenggara jaminan sosial tenaga kerja di
                                    Indonesia yang berawal dari peraturan perlindungan buruh sejak tahun 1947, kemudian
                                    berkembang menjadi program Asuransi Sosial Tenaga Kerja (ASTEK) pada tahun 1977. Melalui
                                    UU No. 3 Tahun 1992, PT Jamsostek (Persero) ditetapkan sebagai penyelenggara jaminan
                                    sosial tenaga kerja hingga akhirnya bertransformasi menjadi BPJS Ketenagakerjaan pada
                                    tahun 2014 berdasarkan UU Sistem Jaminan Sosial Nasional dan UU BPJS.
                                </p>
                                <p>Saat ini, BPJS
                                    Ketenagakerjaan menyelenggarakan berbagai program perlindungan untuk
                                    meningkatkan kesejahteraan pekerja Indonesia.</p>
                            </div>
                            <h4 class="small fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="300">Program Jaminan
                                Sosial Ketenagakerjaan</h4>
                            <ul class="d-flex flex-row flex-wrap list-unstyled gap-3 features" data-aos="fade-up"
                                data-aos-delay="400">
                                <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i
                                            class="bi bi-check"></i></span><span class="text">Jaminan Kecelakaan Kerja</span>
                                </li>
                                <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i
                                            class="bi bi-check"></i></span><span class="text">Jaminan Kehilangan Pekerjaan</span>
                                </li>
                                <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i
                                            class="bi bi-check"></i></span><span class="text">Jaminan Pensiun</span></li>
                                <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i
                                            class="bi bi-check"></i></span><span class="text">Jaminan Hari Tua</span></li>
                                <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i
                                            class="bi bi-check"></i></span><span class="text">Jaminan Kematian</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-wrap position-relative"><img class="img-fluid rounded-4"
                            src="assets/images/about-bpjs.jpg" alt="FreeBootstrap.net image placeholder" data-aos="fade-up"
                            data-aos-delay="0">
                        <div class="mission-statement p-4 rounded-4 d-flex gap-4" data-aos="fade-up" data-aos-delay="100">
                            {{-- <div class="mission-icon text-center rounded-circle"><i class="bi bi-lightbulb fs-4"></i></div> --}}
                            <div>
                                <h3 class="text-uppercase fw-bold fs-5">Visi</h3>
                                <p class="fs-6 mb-0">Mewujudkan jaminan sosial ketenagakerjaan yang terpercaya,
                                    berkelanjutan dan menyejahterakan pekerja indonesia
                                </p>
                            </div>
                        </div>

                        <div class="mission-statement p-4 rounded-4 d-flex gap-4 mt-2" data-aos="fade-up"
                            data-aos-delay="100">
                            {{-- <div class="mission-icon text-center rounded-circle"><i class="bi bi-lightbulb fs-4"></i></div> --}}
                            <div>
                                <h3 class="text-uppercase fw-bold fs-5">Misi</h3>
                                <p class="fs-6 mb-0"><i class="bi bi-caret-right-fill"> Melindungi, melayani dan
                                        menyejahterakan pekerja<br></i>
                                    <i class="bi bi-caret-right-fill"> Memberi rasa aman, mudah dan nyaman untuk
                                        meningkatkan produktivitas dan daya saing<br></i>
                                    <i class="bi bi-caret-right-fill"> Memberi kontribusi dalam pembangunan dan perekonomian
                                        bangsa dengan tata kelola baik</i>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About-->
@endsection
