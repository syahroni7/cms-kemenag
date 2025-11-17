@extends('frontend.layouts.master')
@section('title', $title)

@section('_styles')
<style>
    /* Agar line break di jam_operasional tampil */
    .jam-operasional {
        white-space: pre-line;
    }
</style>
@endsection

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="title-wrapper">
            <h1>Kontak</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
        </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            @if($kontak)
            <div class="row gy-4 mb-5">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h3>Alamat</h3>
                        <p>{{ $kontak->alamat }}</p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h3>Kontak</h3>
                        <p>
                            Telepon: {{ $kontak->telepon ?? '-' }}<br>
                            Email: {{ $kontak->email ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-card">
                        <div class="icon-box">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h3>Jam Operasional</h3>
                        <p class="jam-operasional">{{ $kontak->jam_operasional ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @else
            <p>Data kontak belum tersedia.</p>
            @endif

            <!-- Form Kontak -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" class="form-control" placeholder="Your name*" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" placeholder="Email address*" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone number*" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-list"></i></span>
                                        <select name="subject" class="form-control" required="">
                                            <option value="">Select service*</option>
                                            <option value="Service 1">Consulting</option>
                                            <option value="Service 2">Development</option>
                                            <option value="Service 3">Marketing</option>
                                            <option value="Service 4">Support</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                        <textarea class="form-control" name="message" rows="6" placeholder="Write a message*" required=""></textarea>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>
                                </div>
                                <div class="text-center">
                                    <button type="submit">Submit Message</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- /Contact Section -->

</main>
@endsection

@section('_scripts')
@endsection
