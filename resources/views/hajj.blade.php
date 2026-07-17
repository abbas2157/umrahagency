@extends('layouts.master')
@section('meta')
<title>Hajj Packages Pakistan 2026</title>
<meta name="description" content="Affordable Hajj packages from Pakistan with complete arrangements—flights, visa, hotels & transport. Book early for best availability and prices.">
<link rel="canonical" href="https://umrahagency.pk/hajj-packages.html" />
@endsection
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "@id": "https://umrahagency.pk/hajj-packages.html#hajj2026",
  "name": "Hajj Packages 2026 from Pakistan",
  "url": "https://umrahagency.pk/hajj-packages.html",
  "description": "Explore comprehensive Hajj Packages 2026 from Pakistan with Umrah Agency Pakistan. Choose from economy, standard and deluxe options including flights, Saudi Hajj visa assistance, hotel accommodation near Makkah and Madinah, transportation, guided support and full on-ground services for the sacred Hajj pilgrimage.",
  "provider": {
    "@type": "TravelAgency",
    "@id": "https://umrahagency.pk/#travelagency",
    "name": "Umrah Agency Pakistan",
    "url": "https://umrahagency.pk/"
  },
  "serviceType": "Hajj Packages 2026",
  "areaServed": {
    "@type": "Country",
    "name": "Pakistan"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Hajj Packages 2026",
    "@id": "https://umrahagency.pk/hajj-packages.html#catalog",
    "itemListElement": [
      {
        "@type": "AggregateOffer",
        "name": "Economy Hajj Package 2026",
        "url": "https://umrahagency.pk/hajj-packages.html#economy",
        "description": "Economy Hajj package 2026 from Pakistan including flights, visa, accommodation in standard hotels in Makkah and Madinah, tent services in Mina and Arafat, and transfers.",
        "priceCurrency": "PKR",
        "lowPrice": 1500000,
        "highPrice": 1650000,
        "offerCount": 3,
        "availability": "https://schema.org/InStock",
        "itemOffered": {
          "@type": "Service",
          "name": "Economy Hajj Package 2026"
        }
      },
      {
        "@type": "AggregateOffer",
        "name": "Standard Hajj Package 2026",
        "description": "Standard Hajj package 2026 from Pakistan with mid-range hotel accommodation, flights, Hajj visa support and guided transfers throughout the pilgrimage.",
        "priceCurrency": "PKR",
        "lowPrice": 1700000,
        "highPrice": 1950000,
        "offerCount": 3,
        "availability": "https://schema.org/InStock",
        "itemOffered": {
          "@type": "Service",
          "name": "Standard Hajj Package 2026"
        }
      },
      {
        "@type": "AggregateOffer",
        "name": "Deluxe/Super Deluxe Hajj Package 2026",
        "description": "Deluxe and Super Deluxe Hajj packages 2026 from Pakistan featuring premium hotel stays near the Haram, flights, Saudi Hajj visa, private transport, full service support and optional VIP amenities.",
        "priceCurrency": "PKR",
        "lowPrice": 2100000,
        "highPrice": 2500000,
        "offerCount": 2,
        "availability": "https://schema.org/InStock",
        "itemOffered": {
          "@type": "Service",
          "name": "Deluxe Hajj Package 2026"
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
        <img src="{{asset('assets/media/pages/home-page-banner-for-haditours-1.png')}}" class="img-fluid" alt="Hajj Packages Banner - Umrah Agency Pakistan" width="1920" height="600" fetchpriority="high">
        <div class="banner-text">
            <h1>Trusted Hajj and Umrah Travel Agency</h1>
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
                        <option value="Lahore">Lahore</option>
                        <option value="Karachi">Karachi</option>
                        <option value="Islamabad">Islamabad</option>
                        <option value="Multan">Multan</option>
                        <option value="Sialkot">Sialkot</option>
                        <option value="Faisalabad">Faisalabad</option>
                        <option value="Peshawar">Peshawar</option>
                        <option value="Quetta">Quetta</option>
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
<style>
    .viewMainPackage {
        font-weight: 700;
        font-size: 15px !important;
    }
</style>
<div class="page-content">
    <div class="container">
        <p style="text-align: justify;">
    </div>
</div>
<section class="hajjPackages">
    <div class="container">
        <div class="packagesCarousel">
            <div class="viewMore-carouselArrow">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2></h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="viewAll">view all</a>
                        <span class="owl-nav customNav featuredPackagesButton"></span>
                    </div>
                </div>
            </div>
            <div id="hajjPackages" class="featuredPackagesUid featured-slick-carousel">
                <div class="item">
                    <div class="mainPackage">
                        <div class="mainPackageImage">
                            <a href="{{ route('hajjDetail', ['slug' => '4-weeks-hajj-package-non-shifting']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/hajj/hajj_kaaba_pilgrims.png')}}"
                                    alt="4 Weeks Hajj Package (Non Shifting)"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('hajjDetail', ['slug' => '4-weeks-hajj-package-non-shifting']) }}">4 Weeks Hajj Package (Non Shifting)</a>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (10 NIGHTS)">
                                    <div class="icon-text">Makkah (10 NIGHTS) <br> LAMAR HOTEL</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (6 NIGHTS)">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> MILLENIUM TAIBAH</div class="icon-text">
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
                                    <span class="price">PKR 1,500,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('hajjDetail', ['slug' => '4-weeks-hajj-package-non-shifting']) }}">
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
                            <a href="{{ route('hajjDetail', ['slug' => '2-3-weeks-non-shifting-hajj-package']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/18.png')}}"
                                    alt="2-3 Weeks Non Shifting Hajj Package"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('hajjDetail', ['slug' => '2-3-weeks-non-shifting-hajj-package']) }}">2-3 Weeks Non Shifting Hajj Package</a>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS)">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> LAMAR HOTEL</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (3-4 NIGHTS)">
                                    <div class="icon-text">MADINA (3-4 NIGHTS) <br> MUBARAK AL MASI</div class="icon-text">
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
                                    <span class="price">PKR 1,650,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('hajjDetail', ['slug' => '2-3-weeks-non-shifting-hajj-package']) }}">
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
                            <a href="{{ route('hajjDetail', ['slug' => '2-3-weeks-hajj-package-non-shifting']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/umrah-new/19.png')}}"
                                    alt="2-3 Weeks Hajj Package (Non Shifting)"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('hajjDetail', ['slug' => '2-3-weeks-hajj-package-non-shifting']) }}">2-3 Weeks Hajj Package (Non Shifting)</a>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (7 NIGHTS)">
                                    <div class="icon-text">Makkah (7 NIGHTS) <br> LAMAR HOTEL</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (3-4 NIGHTS)">
                                    <div class="icon-text">MADINA (3-4 NIGHTS) <br> MUBARAK AL MASI</div class="icon-text">
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
                                    <span class="price">PKR 1,800,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('hajjDetail', ['slug' => '2-3-weeks-hajj-package-non-shifting']) }}">
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
                            <a href="{{ route('hajjDetail', ['slug' => '5-star-hajj-package-non-shifting']) }}"><img class="img-fluid"
                                    loading="lazy" width="336" height="279" src="{{asset('assets/media/hajj/hajj_ritual_pilgrims.png')}}"
                                    alt="5 Star Hajj Package (non-shifting)"></a>
                        </div>
                        <div class="mainPackageDesc">
                            <div class="package-heading">
                                <p class="title">
                                    <a href="{{ route('hajjDetail', ['slug' => '5-star-hajj-package-non-shifting']) }}">5 Star Hajj Package (non-shifting)</a>
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
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/kaaba.webp')}}" alt="Makkah (10 NIGHTS)">
                                    <div class="icon-text">Makkah (10 NIGHTS) <br> LAMAR HOTEL</div class="icon-text">
                                </div>
                                <div class="col-6 d-flex">
                                    <img class="icon" loading="lazy" src="{{asset('assets/images/masjid-al-nabawi.webp')}}" alt="Madinah (6 NIGHTS)">
                                    <div class="icon-text">MADINA (6 NIGHTS) <br> MILLENIUM TAIBAH</div class="icon-text">
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
                                    <span class="price">PKR 2,100,000 <sub>/ pp</sub></span>
                                    <a class="viewMainPackage" href="{{ route('hajjDetail', ['slug' => '5-star-hajj-package-non-shifting']) }}">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="page-content">
    <div class="container scroll-page-content page-content-styling">
        </p>

        <h2>Understanding the Importance of Hajj</h2>

        <p>The Hajj pilgrimage is a significant religious journey for Muslims worldwide. It&#39;s not just a visit;
            it&#39;s an important spiritual experience that holds great value in a Muslim&#39;s life.</p>

        <h3>Spiritual Importance</h3>

        <p>Hajj is the highest form of worship and shows a Muslim&#39;s dedication to their faith. During Hajj,
            Muslims ask for forgiveness, renew their faith, and feel spiritually cleansed. They perform rituals like
            walking around the Kaaba (Tawaf) and walking between the hills of Safa and Marwah (Sa&#39;i) to show
            their devotion and connection with God, following the example of the Prophet Muhammad (PBUH).</p>

        <h3>Historical Background</h3>

        <p>The pilgrimage has its roots in the early days of Islam, going back to the Prophet Ibrahim and his
            family. It remembers important events, like Ibrahim&#39;s readiness to sacrifice his son Ismail and
            Hagar&#39;s search for water, which led to the discovery of the Zamzam well. These stories teach
            important lessons about faith and trusting God in all matters.</p>

        <h3>Symbol of Unity and Equality</h3>

        <p>Moreover, Hajj shows brotherhood and equality among Muslims. No matter where they come from or their
            social status, all pilgrims wear simple white clothes called Ihram, which emphasises that everyone is
            equal before God. This creates a strong sense of brotherhood as millions of Muslims from different
            backgrounds come together.</p>

        <h3>Religious Duty</h3>

        <p>Lastly, Hajj is one of the Five Pillars of Islam, which must be followed to complete faith. It is
            required for all Muslims who can go both financially and physically. Completing Hajj fulfils this vital
            duty and shows a Muslim&#39;s commitment to their faith.</p>

        <h2 style="text-align: justify;">Hajj Packages 2026</h2>

        <p style="text-align: justify;">&quot;Hajj&quot; is a sacred term for all Muslims, and the desire to visit
            not only the House of God but also the places where His beloved Prophet (PBUH) lived and
            spent time is the craving of all belonging to the religion Islam. It was one of the five pillars of
            Islam which are declared mandatory for those Muslims who are financially stable to pay the visit. Umrah Agency Pakistan offers cheap Hajj packages in 2026, which are not only economical but also reasonable in terms
            of providing the best Hajj packages. These best hajj packages include providing visa services, flight,
            Qurbani, Hotel stay, transport, and Hajj draft. Affordable hajj packages are every Muslim’s
            desire. Those looking for affordable Hajj packages will be very pleased to know that Umrah Agency Pakistan is
            offering the following exciting and cheap Hajj packages for 2026:</p>

        <h2 style="text-align: justify;">Amazing and affordable Hajj Packages 2026 for Muslim Community</h2>

        <p style="text-align: justify;"><strong>3 weeks 5 star best Hajj package</strong></p>

        <p style="text-align: justify;">Umrah Agency Pakistan brings the best Hajj package for the Muslim community
            residing in Pakistan to perform this holy obligation with comfort and ease. Around 70,000 believers travel
            in intention to pay a visit to God’s House, Umrah Agency Pakistan travel becomes a luxurious bridge between
            the faithful and their Creator.<br />
            Umrah Agency Pakistan offers 3 weeks 5-star cheap Hajj packages present following privileged stays at the
            below-mentioned venues:</p>

        <ul>
            <li style="text-align: justify;">Makkah Hotel nights (Lamar Hotel)</li>
            <li style="text-align: justify;">Madinah Hotel nights (Millenium Taiba Madinah)</li>
            <li style="text-align: justify;">Mina tents</li>
            <li style="text-align: justify;">Arafat tents</li>
        </ul>

        <p style="text-align: justify;">More specifically, the cheap Hajj package includes 10 nights in Makkah, 6
            nights in Madinah, 3 nights in the tents of Mina, and 3 nights in the tents of Arafat.</p>

        <h2 style="text-align: justify;">Affordable and best Hajj Package for our Valued Citizens</h2>

        <p style="text-align: justify;"><strong>4 Weeks non-shifting best Hajj packages</strong></p>

        <p style="text-align: justify;">We value our customers’ comfort and holy needs, presenting another
            package among the cheap Hajj packages 2026, which is not only the best Hajj package in terms of the way
            it facilitates but is also affordable to the majority of our valued citizens of Pakistan. This is a
            complete month, a non-shifting package which is providing the opportunity to the residents of Pakistan to
            pay a visit to the Holy cities of Makkah and Madinah and have visits of sacred places like
            Mina, Arafat, etc. Missing this amazing opportunity to avail of these affordable hajj packages will not
            be a wise decision to make. So don’t think twice and make use of this holy month of Hajj out of
            these affordable Hajj packages.<br />
            This exciting 4 weeks non-shifting best packages primarily offer to stay at the following places:</p>

        <ul>
            <li style="text-align: justify;">Makkah Hotel nights (Lamar Hotel)</li>
            <li style="text-align: justify;">Madinah Hotel nights (Millenium Taiba Madinah)</li>
            <li style="text-align: justify;">Mina tents</li>
            <li style="text-align: justify;">Arafat tents</li>
        </ul>

        <h3 style="text-align: justify;">Economical and affordable Hajj packages for desiring Muslims</h3>

        <p style="text-align: justify;"><strong>2-3 Weeks non-shifting best hajj packages</strong></p>

        <p style="text-align: justify;">In this age, each one of us is looking towards tasks to be completed
            economically, Umrah Agency Pakistan presents its customers in Pakistan with cheap and affordable Hajj packages
            for all those desiring to perform this sacred religious obligation. So don’t think twice and avail
            of this low-cost and reasonable offer and pay a visit to the House of God this year.</p>

        <p style="text-align: justify;">2-3 weeks non-shifting cheap Hajj packages cover stay at the following
            desirable places:</p>

        <ul>
            <li style="text-align: justify;">Makkah Hotel nights (Lamar Hotel)</li>
            <li style="text-align: justify;">Madinah Hotel Nights (Mubarak Al Masi)</li>
            <li style="text-align: justify;">Mina tents</li>
            <li style="text-align: justify;">Arafat tents</li>
        </ul>

        <p style="text-align: justify;">These are the affordable Hajj packages as they are designed by our
            professional planners and are not only cheap Hajj packages but are also the best Hajj packages.</p>

        <h2>The Logistics and Rituals of Hajj</h2>

        <p>Now that you know all about our packages, it&#39;s time to understand the essentials of a Hajj
            pilgrimage. Going on the Hajj pilgrimage requires a lot of planning and understanding of the necessary
            steps and rituals. It is one of the biggest annual gatherings in the world, so it&#39;s essential to
            prepare well to have a smooth and fulfilling experience.</p>

        <h3>Getting Ready for Hajj: Key Steps</h3>

        <ul>
            <li><strong>Visa and Documents:</strong> First, you need to get a Hajj visa. This is possible with a
                recognised travel agency like <a href="https://umrahagency.pk/">Umrah Agency Pakistan</a>. Make
                sure you have all the necessary paperwork, such as a current passport, medical certificates, and
                vaccination records, especially for meningitis and COVID-19.</li>
            <li><strong>Flights and Hotels:</strong> It&#39;s best to book your flights and hotels early because
                demand is high during the Hajj season. But with Umrah Agency Pakistan, there&#39;s no need for concern. As soon as you
                book a package, we will arrange your return flights and hotels near the holy sites.</li>
            <li><strong>Health and Safety:</strong> Lastly, your health is very important during Hajj. Have a
                thorough medical check-up prior to departing, and remember to stay hydrated. Also, bring a basic
                medical kit with medications for common illnesses and personal prescriptions.</li>
        </ul>

        <h3>Rituals of Hajj</h3>

        <ul>
            <li><strong>Ihram:</strong> The first step of the Hajj is to put on the Ihram, a holy garment of purity.
                Men wear simple white clothes, while women cover themselves with loose clothes.</li>
            <li><strong>Tawaf and Sa&#39;i: </strong>Tawaf is circling the Kaaba seven times in a counterclockwise
                direction. Afterwards, Sa&#39;i involves walking seven times between the hills of Safa and Marwah.</li>
            <li><strong>Standing at Arafat: </strong>The Day of Arafat, when pilgrims assemble on the plains of
                Arafat to pray from noon to dusk, is the most significant day of the Hajj.</li>
            <li><strong>Muzdalifah: </strong>After Arafat, pilgrims go to Muzdalifah to gather stones for the Rami
                ritual.</li>
            <li><strong>Rami al-Jamarat:</strong> Rami involves throwing stones at three pillars in Mina to
                represent rejecting evil.</li>
            <li><strong>Qurbani (Animal Sacrifice):</strong> Pilgrims perform the sacrifice of an animal, usually a
                sheep or goat, to remember Ibrahim&#39;s willingness to sacrifice his son for God.</li>
            <li><strong>Halq or Taqsir:</strong> Male pilgrims shave their heads (Halq), while female pilgrims trim
                a portion of their hair (Taqsir), symbolising a fresh start and the shedding of past sins.</li>
            <li><strong>Tawaf al-Wida:</strong> The final ritual is Tawaf al-Wida, the farewell circling around the
                Kaaba.</li>
        </ul>

        <h3>FAQs</h3>

        <h4>What are the dates of Hajj?</h4>

        <p>Every year, the dates of the Hajj are different. However, in the Islamic calendar, it occurs from the 8th
            to the 13th of Dhul Hijjah.</p>

        <h4>How early should I book to get a good price and availability of Hajj packages?</h4>

        <p>It is best to book Hajj packages well in advance, almost six to twelve months before the pilgrimage.</p>

        <h4>Can I customise my Hajj package?</h4>

        <p>Yes, we always offer travellers the option to customise the Hajj package. Changes can be made to the
            hotels, flight classes, and package durations.</p>

        <h4>Are there any health risks during Hajj?</h4>

        <p>Because of the huge crowds and physical activities, pilgrims may face health problems. The most common
            issues include dehydration and heatstrokes. So, it&#39;s advisable to have a water bottle on you at all
            times.</p>

    </div>
</div>
@endsection

@push('scripts')
<style>
    .featured-slick-carousel {
        margin-bottom: 80px !important;
        /* Increased for better gap */
        padding: 0;
        position: relative;
        /* Prevent vertical stacking before initialization */
        display: flex;
    }

    .featured-slick-carousel:not(.slick-initialized) {
        flex-wrap: nowrap;
        overflow: hidden;
        /* Only hide overflow before init */
    }

    .featured-slick-carousel:not(.slick-initialized) .item {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }

    @media (max-width: 1100px) {
        .featured-slick-carousel:not(.slick-initialized) .item {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 768px) {
        .featured-slick-carousel:not(.slick-initialized) .item {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    .featured-slick-carousel.slick-initialized {
        display: block;
        overflow: visible;
        /* Ensure dots are visible */
    }

    .featured-slick-carousel .item {
        padding: 10px;
        /* Restored slightly more padding */
    }

    /* Increase card height components */
    .featured-slick-carousel .mainPackageImage {
        min-height: auto !important;
    }

    .featured-slick-carousel .mainPackageImage img {
        height: 17rem !important;
        /* Increased from 14rem */
        object-fit: cover;
    }

    .featured-slick-carousel .mainPackageDesc .package-heading {
        padding: 8px 15px !important;
    }

    .featured-slick-carousel .mainPackageDesc .package-heading p.title {
        font-size: 15px !important;
        line-height: 1.2;
    }

    .featured-slick-carousel .mainPackageDesc .row.p-3 {
        padding: 10px !important;
    }

    .featured-slick-carousel .mainPackageDesc .icon-text {
        font-size: 11px !important;
        line-height: 1.2;
    }

    .featured-slick-carousel .mainPackageDesc .row.py-2.px-4 {
        padding: 5px 15px !important;
    }

    .featured-slick-carousel .mainPackageDesc .viewMainPackage {
        padding: 6px 12px !important;
        font-size: 12px !important;
    }

    .featured-slick-carousel .mainPackageDesc .price {
        font-size: 24px !important;
    }

    .featured-slick-carousel .slick-prev,
    .featured-slick-carousel .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 35px;
        /* Slightly smaller arrows */
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
        bottom: -45px;
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        function initFeaturedSlider() {
            if (window.jQuery && $.fn.slick) {
                $('.featured-slick-carousel').each(function() {
                    if (!$(this).hasClass('slick-initialized')) {
                        $(this).slick({
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            arrows: true,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            /* 2s delay as requested */
                            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                            responsive: [{
                                    breakpoint: 1300,
                                    settings: {
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 1100,
                                    settings: {
                                        slidesToShow: 2
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 1
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
    });
</script>
@endpush