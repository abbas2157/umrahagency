<header>
    <!-- Top Bar -->
    <div class="topbar" style="background-color: #193670; color: #fff; font-size: 15px; padding: 12px 0;">
        <div class="container px-3 px-md-5">
            <div class="topbar-inner d-flex align-items-center flex-wrap" style="justify-content: center; position: relative;">
                <!-- Left: Contact Info -->
                <div class="topbar-left d-flex flex-wrap align-items-center" style="gap: 14px;">
                   <a href="tel:03251212747" style="color: #fff; text-decoration: none; white-space: nowrap;">
                        <i class="fa fa-phone" style="margin-right: 14px; vertical-align: middle;"></i><span style="vertical-align: middle;">03251212747</span>
                    </a>
                    <a href="mailto:info@umrahagency.pk" style="color: #fff; text-decoration: none; white-space: nowrap;">
                        <i class="fa fa-envelope" style="margin-right: 14px; vertical-align: middle;"></i><span style="vertical-align: middle;">info@umrahagency.pk</span>
                    </a>
                    <span style="white-space: nowrap; color: #fff;" class="d-none d-lg-inline">
                        <i class="fa fa-map-marker" style="margin-right: 14px; vertical-align: middle;"></i><span style="vertical-align: middle;">Doctor Hospital Johar Town Lahore</span>
                    </span>
                </div>
                <!-- Right: Social Icons -->
                <div class="topbar-right d-flex align-items-center" style="gap: 24px; position: absolute; right: 0;">
                    <a href="https://www.facebook.com/umrahagency" rel="nofollow" target="_blank" style="color: #fff; font-size: 16px;" title="Facebook">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/umrahagency/" rel="nofollow" target="_blank" style="color: #fff; font-size: 16px;" title="Twitter">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/umrahagency/" rel="nofollow" target="_blank" style="color: #fff; font-size: 16px;" title="Instagram">
                        <i class="fa fa-instagram"></i>
                    </a>
                    <a href="https://www.pinterest.com/umrahagency/" rel="nofollow" target="_blank" style="color: #fff; font-size: 16px;" title="Pinterest">
                        <i class="fa fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 575px) {
            .topbar-inner {
                flex-direction: column !important;
                text-align: center;
                gap: 6px;
            }
            .topbar-left,
            .topbar-right {
                justify-content: center;
                width: 100%;
                position: static !important;
            }
        }
        @media (max-width: 366px) {
            .topbar-left {
                gap: 0 !important;
            }
        }
    </style>
    <!-- End Top Bar -->
    <nav class="navbar navbar-expand-md">
        <div class="container px-3 px-md-5">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="img-responsive" src="{{asset('assets/images/logo.png')}}" alt="Umrah Agency Pakistan">
            </a>
            <div class="whts d-flex d-md-none">
                <a href="https://wa.me/+4407877190363" target="_blank">
                    <img src="{{asset('assets/images/whatsapp.svg')}}" alt="whatsapp" loading="lazy">
                    <span class="d-none d-sm-block d-md-none ">07877190363</span>
                </a>
            </div>
            <div class="custom-nav navbar-offcanvas navbar-offcanvas-fade navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li ><a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="dropdown"><a class="{{ request()->is('umrah-packages') ? 'active' : '' }}"  href="{{ route('umrahPackages') }}">Umrah Package<span class="caret"></span></a> <i class="fa fa-plus"></i>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('umrahPackages') }}" class="">Umrah Packages</a></li>
                            <!-- <li><a href="{{ route('umrahPackages2026') }}" class="">Umrah Packages 2026</a></li> -->
                            <li><a href="{{ route('decemberUmrahPackages') }}" class="">December Umrah</a></li>
                            <li><a href="{{ route('ramadanUmrah') }}" class="">Ramadan Umrah</a></li>
                            <li><a href="{{ route('easterUmrahPackages') }}" class="">Easter Umrah</a></li>
                            <li><a href="{{ route('lahoreUmrah') }}" class="">Lahore Umrah</a></li>
                        </ul>
                    </li>
                    <li><a class="{{ request()->is('cheap-hajj-packages') ? 'active' : '' }}" href="{{ route('hajj') }}">Hajj</a></li>
                    <li><a class="{{ request()->is('umrah-visa') ? 'active' : '' }}" href="{{ route('umrahVisa') }}">Umrah Visa</a></li>
                    <li><a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{ route('contactUs') }}">Contact Us</a></li>
                </ul>
            </div>
            <button class="navbar-toggler offcanvas-toggle" type="button" data-toggle="offcanvas"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </button>
            <div class="ml-auto d-none d-xl-block">
                <a href="{{ route('contactUs') }}" style="background-color: #193670; color: #fff; padding: 10px 22px; border-radius: 14px; text-decoration: none; font-weight: 600; font-size: 15px; white-space: nowrap; display: inline-block;">
                    Beat a Quote
                </a>
            </div>
        </div>
    </nav>
    <!--mobile view button-->
    <div class="mobileButtons">
        <a class="phone" href="tel:+92-XXX-XXXXXXX"><img height="28" width="28" class="svg" src="{{asset('assets/images/waving-phone.svg')}}" alt="phone image" loading="lazy"></a>
    </div>
    <!--mobile view button-->
</header>


