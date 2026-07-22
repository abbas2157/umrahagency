<!DOCTYPE html>

<html lang="en-GB">

<head>
    <meta charset="utf-8">
    @yield('meta')
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{asset('assets/images/logo.png')}}" type="image/png">
    <meta name="google-site-verification" content="WV0PLsmYj2A-TNNPd0DI5jqGr48fLRXR_2M5CVt_Wu0" />


    <meta name="twitter:card" content="summary">
    <meta name="robots" content="index, follow">
    <meta name="twitter:site" content="@umrahagency">
    <meta name="twitter:title" content="@yield('og_title', 'Hajj and Umrah Travel Agency in Pakistan | Trusted Pilgrimage Packages')">
    <meta name="twitter:description" content="@yield('og_description', 'Trusted Hajj and Umrah Travel Agency in Pakistan offering affordable and premium packages, visa, flights, accommodation near Haram, and guided services for a seamless spiritual experience.')">
    <meta name="twitter:creator" content="@umrahagency">
    <meta name="twitter:image:src" content="https://umrahagency.pk/assets/images/logo.png">
    <meta name="twitter:domain" content="https://umrahagency.pk/">

    <!-- facebook -->
    <meta property="og:title" content="@yield('og_title', 'Hajj and Umrah Travel Agency in Pakistan | Trusted Pilgrimage Packages')" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://umrahagency.pk/assets/images/logo.png" />
    <meta property="og:url" content="@yield('og_url', 'https://umrahagency.pk/')" />
    <meta property="og:description" content="@yield('og_description', 'Trusted Hajj and Umrah Travel Agency in Pakistan offering affordable and premium packages, visa, flights, accommodation near Haram, and guided services for a seamless spiritual experience.')" />

    <meta name="google-site-verification" content="rvAzZE4TBhBQLWDI31fFmvOvl7471uKKpTpp8LOeIHg" />

    <link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery-ui-autocomplete.min.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Playfair+Display:wght@400;700;900&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Preload Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    <!--fonts-->
    <!--owl carousel-->
    <link href="{{asset('assets/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/owl.carousel.default.min.css')}}" rel="stylesheet">
    <!--owl carousel-->
    <link href="{{asset('assets/css/checkbox.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.offcanvas.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/datepicker.style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/upload-style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/slick.css')}}" rel="stylesheet">
    <link rel="preload" href="{{asset('assets/media/pages/home-page-banner-for-haditours-1.webp')}}" as="image" type="image/webp">
    <link rel="preconnect" href="https://embed.tawk.to">
    <link rel="preconnect" href="https://www.googleadservices.com">
    <link rel="preconnect" href="https://googleads.g.doubleclick.net">
    <link rel="preconnect" href="https://www.google-analytics.com">
    <link rel="preconnect" href="https://analytics.google.com">
    <link rel="preconnect" href="https://www.google.com.pk">
    <link rel="preconnect" href="https://www.google.com">
    <style>
        .featuredPackagesUid .item {
            max-width: 545px;
        }
    </style>
</head>

<body>
    <!--header section Start-->
    @include('layouts.header')
    <!--header section End-->

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>
    <!--footer section Start-->
    @include('layouts.footer')
    <!--footer section End-->
    <script src="{{asset('assets/js/jquery.min.js')}}" defer></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}" defer></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}" defer></script>
    <script defer src="{{asset('assets/js/popper.min.js')}}"></script>
    <script defer src="{{asset('assets/js/bootstrap.offcanvas.min.js')}}"></script>
    <script defer src="{{asset('assets/js/jquery.matchHeight-min.js')}}"></script>
    <script defer src="{{asset('assets/js/jquery-ui-autocomplete.min.js')}}"></script>
    <script defer src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script defer src="{{asset('assets/js/jquery.fileupload.js')}}"></script>
    <script defer src="{{asset('assets/js/lity.js')}}"></script>
    <script defer src="{{asset('assets/js/smooth_scroll.js')}}"></script>
    <script src="{{asset('assets/js/svg.js')}}" defer></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}" defer></script>
    <script src="{{asset('assets/js/slick.min.js')}}" defer></script>
    <script src="{{asset('assets/js/custom.js')}}" defer></script>
    <script type="text/javascript">
        var base_url = "https://umrahagency.pk";
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof customUploader === 'function') {
                customUploader(base_url);
            }
        });

        // Lazy load tracking scripts after window load to improve Core Web Vitals
        window.addEventListener('load', function() {
            setTimeout(function() {
                // Meta Pixel
                !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '227919139647499');
                fbq('track', 'PageView');

                // Google Tag Manager
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-KX9P9TQ');

                // Google Ads & Analytics
                var gtmScript = document.createElement('script');
                gtmScript.async = true;
                gtmScript.src = 'https://www.googletagmanager.com/gtag/js?id=AW-10950422211';
                document.head.appendChild(gtmScript);

                gtmScript.onload = function() {
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', 'AW-10950422211');
                    gtag('config', 'UA-76624980-1');
                    gtag('event', 'conversion', {'send_to': 'AW-10950422211/vjiqCLDV-s0DEMPdyOUo'});
                };
            }, 3000); // 3 second delay
        });

        function initFooterSlider() {
            if (window.jQuery && $.fn.slick) {
                $('.footer-slick-carousel').each(function() {
                    if (!$(this).hasClass('slick-initialized')) {
                        $(this).slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: true,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fa fa-chevron-left"></i></button>',
                            nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fa fa-chevron-right"></i></button>'
                        });
                    }
                });
            } else {
                setTimeout(initFooterSlider, 50);
            }
        }
        document.addEventListener('DOMContentLoaded', initFooterSlider);
        
        // Contact Link Tracking
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href^="mailto:"], a[href^="tel:"]');
            if (link) {
                const href = link.getAttribute('href');
                const type = href.startsWith('mailto:') ? 'email' : 'phone';
                const value = href.replace(/^(mailto:|tel:)/, '');
                
                fetch('{{ route("logContactClick") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: type,
                        value: value,
                        page_url: window.location.href
                    })
                }).catch(err => console.error('Tracking failed', err));
            }
        });
    </script>
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/03251212747" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <i class="fa fa-whatsapp"></i>
    </a>

    @stack('scripts')
</body>
</html>