@extends('layouts.master')
@section('meta')
<title>Hajj and Umrah Travel Agency in Pakistan | Trusted Pilgrimage Packages</title>
<meta name="description" content="Plan your sacred journey with our trusted Hajj and Umrah Travel Agency in Pakistan. Offering affordable and premium packages, visa assistance, flights, accommodation near Haram, and guided services for a seamless spiritual experience.">
<link rel="canonical" href="https://umrahagency.pk" />
@endsection
@verbatim
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "TravelAgency",
        "@id": "https://umrahagency.pk/#travelagency",
        "name": "Umrah Agency Pakistan",
        "alternateName": "Leading Hajj and Umrah Travel Agency in Pakistan",
        "url": "https://umrahagency.pk/",
        "image": "https://umrahagency.pk/public/assets/images/logo.png",
        "logo": "https://umrahagency.pk/public/assets/images/logo.png",
        "description": "Umrah Agency Pakistan is a leading Hajj and Umrah tours Operator in Pakistan, specialising in Umrah packages, Hajj support, flights, hotels, and tailored Hajj and Umrah travel services.",
        "priceRange": "$$$",
        "telephone": "03251212747",
        "email": "info@umrahagency.pk",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Doctor Hospital Johar Town",
            "addressLocality": "Lahore",
            "addressCountry": "PK"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 31.5204,
            "longitude": 74.3587
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "03251212747",
            "contactType": "customer service",
            "areaServed": "PK",
            "availableLanguage": ["English", "Urdu", "Arabic"]
        },
        "openingHoursSpecification": [{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday"
                ],
                "opens": "09:00",
                "closes": "20:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Saturday", "Sunday"],
                "opens": "10:00",
                "closes": "18:00"
            }
        ],
        "sameAs": [
            "https://www.facebook.com/umrahagency",
            "https://x.com/umrahagency",
            "https://www.instagram.com/umrahagency",
            "https://www.pinterest.com/umrahagency",
            "https://www.linkedin.com/company/umrahagency"
        ],
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": 4.9,
            "bestRating": 5
        },
        "knowsAbout": [
            "Family Umrah Packages from Pakistan",
            "Group and Individual Umrah Packages Pakistan",
            "Hajj & Umrah Services",
            "Leading Hajj and Umrah Tours Agency in Pakistan",
            "Flights & Hotels Booking"
        ],
        "makesOffer": [{
                "@type": "Offer",
                "name": "Umrah Packages",
                "url": "https://umrahagency.pk/umrah-packages.html",
                "description": "Affordable 3-star, 4-star, and 5-star Umrah packages including flights, visa, hotels near Haram, transport, and Ziyarat tours.",
                "availability": "https://schema.org/InStock"
            },
            {
                "@type": "Offer",
                "name": "Hajj Support Services",
                "url": "https://umrahagency.pk/cheap-hajj-packages.html",
                "description": "Guided Hajj advice and support provided by experienced consultants.",
                "availability": "https://schema.org/InStock"
            },
            {
                "@type": "Offer",
                "name": "Flights & Hotel Bookings",
                "url": "https://umrahagency.pk",
                "description": "Worldwide flights, hotel booking services, and customized travel itineraries.",
                "availability": "https://schema.org/InStock"
            }
        ]
    }
</script>
@endverbatim
@section('content')
<section class="search-banner">
    <!--slider section Start-->
    <div class="banner">
        <img src="{{asset('assets/media/pages/home-page-banner-for-haditours-1.png')}}" class="img-fluid" alt="Home Page Banner - Umrah Agency Pakistan" width="1920" height="600" fetchpriority="high">
        <div class="banner-text">
            <h1>Hajj and Umrah Travel Agency in Pakistan</h1>
        </div>
    </div>
    <div class="searchEngine" id="packageInquiry">
        <div class="searchFields">
            <form class="form" method="post" action="{{ route('sendInquiry') }}" id="frm-enquiry" name="frm-enquiry">
                @csrf

                <div class="form-group Half">
                    <label for="enquiry-departure">
                        <i class="fa fa-plane fa-2x text-warning mr-1" style="color: #C88916 !important;font-size: 1.4em;"></i> Departure Airport
                    </label>
                    <select class="form-control" id="enquiry-departure" name="n[Departure Airport]" required>
                        <option value="">Departure Airport</option>
                        <option value="Lahore">Lahore</option>
                        <option value="Karachi">Karachi</option>
                        <option value="Islamabad">Islamabad</option>
                        <option value="Multan">Multan</option>
                        <option value="Sialkot">Sialkot</option>
                        <option value="Faisalabad">Faisalabad</option>
                        <option value="Peshawar">Peshawar</option>
                        <option value="Other">Other Pakistan Airport</option>
                    </select>
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-departuredate">
                        <i class="fa fa-calendar fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Departure Date
                    </label>
                    <input type="text" id="enquiry-departuredate" name="n[Departure Date]" class="DepartureDate form-control" readonly placeholder="Departure Date" required />
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-hotelcategory">
                        <i class="fa fa-hotel fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Hotel Category
                    </label>
                    <select class="form-control" id="enquiry-hotelcategory" name="n[Hotel Category]">
                        <option value="">Hotel Category</option>
                        <option value="3 Star">3 Star</option>
                        <option value="4 Star">4 Star</option>
                        <option value="5 Star">5 Star</option>
                    </select>
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-duration">
                        <i class="fa fa-moon-o fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Duration
                    </label>
                    <select class="form-control" id="enquiry-duration" name="n[Duration]">
                        <option value="">Duration</option>
                        <option value="1 Night">1 Night</option>
                        <option value="2 Nights">2 Nights</option>
                        <option value="3 Nights">3 Nights</option>
                        <option value="4 Nights">4 Nights</option>
                        <option value="5 Nights">5 Nights</option>
                        <option value="6 Nights">6 Nights</option>
                        <option value="7 Nights">7 Nights</option>
                        <option value="8 Nights">8 Nights</option>
                        <option value="9 Nights">9 Nights</option>
                        <option value="10 Nights">10 Nights</option>
                        <option value="11 Nights">11 Nights</option>
                        <option value="12 Nights">12 Nights</option>
                        <option value="13 Nights">13 Nights</option>
                        <option value="14 Nights">14 Nights</option>
                        <option value="14+ Nights">14+ Nights</option>
                    </select>
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-travelers">
                        <i class="fa fa-users fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Travelers
                    </label>
                    <select class="form-control" id="enquiry-travelers" name="n[No. of Travelers]">
                        <option value="">No. of Travelers</option>
                        <option value="1 Travel">1</option>
                        <option value="2 Travelers">2</option>
                        <option value="3 Travelers">3</option>
                        <option value="4 Travelers">4</option>
                        <option value="5 Travelers">5</option>
                        <option value="6 Travelers">6</option>
                        <option value="7 Travelers">7</option>
                        <option value="8 Travelers">8</option>
                        <option value="9 Travelers">9</option>
                        <option value="10 Travelers">10</option>
                        <option value="11 Travelers">11</option>
                        <option value="12 Travelers">12</option>
                        <option value="13 Travelers">13</option>
                        <option value="14 Travelers">14</option>
                        <option value="14+ Travelers">14+</option>
                    </select>
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-name"><i class="fa fa-user fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Full Name</label>
                    <input type="text" class="form-control" id="enquiry-name" name="n[name]" placeholder="Full Name" required />
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-phone">
                        <i class="fa fa-phone-square fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Contact No
                    </label>
                    <input type="text" class="form-control" id="enquiry-phone" name="n[Phone Number]" placeholder="Contact No" required />
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="enquiry-email">
                        <i class="fa fa-envelope fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Email
                    </label>
                    <input type="email" class="form-control" name="n[email]" id="enquiry-email" placeholder="Email" required />
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half">
                    <label for="answerform">
                        <i class="fa fa-check fa-2x text-warning mr-1" style="color: #C88916 !important; font-size: 1.4em;"></i> Answer
                        <span class='captcha-text' style='background: #1A1A1A; color: #fff; padding: 5px 10px; border-radius: 4px; font-weight: bold; margin-left: 10px; display: inline-block; min-width: 60px; text-align: center;'>Loading...</span>
                    </label>
                    <input class="form-control" id="answerform" type="number" name="InquiryAnswer" placeholder="1 + 2 = ?" required>
                    <span class="borderBottom"></span>
                </div>

                <div class="form-group Half"><button type="submit" class="btn btn-block" style="height: 3rem;background-color:#C88916;border-color:#C88916;color:#fff;" name="submit" value="Send Message">Submit</button></div>
            </form>
        </div>
    </div>
</section>

<style>
    .featured-slick-carousel {
        margin-bottom: 40px !important;
        padding: 0;
        position: relative;
        display: flex;
    }

    .featured-slick-carousel:not(.slick-initialized) {
        flex-wrap: nowrap;
        overflow: hidden;
    }

    .featured-slick-carousel:not(.slick-initialized) .item {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }

    .featured-slick-carousel.slick-initialized {
        display: block;
        /* Allow overflow for the hover shadow and transformations */
        overflow: visible;
    }

    /* Add padding to the slick-list to contain the shadow/transform without clipping */
    .featured-slick-carousel .slick-list {
        padding: 20px 0 60px !important; /* Bottom padding for shadows and height */
        margin: -20px 0 -60px !important;
        overflow: visible !important;
        transition: height 0.3s ease;
    }

    .featured-slick-carousel .item {
        padding: 15px;
        height: auto !important;
    }

    .featured-slick-carousel .mainPackage {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 0;
        height: auto !important; /* Allow matchHeight to set the height */
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .featured-slick-carousel .mainPackage:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.18);
        position: relative;
        z-index: 10;
    }

    .featured-slick-carousel .mainPackageImage img {
        height: 17rem !important;
        object-fit: cover;
    }

    .featured-slick-carousel .slick-prev,
    .featured-slick-carousel .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 35px;
        height: 35px;
        background: rgba(61, 62, 66, 0.8) !important;
        border: none;
        border-radius: 50%;
        display: flex !important;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .featured-slick-carousel .slick-prev:hover,
    .featured-slick-carousel .slick-next:hover {
        background: #C88916 !important;
    }

    .featured-slick-carousel .slick-prev {
        left: 10px !important;
    }

    .featured-slick-carousel .slick-next {
        right: 10px !important;
    }

    .featured-slick-carousel .slick-prev i,
    .featured-slick-carousel .slick-next i {
        color: #fff;
        font-size: 14px;
    }

    .featured-slick-carousel .slick-dots {
        position: absolute;
        bottom: 58px; /* 2px below the cards (60px padding - 2px) */
        display: flex !important;
        justify-content: center;
        width: 100%;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .featured-slick-carousel .slick-dots li {
        margin: 0 5px;
    }

    .featured-slick-carousel .slick-dots li button {
        font-size: 0;
        width: 10px;
        height: 10px;
        background: #193670;
        border-radius: 50%;
        border: none;
        opacity: 0.2;
        padding: 0;
    }

    .featured-slick-carousel .slick-dots li.slick-active button {
        opacity: 1;
    }
</style>
<!--slider section End-->
<section class="featuredPackages">
    <div class="container">
        <div class="sectionMainHeading">
            <h2>
                <span>03 STAR Exclusive</span>
                Umrah Deals
            </h2>
            <p>Umrah Agency Pakistan Brings Affordable Packages with Nearby Hotels</p>
        </div>
        <div class="packagesCarousel">
            <div class="viewMore-carouselArrow">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="d-none"></h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('umrahPackages') }}" class="viewAll">View All</a>
                        <span class="owl-nav customNav featuredPackagesButton"></span>
                    </div>
                </div>
            </div>
            <div class="featuredPackagesUid featured-slick-carousel">
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-7-nights-umrah-package']) }}">
                                <img class="img-fluid" loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/19.png')}}" alt="3 Star 7 Nights Umrah Package">
                            </a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '3-star-7-nights-umrah-package']) }}">3 Star 7 Nights Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="3 Star 7 Nights Umrah Package Icon">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 180,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279"
                                    src="{{asset('assets/media/umrah-new/20.png')}}"
                                    alt="3 Star 10 Nights Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}">3 Star 10 Nights Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (5 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (5 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="3 Star 10 Nights Umrah Package Icon">
                                    <div class="icon-text">MADINA (5 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 200,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-12-nights-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279"
                                    src="{{asset('assets/media/umrah-new/21.png')}}"
                                    alt="3 Star 12 Nights Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '3-star-12-nights-umrah-package']) }}">3 Star 12 Nights Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (6 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (6 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="3 Star 12 Nights Umrah Package Icon">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 215,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '3-star-12-nights-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/22.png')}}"
                                    alt="3 Star 14 Nights Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}">3 Star 14 Nights Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="3 Star 14 Nights Umrah Package Icon">
                                    <div class="icon-text">MADINA (7 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 230,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="featuredPackages">
    <div class="container">

        <div class="sectionMainHeading">
            <h2>
                <span>04 STAR</span>
                Umrah Deals
            </h2>
            <p>Umrah Agency Pakistan Brings Affordable Packages with Nearby Hotels</p>
        </div>
        <div class="packagesCarousel">
            <div class="viewMore-carouselArrow">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="d-none"></h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('decemberUmrahPackages') }}" class="viewAll">View All</a>
                        <span class="owl-nav customNav featuredPackagesButton"></span>
                    </div>
                </div>
            </div>
            <div class="featuredPackagesUid featured-slick-carousel">
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-december-umrah-package']) }}"><img class="img-fluid" loading="lazy"
                                    width="336" height="279" src="{{asset('assets/media/umrah-new/23.png')}}"
                                    alt="4 Star 10 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-december-umrah-package']) }}">4 Star 10 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (4 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (4 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 10 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 255,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-night-december-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/24.png')}}"
                                    alt="4 Star 14 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-night-december-umrah-package']) }}">4 Star 14 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 14 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (7 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 300,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-night-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-7-nights-december-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/25.png')}}"
                                    alt="4 Star 7 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-7-nights-december-umrah-package']) }}">4 Star 7 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 7 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 235,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-7-nights-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-10-nights-december-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/26.png')}}"
                                    alt="4 Star 10 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-10-nights-december-umrah-package']) }}">4 Star 10 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (5 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (5 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 10 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (5 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 255,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-10-nights-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-12-nights-december-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/27.png')}}"
                                    alt="4 Star 12 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-12-nights-december-umrah-package']) }}">4 Star 12 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (6 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (6 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 12 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 275,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-12-nights-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '4-star-14-nights-december-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/28.png')}}"
                                    alt="4 Star 14 Nights December Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '4-star-14-nights-december-umrah-package']) }}">4 Star 14 Nights December Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg inactive" src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="4 Star 14 Nights December Umrah Package Icon">
                                    <div class="icon-text">MADINA (7 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 300,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '4-star-14-nights-december-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="featuredPackages">
    <div class="container">

        <div class="sectionMainHeading">
            <h2>
                <span>05 STAR</span>
                Umrah Deals
            </h2>
            <p>Umrah Agency Pakistan Brings Affordable Packages with Nearby hotels from Holy Haram and Masjid Al Nabwi</p>
        </div>
        <div class="packagesCarousel">
            <div class="viewMore-carouselArrow">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="d-none">7, 10, 14 Days Flash Deals</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="viewAll">View All</a>
                        <span class="owl-nav customNav featuredPackagesButton"></span>
                    </div>
                </div>
            </div>
            <div class="featuredPackagesUid featured-slick-carousel">
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '5-star-7-nights-economy-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/29.png')}}"
                                    alt="5 Star 7 Nights Economy Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '5-star-7-nights-economy-umrah-package']) }}">5 Star 7 Nights Economy Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="5 Star 7 Nights Economy Umrah Package Icon">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 330,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '5-star-7-nights-economy-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '10-nights-5-star-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/30.png')}}"
                                    alt="10 Nights 5 Star March Umrah package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '10-nights-5-star-umrah-package']) }}">10 Nights 5 Star March Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (5 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (5 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="10 Nights 5 Star March Umrah package Icon">
                                    <div class="icon-text">MADINA (5 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 380,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '10-nights-5-star-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '5-star-7-night-umrah-package']) }}"><img class="img-fluid" loading="lazy"
                                    width="336" height="279" src="{{asset('assets/media/umrah-new/13.png')}}"
                                    alt="5 star 7 night Umrah package "></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '5-star-7-night-umrah-package']) }}">5 Star 7 Night Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="5 star 7 night Umrah package Icon">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 350,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '5-star-7-night-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '7-nights-5-star-umrah-package']) }}"><img class="img-fluid" loading="lazy"
                                    width="336" height="279" src="{{asset('assets/media/umrah-new/27.png')}}"
                                    alt="7 Nights 5 Star March Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '7-nights-5-star-umrah-package']) }}">7 Nights 5 Star March Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="7 Nights 5 Star March Umrah Package Icon">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 350,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '7-nights-5-star-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '12-nights-5-star-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/3.png')}}"
                                    alt="12 Nights 5 Star March Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '12-nights-5-star-umrah-package']) }}">12 Nights 5 Star March Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (6 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (6 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="12 Nights 5 Star March Umrah Package Icon">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 410,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '12-nights-5-star-umrah-package']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '5-star-14-nights-family-umrah-package1']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279"
                                    src="{{asset('assets/media/umrah-new/4.png')}}"
                                    alt="5 Star 14 Nights Family Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('umrahDetail', ['slug' => '5-star-14-nights-family-umrah-package1']) }}">5 Star 14 Nights Family Umrah Package</a>
                                </p>
                                <div class="stars">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                    <img loading="lazy" width="16" height="16" class="svg " src="star.svg" alt="package star">
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS) AL KISWAH TOWER">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> AL KISWAH TOWER</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="5 Star 14 Nights Family Umrah Package Icon">
                                    <div class="icon-text">MADINA (7 NIGHTS) <br> EMAAR TAIBAH</div class="icon-text">
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 br-b d-flex justify-content-between px-4">
                                    <div class="fw-15"><i class="fa fa-file text-active"></i> VISA</div>
                                    <div class="fw-15"><i class="fa fa-plane text-active"></i> FLIGHTS</div>
                                    <div class="fw-15"><i class="fa fa-hotel text-active"></i> HOTELS</div>
                                    <div class="fw-15"><i class="fa fa-taxi text-active"></i> TRANSFERS</div>
                                </div>
                            </div>
                            <div class="row py-2 px-4">
                                <div class="col-12 d-flex justify-content-between px-4">
                                    <span class="price">PKR 440,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('umrahDetail', ['slug' => '5-star-14-nights-family-umrah-package1']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--featured Umrah Agency Pakistan packages section End-->
<!-- Home page content section starts here  -->




<div class="page-content">
    <div class="container">
        <div class="scroll-page-content page-content-styling">

            <h2>Umrah Agency Pakistan: Your Trusted Hajj and Umrah Travel Agency in Pakistan</h2>
            <p>Welcome to Your Trusted Hajj and Umrah Travel Agency. Planning for Hajj or Umrah is a spiritually enriching journey, but it can also be complex and overwhelming. At our Hajj and Umrah Travel Agency, we aim to make your pilgrimage seamless, comfortable, and memorable. Based in Pakistan, we specialize in providing comprehensive packages tailored to your spiritual, logistical, and financial needs.</p>
            <p>With years of experience and a dedicated team of professionals, we ensure that your journey to the holy cities of Makkah and Madinah is guided by trust, expertise, and devotion. Our commitment is not just to arrange travel; it is to serve as your companion throughout this sacred journey.</p>

            <h2>Why Choose Our Hajj and Umrah Services</h2>
            <p>Choosing the right Hajj and Umrah Travel Agency is critical for a hassle-free pilgrimage. Our agency in Pakistan focuses on excellence, ensuring that every aspect of your journey, from visas to accommodation, is taken care of.</p>
            <h3>Experienced and Trusted Team</h3>
            <p>Our team comprises experts who have extensive experience in arranging Hajj and Umrah trips. We understand the intricacies of visa applications, flight schedules, and the sacred rituals of Hajj and Umrah. By trusting us, you gain a partner who ensures your journey is spiritually fulfilling and logistically smooth.</p>
            <h3>Comprehensive Travel Packages</h3>
            <p>We offer a wide range of packages suitable for every budget and requirement:</p>
            <ul>
                <li><strong>Hajj Packages:</strong> Our Hajj packages are designed to cater to the diverse needs of pilgrims from Pakistan. From economy to premium accommodations, we provide services that cover visas, flights, transport, and guided religious support.</li>
                <li><strong>Umrah Packages:</strong> Whether you are planning a short spiritual trip or an extended stay in the holy cities, our <a href="{{ route('umrahPackages') }}">Umrah packages</a> offer flexibility, affordability, and comfort.</li>
                <li><strong>Customized Packages:</strong> For families, groups, or individuals with specific needs, we provide personalized itineraries that prioritize your convenience and spiritual experience.</li>
            </ul>

            <h2>Seamless Visa and Travel Assistance</h2>
            <p>Navigating the visa process can be challenging. Our agency simplifies it by offering complete guidance and assistance, ensuring your documentation and approvals are handled efficiently. We work closely with Saudi authorities to make your Hajj and Umrah visa process smooth and timely.</p>

            <h2>Comfortable Accommodation</h2>
            <p>We understand the importance of rest and convenience during your pilgrimage. Our packages include accommodations near the Holy Kaaba in Makkah and the Prophet’s Mosque in Madinah. We partner with trusted hotels and guest houses to provide clean, safe, and accessible lodging.</p>

            <h2>Our Hajj Packages</h2>
            <p>Our Hajj services are specifically tailored for pilgrims from Pakistan, ensuring that your sacred journey is organized, comfortable, and spiritually rewarding.</p>
            <h3>Key Features of Our Hajj Packages</h3>
            <ul>
                <li>Visa Assistance: Complete support for Hajj visa application and approval.</li>
                <li>Flights from Pakistan: Convenient flights from major cities including Karachi, Lahore, Islamabad, and Multan.</li>
                <li>Accommodation: Stay in hotels with proximity to Haram Sharif in Makkah and Madinah.</li>
                <li>Local Transport: Comfortable and safe transportation for all Hajj rituals.</li>
                <li>Guided Services: Experienced guides to help with the rituals and navigation in the holy cities.</li>
                <li>Health & Safety: Medical assistance and insurance for all pilgrims.</li>
            </ul>
            <h3>Types of Hajj Packages</h3>
            <ul>
                <li>Economy Hajj Package: Affordable option with all essential services.</li>
                <li>Standard Hajj Package: Balanced package with moderate luxury and convenience.</li>
                <li>Premium Hajj Package: High-end services including 5-star accommodations and exclusive transportation.</li>
            </ul>

            <h2>Our Umrah Packages</h2>
            <p>Performing Umrah is a spiritual journey that can be undertaken at any time of the year. Our Umrah packages from Pakistan are designed to provide flexibility, convenience, and comfort.</p>
            <h3>Key Features of Our Umrah Packages</h3>
            <ul>
                <li>Flexible Dates: Travel at any time of the year, suitable for your schedule.</li>
                <li>Visa Assistance: Efficient processing of Umrah visas for Pakistani citizens.</li>
                <li>Flight Bookings: Direct and connecting flights from all major Pakistani cities.</li>
                <li>Accommodation Near Haram: Stay close to the Holy Kaaba and the Prophet’s Mosque for easy access.</li>
                <li>Guided Umrah: Assistance with Umrah rituals and religious guidance.</li>
                <li>Affordable Rates: Packages tailored to meet your budget without compromising quality.</li>
            </ul>
            <h3>Types of Umrah Packages</h3>
            <ul>
                <li>Short Umrah Package: 7-10 days for those with limited time.</li>
                <li>Extended Umrah Package: 14-21 days for deeper spiritual experience.</li>
                <li>Family Umrah Package: Special arrangements for families and senior pilgrims.</li>
            </ul>

            <h2>Spiritual Guidance and Support</h2>
            <p>At our Hajj and Umrah Travel Agency, we believe that a pilgrimage is not just a journey, but a life-changing spiritual experience. Our team provides comprehensive religious guidance to help pilgrims:</p>
            <ul>
                <li>Perform rituals correctly and with understanding.</li>
                <li>Understand the significance of each Hajj and Umrah ritual.</li>
                <li>Maintain spiritual focus throughout the journey.</li>
                <li>Receive continuous support for any religious or logistical queries.</li>
            </ul>
            <p>We also provide printed and digital guides, including maps of Makkah and Madinah, prayer schedules, and ritual checklists, so you can focus entirely on your spiritual experience.</p>

            <h2>Why Hajj and Umrah from Pakistan is Special</h2>
            <p>Pakistan has a strong tradition of sending pilgrims to the holy cities every year. Our agency ensures that pilgrims from Pakistan receive:</p>
            <ul>
                <li>Localized Support: Assistance in Urdu and regional languages.</li>
                <li>Community Networking: Connect with fellow Pakistani pilgrims for support and companionship.</li>
                <li>Custom Itineraries: Packages designed considering travel preferences and cultural needs of Pakistani pilgrims.</li>
            </ul>
            <p>Our services focus on creating an environment where Pakistani pilgrims feel comfortable, supported, and spiritually fulfilled during their Hajj or Umrah journey.</p>

            <h2>Travel Tips for Pilgrims</h2>
            <p>Preparing for Hajj or Umrah requires careful planning. Here are some essential tips:</p>
            <ul>
                <li>Early Booking: Ensure your package is booked well in advance to secure flights and accommodations.</li>
                <li>Documentation: Keep all necessary documents, including passports, visas, and vaccination certificates ready.</li>
                <li>Health Preparation: Consult your doctor, carry medications, and stay hydrated.</li>
                <li>Travel Light: Pack essential clothing, religious items, and personal care products.</li>
                <li>Spiritual Preparation: Learn the rituals, du’as, and prayers to maximize your spiritual experience.</li>
            </ul>
            <p>Our agency provides detailed pre-travel guidance sessions to help pilgrims prepare mentally, physically, and spiritually for their journey.</p>

            <h2>Testimonials from Our Pilgrims</h2>
            <p>We take pride in serving thousands of pilgrims from Pakistan every year. Here’s what some of our travelers have to say:</p>
            <ul>
                <li>“The entire Hajj journey was seamless, thanks to the dedicated team of this agency. From visa processing to accommodation, everything was perfect.” – Ahmed R., Karachi</li>
                <li>“Our Umrah trip was spiritually uplifting. The guides were knowledgeable, and the services were outstanding.” – Fatima S., Lahore</li>
                <li>“I felt completely supported throughout my pilgrimage. The agency took care of every detail, allowing me to focus on my worship.” – Bilal M., Islamabad</li>
            </ul>
            <p>These testimonials reflect our commitment to providing a trustworthy and reliable Hajj and Umrah travel service in Pakistan.</p>

            <h2>Booking Your Hajj and Umrah Package</h2>
            <p>Booking with our Hajj and Umrah Travel Agency is simple and transparent. Follow these steps:</p>
            <ol>
                <li>Select Your Package: Choose from our range of Hajj or Umrah packages.</li>
                <li>Consult Our Team: Discuss your preferences and special requirements.</li>
                <li>Complete Documentation: Submit passport, visa application, and other necessary forms.</li>
                <li>Confirm Booking: Receive confirmation of flights, accommodation, and itinerary.</li>
                <li>Prepare for Travel: Attend pre-travel guidance sessions for a smooth journey.</li>
            </ol>
            <p>We aim to make the process stress-free, ensuring that your focus remains on your spiritual preparation and worship.</p>

            <h2>Commitment to Excellence</h2>
            <p>Our agency is driven by a mission to provide exceptional Hajj and Umrah services in Pakistan. Our core values include:</p>
            <ul>
                <li><strong>Integrity:</strong> Transparent and ethical dealings with every pilgrim.</li>
                <li><strong>Reliability:</strong> On-time services and meticulous planning for every journey.</li>
                <li><strong>Comfort:</strong> Focused on providing safe, clean, and convenient accommodations.</li>
                <li><strong>Spiritual Guidance:</strong> Dedicated support to enhance the religious experience.</li>
            </ul>
            <p>We continuously improve our services based on feedback from pilgrims to ensure every journey is better than the last.</p>

            <h2>Contact Us</h2>
            <p>Ready to embark on your spiritual journey? Contact our Hajj and Umrah Travel Agency in Pakistan today:</p>
            <ul>
                <li><strong>Phone:</strong> +92-XXX-XXXXXXX</li>
                <li><strong>Email:</strong> <a href="mailto:info@umrahagency.pk">info@umrahagency.pk</a></li>
                <li><strong>Office Locations:</strong> ………………….</li>
            </ul>
            <p>Our friendly and knowledgeable team is ready to answer your queries and help you plan your sacred journey with ease.</p>

            <h2>Frequently Asked Questions (FAQs)</h2>
            <p><strong>Q1: When is the best time to perform Hajj?</strong><br>
            A: Hajj is performed during the Islamic month of Dhu al-Hijjah. It is essential to plan well in advance due to high demand for flights and accommodations.</p>
            <p><strong>Q2: Can I perform Umrah any time of the year?</strong><br>
            A: Yes, Umrah can be performed throughout the year, except during Hajj season.</p>
            <p><strong>Q3: Are your packages suitable for families and senior citizens?</strong><br>
            A: Absolutely. We offer tailored packages to meet the needs of families, elderly pilgrims, and individuals requiring special assistance.</p>
            <p><strong>Q4: What is included in your Hajj package?</strong><br>
            A: Our Hajj package typically includes visa assistance, flights, accommodations, local transport, guided services, and spiritual support.</p>
            <p><strong>Q5: How do I prepare for Hajj or Umrah spiritually?</strong><br>
            A: We provide guidance on rituals, prayers, and preparation to ensure a meaningful spiritual journey.</p>

            <h2>Final Thoughts</h2>
            <p>Embarking on Hajj or Umrah is a profound spiritual journey. Choosing the right Hajj and Umrah Travel Agency in Pakistan ensures that your pilgrimage is not only seamless but also spiritually fulfilling. Our agency is dedicated to offering top-notch services, personalized support, and a memorable pilgrimage experience.</p>
            <p>With our experienced team, comprehensive packages, and unwavering commitment to your comfort and spiritual needs, we aim to make your journey to the holy cities of Makkah and Madinah truly transformative.</p>
            <p><strong>Start your sacred journey today. Let our agency be your trusted companion in this life-changing spiritual adventure.</strong></p>

        </div>
    </div>
</div>
<!-- Home page content section ends here  -->
@endsection
@push('scripts')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        function initFeaturedSlider() {
            if (window.jQuery && $.fn.slick && $.fn.matchHeight) {
                $('.featured-slick-carousel').each(function() {
                    var $carousel = $(this);
                    if (!$carousel.hasClass('slick-initialized')) {
                        
                        // Equalize heights before slider init to avoid layout shifts
                        $carousel.find('.mainPackage').matchHeight();

                        $carousel.on('init reInit setPosition', function() {
                            // Re-trigger height equalization on slider updates
                            $(this).find('.mainPackage').matchHeight();
                        });

                        $carousel.slick({
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            arrows: true,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 3000,
                            adaptiveHeight: false,
                            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                            responsive: [{
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 991,
                                    settings: {
                                        slidesToShow: 2
                                    }
                                },
                                {
                                    breakpoint: 767,
                                    settings: {
                                        slidesToShow: 1,
                                        arrows: false
                                    }
                                }
                            ]
                        });
                    }
                });
            } else {
                setTimeout(initFeaturedSlider, 50);
            }
        }
        
        initFeaturedSlider();
        
        // Re-calculate after images are likely loaded
        window.addEventListener('load', function() {
            $('.mainPackage').matchHeight();
            if (window.jQuery && $.fn.slick) {
                $('.featured-slick-carousel').slick('setPosition');
            }
        });
    });
</script>

@endpush