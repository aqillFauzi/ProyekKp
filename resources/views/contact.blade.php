@extends('layout')
@section('content')
    <!-- ======= Contact =======-->
    <section class="section contact__v2" id="contact">
        <div class="container mt-custom">
            <div class="row mb-5">
                <div class="col-md-6 col-lg-7 mx-auto text-center"><span class="subtitle text-uppercase mb-3"
                        data-aos="fade-up" data-aos-delay="0">BPJS Ketenagakerjaan</span>
                    <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Hubungi Kontak Kami</h2>
                    <p data-aos="fade-up" data-aos-delay="100">Anda dapat menghubungi kami melalui beberapa kontak yang
                        kami sediakan dibawah ini.
                    </p>
                </div>
            </div>

            <div class="row align-items-stretch">
                <!-- Keterangan Kontak -->
                <div class="col-md-6">
                    <div class="d-flex gap-5 flex-column h-100">
                        <div class="d-flex align-items-start gap-3" data-aos="fade-up">
                            <div class="icon d-block"><i class="bi bi-telephone"></i></div>
                            <span>
                                <span class="d-block">Telepon</span>
                                <strong>+(0761)33257</strong>
                            </span>
                        </div>

                        <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon d-block"><i class="bi bi-send"></i></div>
                            <span>
                                <span class="d-block">Email</span>
                                <strong>care@bpjsketenagakerjaan.go.id</strong>
                            </span>
                        </div>

                        <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon d-block"><i class="bi bi-geo-alt"></i></div>
                            <span>
                                <span class="d-block">Alamat</span>
                                <address class="fw-bold mb-0">
                                    Jl. Tengku Zainal Abidin No.26, Sekip, Kec. Lima Puluh,
                                    Kota Pekanbaru, Riau 28142
                                </address>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="col-md-6">
                    <div class="map-wrapper h-100">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6478522733064!2d101.45949927473686!3d0.5296440994651782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac3eb3030f17%3A0xf9a35e610348b85!2sBPJS%20Ketenagakerjaan%20Pekanbaru%20Kota!5e0!3m2!1sid!2sid!4v1765718633554!5m2!1sid!2sid"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Contact-->
@endsection
