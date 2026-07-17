@extends('layouts.master')
@section('meta')
<title>Ramazan Umrah Packages 2026 from Pakistan | Best Deals</title>
<meta name="description" content="Book Ramazan Umrah packages from Pakistan at affordable prices. All-inclusive deals with flights, hotels, visa & transport for a blessed spiritual journey.">
@endsection

@verbatim
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "@id": "https://umrahagency.pk/ramadan-umrah-packages.html#ramadanumrah2026",
        "name": "Ramadan Umrah Packages 2026 from Pakistan",
        "url": "https://umrahagency.pk/ramadan-umrah-packages.html",
        "description": "Explore a range of all-inclusive Ramadan Umrah packages 2026 from Pakistan with Umrah Agency Pakistan, offering 3-star stay options with flights, Umrah visas, hotels in Makkah & Madinah, and transfers. Choose from multiple night durations to suit your travel plans during the blessed month of Ramadan.",
        "provider": {
            "@type": "TravelAgency",
            "@id": "https://umrahagency.pk/#travelagency",
            "name": "Umrah Agency Pakistan",
            "url": "https://umrahagency.pk/"
        },
        "serviceType": "Ramadan Umrah Packages 2026",
        "areaServed": {
            "@type": "Country",
            "name": "Pakistan"
        },
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Ramadan Umrah Packages 2026",
            "@id": "https://umrahagency.pk/ramadan-umrah-packages.html#catalog",
            "itemListElement": [{
                    "@type": "AggregateOffer",
                    "name": "3-Star 7 Nights Ramadan Umrah Package 2026",
                    "url": "https://umrahagency.pk/ramadan-umrah-packages.html#3star7",
                    "description": "3-star Ramadan Umrah Package 2026: 3 nights in Makkah and 4 nights in Madinah with flights, visa, hotel and transfers included.",
                    "priceCurrency": "PKR",
                    "lowPrice": 225000,
                    "highPrice": 225000,
                    "offerCount": 1,
                    "availability": "https://schema.org/InStock",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "3-Star 7 Nights Ramadan Umrah Package 2026"
                    }
                },
                {
                    "@type": "AggregateOffer",
                    "name": "3-Star 10 Nights Ramadan Umrah Package 2026",
                    "url": "https://umrahagency.pk/ramadan-umrah-packages.html#3star10",
                    "description": "3-star Ramadan Umrah Package 2026: 5 nights in Makkah and 5 nights in Madinah with flights, visa, hotel and transfers included.",
                    "priceCurrency": "PKR",
                    "lowPrice": 245000,
                    "highPrice": 245000,
                    "offerCount": 1,
                    "availability": "https://schema.org/InStock",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "3-Star 10 Nights Ramadan Umrah Package 2026"
                    }
                },
                {
                    "@type": "AggregateOffer",
                    "name": "3-Star 12 Nights Ramadan Umrah Package 2026",
                    "url": "https://umrahagency.pk/ramadan-umrah-packages.html#3star12",
                    "description": "3-star Ramadan Umrah Package 2026: 6 nights in Makkah and 6 nights in Madinah with flights, visa, hotel and transfers included.",
                    "priceCurrency": "PKR",
                    "lowPrice": 265000,
                    "highPrice": 265000,
                    "offerCount": 1,
                    "availability": "https://schema.org/InStock",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "3-Star 12 Nights Ramadan Umrah Package 2026"
                    }
                },
                {
                    "@type": "AggregateOffer",
                    "name": "3-Star 14 Nights Ramadan Umrah Package 2026",
                    "url": "https://umrahagency.pk/ramadan-umrah-packages.html#3star14",
                    "description": "3-star Ramadan Umrah Package 2026: 7 nights in Makkah and 7 nights in Madinah with flights, visa, hotel and transfers included.",
                    "priceCurrency": "PKR",
                    "lowPrice": 285000,
                    "highPrice": 285000,
                    "offerCount": 1,
                    "availability": "https://schema.org/InStock",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "3-Star 14 Nights Ramadan Umrah Package 2026"
                    }
                }
            ]
        }
    }
</script>
@endverbatim



@section('content')
<section class="search-banner">
    <!--slider section Start-->
    <div class="banner">
        <img src="{{asset('assets/media/pages/home-page-banner-for-haditours-1.png')}}" class="img-fluid" alt="Ramadan Umrah Packages Banner - Umrah Agency Pakistan">
        <div class="banner-text">
            <h1>Ramazan Umrah Packages</h1>
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
<!--slider section End-->
<div class="page-content">

    <div class="container">

        <p>
    </div>
</div>
<section class="featuredPackages">
    <div class="container">

        <div class="packagesCarousel">
            <div class="sectionMainHeading">
                <h2>All-inclusive Ramadan Umrah packages</h2>
            </div>
            <div class="featuredPackagesUid featured-slick-carousel">
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-7-nights-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279"
                                    src="{{asset('assets/media/umrah-new/24.png')}}"
                                    alt="3 Star 7 Nights Ramadan Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title"><a href="{{ route('umrahDetail', ['slug' => '3-star-7-nights-umrah-package']) }}">3 Star 7 Nights Ramadan Umrah Package</a></p>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (3 NIGHTS)">
                                    <div class="icon-text">Makkah (3 NIGHTS) <br> AL KISWAH TOWER</div>
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (4 NIGHTS)">
                                    <div class="icon-text">MADINA (4 NIGHTS) <br> EMAAR TAIBAH</div>
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
                                    <span class="price">PKR 225,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage"
                                        href="{{ route('umrahDetail', ['slug' => '3-star-7-nights-umrah-package']) }}">View Details</a>
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
                                    src="{{asset('assets/media/umrah/00-min%20%2827%29.webp')}}"
                                    alt="3 Star 10 Nights Ramadan Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title"><a href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}">3 Star 10 Nights Ramadan Umrah Package</a></p>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (5 NIGHTS)">
                                    <div class="icon-text">Makkah (5 NIGHTS) <br> AL KISWAH TOWER</div>
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (5 NIGHTS)">
                                    <div class="icon-text">MADINA (5 NIGHTS) <br> EMAAR TAIBAH</div>
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
                                    <span class="price">PKR 245,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage"
                                        href="{{ route('umrahDetail', ['slug' => '3-star-10-nights-umrah-package']) }}">View Details</a>
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
                                    src="{{asset('assets/media/umrah/00-min%20%2828%29.webp')}}"
                                    alt="3 Star 12 Nights Ramadan Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title"><a href="{{ route('umrahDetail', ['slug' => '3-star-12-nights-umrah-package']) }}">3 Star 12 Nights Ramadan Umrah Package</a></p>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (6 NIGHTS)">
                                    <div class="icon-text">Makkah (6 NIGHTS) <br> AL KISWAH TOWER</div>
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (6 NIGHTS)">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> EMAAR TAIBAH</div>
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
                                    <span class="price">PKR 265,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage"
                                        href="{{ route('umrahDetail', ['slug' => '3-star-12-nights-umrah-package']) }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279"
                                    src="{{asset('assets/media/umrah-new/23.png')}}"
                                    alt="3 Star 14 Nights Ramadan Umrah Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title"><a href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}">3 Star 14 Nights Ramadan Umrah Package</a></p>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS)">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> AL KISWAH TOWER</div>
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (7 NIGHTS)">
                                    <div class="icon-text">MADINA (7 NIGHTS) <br> EMAAR TAIBAH</div>
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
                                    <span class="price">PKR 285,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage"
                                        href="{{ route('umrahDetail', ['slug' => '3-star-14-nights-umrah-package']) }}">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<style>
    .featured-slick-carousel {
        position: relative;
        padding-bottom: 50px;
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
        bottom: 0px;
    }

    .featured-slick-carousel .slick-dots li button:before {
        font-size: 12px;
        color: #C88916;
        opacity: 0.3;
    }

    .featured-slick-carousel .slick-dots li.slick-active button:before {
        color: #C88916;
        opacity: 1;
    }

    .mainPackage {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 10px;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .mainPackage:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .mainPackageImage img {
        height: 17rem;
        object-fit: cover;
        width: 100%;
    }

    .mainPackageDesc {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
</style>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        function initFeaturedSlider() {
            if (window.jQuery && $.fn.slick) {
                $('.featured-slick-carousel').each(function() {
                    $(this).slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: true,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        infinite: true,
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
                });
            } else {
                setTimeout(initFeaturedSlider, 50);
            }
        }
        initFeaturedSlider();
    });
</script>
@endpush
<div class="page-content">
    <div class="container scroll-page-content page-content-styling">

        <h2>Ramadan Umrah Packages – A Blessed Journey in the Holiest Month</h2>

        <p>Ramadan is the most sacred and spiritually rewarding time of the year for Muslims around the world. Performing Umrah during this holy month holds immense significance, as it is believed to carry the reward equal to Hajj (in spiritual value). For this reason, thousands of pilgrims from Pakistan eagerly plan their journey and search for the best Ramadan Umrah packages every year.</p>

        <p>This is not just a journey—it is a chance to purify the soul, seek forgiveness, and strengthen your connection with Allah in the most blessed environment. Whether you are looking for affordable Ramadan Umrah packages, considering cheap Ramadan <a href="{{ route('umrahPackages') }}">Umrah packages</a>, or aiming to choose the best Ramadan Umrah packages, understanding the importance and planning properly is essential.</p>

        <h3>Why Perform Umrah in Ramadan?</h3>

        <p>Umrah in Ramadan holds a unique spiritual status that makes it different from any other time of the year. The atmosphere in Makkah and Madinah becomes deeply spiritual, filled with prayers, recitation of the Quran, and a strong sense of unity among Muslims.</p>

        <p>During Ramadan, every act of worship carries multiplied rewards. From fasting throughout the day to offering Taraweeh prayers at night, the entire environment encourages worship and reflection. Performing Umrah in such a powerful spiritual setting allows pilgrims to fully immerse themselves in faith and devotion.</p>

        <p>For many people, this journey becomes a life-changing experience that brings peace, clarity, and a renewed sense of purpose.</p>

        <h3>Affordable Ramadan Umrah Packages – Planning with Balance</h3>

        <p>Due to high demand, traveling in Ramadan can be more expensive compared to other months. However, many travelers still search for affordable Ramadan Umrah packages to manage their budget effectively.</p>

        <p>Affordability during Ramadan depends on early planning, flexible travel dates, and making informed decisions. Travelers who book in advance often get better availability and reasonable pricing compared to last-minute bookings.</p>

        <p>An affordable Ramadan Umrah package focuses on providing essential services while maintaining a balance between cost and comfort. The key is to choose wisely and ensure that all arrangements are reliable and transparent.</p>

        <h3>Cheap Ramadan Umrah Packages – What You Should Know</h3>

        <p>Searching for cheap Ramadan Umrah packages is common, especially among those who want to perform Umrah without putting too much pressure on their finances. However, it is important to approach this carefully.</p>

        <p>A lower price should not mean compromising on essential aspects such as accommodation quality, visa processing, or transport arrangements. Even budget-friendly options should be well-organized and reliable.</p>

        <p>Pilgrims should always verify details, confirm inclusions, and ensure there are no hidden costs. A well-planned cheap Ramadan Umrah package can still provide a smooth and spiritually fulfilling experience if chosen correctly.</p>

        <h3>Best Ramadan Umrah Packages – Comfort During Peak Season</h3>

        <p>For those who want a more comfortable and stress-free experience, selecting from the best Ramadan Umrah packages can make a significant difference. Ramadan is a peak season, and the number of pilgrims increases dramatically, especially during the last Ashra.</p>

        <p>Choosing a well-organized travel plan helps reduce the challenges that come with large crowds. Convenience becomes especially important when it comes to accommodation, transport, and accessibility to Haram.</p>

        <p>The goal is to create an environment where you can focus on worship without being overwhelmed by logistical difficulties. Comfort and proper planning enhance the overall experience and allow you to benefit fully from the blessings of Ramadan.</p>

        <h3>The Importance of the Last Ashra</h3>

        <p>The last ten days of Ramadan, known as the last Ashra, are considered the most spiritually powerful days of the entire month. Many pilgrims specifically plan their Umrah during this period to seek Laylat al-Qadr, the Night of Power.</p>

        <p>During these days, the atmosphere in Makkah becomes even more intense, with continuous prayers, recitation, and worship taking place throughout the night. It is a time of deep reflection and devotion.</p>

        <p>However, it is also the busiest period, which means planning becomes even more critical. Early preparation and proper arrangements can help ensure that pilgrims make the most of this sacred time.</p>

        <h3>Travel Challenges During Ramadan</h3>

        <p>While Ramadan offers unmatched spiritual benefits, it also comes with certain challenges that travelers should be aware of. The increased number of pilgrims means that flights, hotels, and transport services are in high demand.</p>

        <p>Crowds around Haram can be significant, especially during Iftar and Taraweeh times. Managing time effectively and staying patient becomes an important part of the journey.</p>

        <p>Understanding these factors in advance helps pilgrims prepare mentally and practically, ensuring that they can handle the environment with ease and focus on their worship.</p>

        <h3>Ramadan Umrah with Family</h3>

        <p>Many families choose Ramadan as the time to perform Umrah together, making it a shared spiritual experience. Traveling with family during this month requires additional planning to ensure comfort and coordination.</p>

        <p>Families often prioritize convenience, especially when it comes to accommodation and accessibility. Having everything well-organized allows all members to participate in worship without unnecessary stress.</p>

        <p>For elderly family members, extra care should be taken to ensure ease of movement and proper rest. When managed properly, a family Umrah in Ramadan becomes a deeply meaningful and memorable experience.</p>

        <h3>Flexibility and Personal Planning</h3>

        <p>Every traveler has different needs, especially during Ramadan. Some may prefer to travel in the early part of the month, while others specifically aim for the last Ashra.</p>

        <p>Flexibility in travel planning allows pilgrims to choose the timing and arrangements that best suit their preferences. Whether it is a shorter stay or a longer spiritual retreat, having control over these decisions improves the overall experience.</p>

        <p>Understanding your priorities and planning accordingly ensures that your journey aligns with your spiritual goals.</p>

        <h3>A Journey of Spiritual Transformation</h3>

        <p>Performing Umrah in Ramadan is more than just a religious obligation—it is a journey of transformation. The experience of fasting, praying, and standing before the Kaaba in the holiest month creates a deep emotional and spiritual connection.</p>

        <p>The peaceful environment, combined with the blessings of Ramadan, allows pilgrims to reflect on their lives, seek forgiveness, and renew their faith. It is an opportunity to leave behind worldly worries and focus entirely on worship.</p>

        <p>For many, this journey becomes one of the most important and memorable experiences of their lives.</p>

        <h3>Final Thoughts</h3>

        <p>Every year, thousands of pilgrims search for Ramadan Umrah packages to fulfill their spiritual goals during the holiest month. Whether you are considering affordable Ramadan Umrah packages, exploring cheap Ramadan Umrah packages, or looking for the best Ramadan Umrah packages, careful planning is essential.</p>

        <p>Booking early, understanding your needs, and choosing reliable arrangements can make a significant difference in your overall experience. With the right preparation, you can ensure a smooth journey that allows you to fully benefit from the blessings of Ramadan.</p>

        <p>Umrah in Ramadan is a rare and beautiful opportunity—one that should be planned with care and performed with sincerity.</p>

        <h3>Frequently Asked Questions (FAQs)</h3>

        <p><strong>What are Ramadan Umrah packages?</strong><br>
        Ramadan Umrah packages are travel arrangements designed for pilgrims who want to perform Umrah during the holy month of Ramadan.</p>

        <p><strong>Why is Umrah in Ramadan special?</strong><br>
        Umrah in Ramadan holds great spiritual significance and is considered highly rewarding compared to other times of the year.</p>

        <p><strong>Are affordable Ramadan Umrah packages available?</strong><br>
        Yes, affordable Ramadan Umrah packages are available, especially with early booking and flexible planning.</p>

        <p><strong>What is included in cheap Ramadan Umrah packages?</strong><br>
        Cheap Ramadan Umrah packages usually include visa, flights, accommodation, and basic transport services.</p>

        <p><strong>When should I book Ramadan Umrah packages?</strong><br>
        It is recommended to book several months in advance due to high demand, especially for the last Ashra.</p>

        <p><strong>Which is the best time in Ramadan for Umrah?</strong><br>
        The last Ashra is considered the most spiritually rewarding time, although it is also the busiest period.</p>

    </div>
</div>

@endsection