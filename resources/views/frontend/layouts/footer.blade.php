<footer id="footer" class="footer">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                @php
                $footerKontak = \App\Models\Kontak::first();
                @endphp
                <a href="index.html" class="logo d-flex align-items-center">
                    <span class="sitename">{{$footerKontak->nama_kantor ?? '-'}}</span>
                </a>
                <div class="footer-contact pt-3">

                    @if($footerKontak)
                    <p>{{ $footerKontak->alamat }}</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>{{ $footerKontak->telepon ?? '-' }}</span></p>
                    <p><strong>Email:</strong> <span>{{ $footerKontak->email ?? '-' }}</span></p>
                    @else
                    <p>Alamat belum tersedia</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>-</span></p>
                    <p><strong>Email:</strong> <span>-</span></p>
                    @endif
                </div>
                
                <!-- Sosial Media -->
                <div class="social-links d-flex mt-4">
                    @foreach($socials as $social)
                    <a href="{{ $social->profile_url ?? '-' }}" target="_blank" title="{{ $social->platform_name ?? '-' }}">
                        <i class="{{ $social->icon_class ?? '-' }}"></i>
                    </a>
                    @endforeach
                </div>

            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Product Management</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Graphic Design</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Hic solutasetp</h4>
                <ul>
                    <li><a href="#">Molestiae accusamus iure</a></li>
                    <li><a href="#">Excepturi dignissimos</a></li>
                    <li><a href="#">Suscipit distinctio</a></li>
                    <li><a href="#">Dilecta</a></li>
                    <li><a href="#">Sit quas consectetur</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Nobis illum</h4>
                <ul>
                    <li><a href="#">Ipsam</a></li>
                    <li><a href="#">Laudantium dolorum</a></li>
                    <li><a href="#">Dinera</a></li>
                    <li><a href="#">Trodelas</a></li>
                    <li><a href="#">Flexo</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content">
                        <p class="mb-0">© {{ date('Y') }},<strong> {{ $footerKontak->nama_kantor }}</strong>. All rights reserved.</p>
                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you've purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                            Designed by Prakom Kemenag Lebak
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>