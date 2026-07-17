    <footer class="footer">
        <div class="container">
            <div class="footerDesc">
                <div class="row">
                    <div class="col-md-12 col-lg-3 col-xl-4">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img loading="lazy" class="logo img-responsive" src="{{asset('assets/images/logo.png')}}" alt="Umrah Agency Pakistan"></a>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="col-md-4"> -->
                        <ul class="socialLinks d-flex p-0">
                            <li>
                                <a rel="nofollow" target="_blank" href="https://www.facebook.com/umrahagency">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/facebook.png')}}"
                                        alt="Facebook">
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" target="_blank" href="https://twitter.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/twitter.png')}}"
                                        alt="Twitter">
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" target="_blank" href="https://www.pinterest.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/pinterest.png')}}"
                                        alt="Pinterest">
                                </a>
                            </li>
                            <li>
                                <a rel="nofollow" target="_blank" href="https://www.instagram.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/instagram.png')}}"
                                        alt="Instagram">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2">
                        <div class="footer-data">
                            <h5>Quick Links</h5>
                            <ul>
                                <li><a href="{{ route('aboutUs') }}">About Us</a></li>
                                <li><a href="{{ route('contactUs') }}">Contact Us</a></li>
                                <li><a href="{{ route('reviews') }}">Reviews</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2">
                        <div class="footer-data">
                            <h5>Our Terms</h5>

                            <ul>
                                <li><a href="{{ route('termsConditions') }}">Terms &amp; Conditions</a></li>
                                <li><a href="{{ route('privacyPolicy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('paymentSecurity') }}">Payment Security</a></li>
                                <li><a href="{{ route('cookiesPolicy') }}">Cookies Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-2">
                        <div class="footer-data getInTouch">
                            <h5>Get in Touch</h5>
                            <ul>
                                <li><a href="mailto:info@umrahagency.pk">info@umrahagency.pk</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2">
                        <div class="footer-data">
                            <h5>Contact Info</h5>
                            <ul class="list-unstyled footer-contact-info">
                                <li class="mb-3 d-flex align-items-start text-white">
                                    <i class="fa fa-map-marker mr-3 mt-1 text-warning"></i>
                                    <span>Doctor Hospital Johar Town Lahore</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fa fa-phone mr-3 text-warning"></i>
                                    <a href="tel:03251212747" class="text-white">03251212747</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footerCopyright">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <p>
                        <p>All rights reserved Umrah Agency Pakistan&nbsp;&copy; 2020- 2026</p>

                        <p>All the flight-inclusive holidays on this website are financially protected by the ATOL
                            scheme. When you pay you will be supplied with an ATOL Certificate. Please ask for it and
                            check to ensure that everything you booked (flights, hotels and other services) is listed on
                            it. If you do receive an ATOL Certificate but all the parts of your trip are not listed on
                            it, those parts will not be ATOL protected. Some of the flights on this website are also
                            financially protected by the ATOL scheme, but ATOL protection does not apply to all flights.
                            This website will provide you with information on the protection that applies in the case of
                            each flight before you make your booking. If you do not receive an ATOL Certificate then the
                            booking will not be ATOL protected. Please see our booking conditions for information, or
                            for more information about financial protection and under working ATOL protection.</p>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <ul class="socialLinks d-none">
                            <li>
                                <a href="https://www.facebook.com/umrahagency">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/facebook.png')}}"
                                        alt="Facebook">
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/twitter.png')}}"
                                        alt="Twitter">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/pinterest.png')}}"
                                        alt="Pinterest">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/umrahagency/">
                                    <img loading="lazy" height="20" width="100" src="{{asset('assets/userfiles/files/instagram.png')}}"
                                        alt="Instagram">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <div class="modal fade enquiryModal" id="EnqModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>


                    <div class="searchEngine" id="packageInquiry">
                        <div class="searchFields">
                            <form class="form" method="post" action="">

                                <div class="form-group Half">
                                    <label for="fromform"><img loading="lazy" width="21" height="21"
                                            src="{{asset('assets/images/haditours-imgs-updated/from.png')}}" alt="Departure Airport">
                                        Departure Airport</label>
                                    <select class="form-control" name="n[From]" id="fromform" required>
                                        <option value=""></option>
                                        <option value="Aberdeen (ABZ)">Aberdeen (ABZ)</option>
                                        <option value="Amsterdam (AMS)">Amsterdam (AMS)</option>
                                        <option value="Belfast Intl (BFS)">Belfast Intl (BFS)</option>
                                        <option value="Birmingham (BHX)">Birmingham (BHX)</option>
                                        <option value="Bristol (BRS)">Bristol (BRS)</option>
                                        <option value="Cardiff (CWL)">Cardiff (CWL)</option>
                                        <option value="Dublin (DUB)">Dublin (DUB)</option>
                                        <option value="Eindhoven (EIN)">Eindhoven (EIN)</option>
                                        <option value="Glasgow (GLA)">Glasgow (GLA)</option>
                                        <option value="London (LON)">London (LON)</option>
                                        <option value="London Gatwick (LGW)">London Gatwick (LGW)</option>
                                        <option value="London Heathrow (LHR)">London Heathrow (LHR)</option>
                                        <option value="Manchester (MAN)">Manchester (MAN)</option>
                                        <option value="Newcastle (NCL)">Newcastle (NCL)</option>
                                        <option value="Rotterdam The Hague (RTM)">Rotterdam The Hague (RTM)</option>
                                    </select>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group Half">
                                    <label for="toform"><img loading="lazy" width="26" height="21"
                                            src="{{asset('assets/images/haditours-imgs-updated/to.png')}}" alt="Arrival Airport">
                                        Arrival Airport</label>
                                    <select class="form-control" name="n[To]" id="toform" required>
                                        <option value=""></option>
                                        <option value="Jeddah">Jeddah</option>
                                        <option value="Dammam">Dammam</option>
                                        <option value="Abha">Abha</option>
                                        <option value="Yanbu">Yanbu</option>
                                        <option value="Taif">Taif</option>
                                        <option value="Riyadh">Riyadh</option>
                                    </select>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group Half">
                                    <!--<input class="form-control MaintoDate" type="text" name="depart_date" placeholder="Dates" required>-->
                                    <label for="dateform"><img loading="lazy" width="21" height="21"
                                            src="{{asset('assets/images/haditours-imgs-updated/calender.png')}}" alt="Date">
                                        Date</label>
                                    <input class="form-control DepartureDate" id="dateform" name="n[Departure Date]"
                                        type="text" readonly required>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group Half">
                                    <!--<input class="form-control" type="text" name="phone" placeholder="Phone" required>-->
                                    <label for="Phoneform"><img loading="lazy" width="22" height="18"
                                            src="{{asset('assets/images/haditours-imgs-updated/phone.png')}}" alt="Phone Number"> Phone
                                        Number</label>
                                    <input class="form-control" id="Phoneform" name="n[Phone Number]" type="text"
                                        required>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group Half">
                                    <!--<input class="form-control" type="text" name="email" placeholder="Email" required>-->
                                    <label for="emailform"><img loading="lazy" width="22" height="16"
                                            src="{{asset('assets/images/haditours-imgs-updated/email.png')}}" alt="Email Address"> Email
                                        Address</label>
                                    <input class="form-control" name="n[Email]" id="emailform" type="email" required>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group nights">
                                    <div class="form-group threeQuater">
                                        <label for="nightform"><img loading="lazy" width="17" height="19"
                                                src="{{asset('assets/images/haditours-imgs-updated/moon.png')}}" alt="Nights">
                                            Nights</label>
                                        <select class="form-control" id="nightform" name="n[makkah_nights]">
                                            <option value="">MAK</option>
                                            <option value="1">MAK 1</option>
                                            <option value="2">MAK 2</option>
                                            <option value="3">MAK 3</option>
                                            <option value="4">MAK 4</option>
                                            <option value="5">MAK 5</option>
                                            <option value="6">MAK 6</option>
                                            <option value="7">MAK 7</option>
                                            <option value="8">MAK 8</option>
                                            <option value="9">MAK 9</option>
                                            <option value="10">MAK 10</option>
                                        </select>
                                        <span class="borderBottom"></span>
                                    </div>
                                    <div class="form-group Quater">
                                        <label for="nightform1"><img loading="lazy" width="17" height="19"
                                                src="{{asset('assets/images/haditours-imgs-updated/moon.png')}}" alt="Nights">
                                            Nights</label>
                                        <select class="form-control" id="nightform1" name="n[madinah_nights]">
                                            <option value="">MED</option>
                                            <option value="1">MED 1</option>
                                            <option value="2">MED 2</option>
                                            <option value="3">MED 3</option>
                                            <option value="4">MED 4</option>
                                            <option value="5">MED 5</option>
                                            <option value="6">MED 6</option>
                                            <option value="7">MED 7</option>
                                            <option value="8">MED 8</option>
                                            <option value="9">MED 9</option>
                                            <option value="10">MED 10</option>
                                        </select>
                                        <span class="borderBottom"></span>
                                    </div>
                                </div>

                                <div class="form-group Half">
                                    <label for="roomform"><img loading="lazy" width="22" height="16"
                                            src="{{asset('assets/images/haditours-imgs-updated/rooms.png')}}" alt="Rooms"> Rooms</label>
                                    <select class="form-control" id="roomform" name="n[room]">
                                        <option value=""></option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Triple">Triple</option>
                                        <option value="Quad">Quad</option>
                                    </select>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group passenger-contain Half">
                                    <label for="count-pass"><img loading="lazy" width="21" height="20"
                                            src="{{asset('assets/images/haditours-imgs-updated/travellers.png')}}" alt="Travellers">
                                        Travellers</label>
                                    <div class="input-group-main">
                                        <div class="input-group">
                                            <input class="form-control select inputValue PassengersField"
                                                id="count-pass" type="text" data-bs-toggle="collapse" placeholder=""
                                                data-bs-target=".beat-passenger-dropdown" required>

                                        </div>
                                    </div>
                                    <div class="passenger-dropdown beat-passenger-dropdown collapse">
                                        <div class="form-group mt-0">
                                            <label for="adult_p">Adults [+12]</label>
                                            <div class="input-group passenger adult-pass">
                                                <button class="btn  minus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/minus.png')}}" alt="minus">
                                                </button>
                                                <input class="form-control passengerInput totalAdult" type="number"
                                                    placeholder="Adults" min="0" max="10" name="n[Adults]" value="1"
                                                    id="adult_p" selected>
                                                <button class="btn  plus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/plus.png')}}" alt="plus">
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="child_p">Children [2 to 12]</label>
                                            <div class="input-group passenger child-pass">
                                                <button class="btn  minus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/minus.png')}}" alt="minus">
                                                </button>
                                                <input id="child_p" class="form-control passengerInput totalChild"
                                                    type="number" placeholder="Childs" min="0" max="10" name="n[Childs]"
                                                    value="0" selected>
                                                <button class="btn  plus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/plus.png')}}" alt="plus">
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2 mb-2">
                                            <label for="infant_p">Infants [0 to 2]</label>
                                            <div class="input-group passenger infant-pass">
                                                <button class="btn  minus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/minus.png')}}" alt="minus">
                                                </button>
                                                <input id="infant_p" class="form-control passengerInput totalInfant"
                                                    type="number" placeholder="Infants" min="0" max="10"
                                                    name="n[Infants]" value="0" selected>
                                                <button class="btn  plus" type="button">
                                                    <img loading="lazy" width="12" height="12" class="img-fluid"
                                                        src="{{asset('assets/images/haditours-imgs-updated/plus.png')}}" alt="plus">
                                                </button>
                                            </div>
                                        </div>
                                        <button class="btn general-btn btn-block" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target=".passenger-dropdown">Select</button>
                                    </div>
                                </div>

                                <div class="form-group Answer  Half">
                                    <label for="answerform"><img loading="lazy" width="20" height="15"
                                            src="{{asset('assets/images/haditours-imgs-updated/checkanswer.png')}}" alt="">
                                        Answer <span class='captcha-text' style='background: #1A1A1A; color: #fff; padding: 5px 10px; border-radius: 4px; font-weight: bold; margin-left: 10px; display: inline-block; min-width: 60px; text-align: center;'>Loading...</span></label>
                        <input class="form-control" id="answerform" type="number" name="InquiryAnswer"
                                        required>
                                    <span class="borderBottom"></span>
                                </div>

                                <div class="form-group Half">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit"
                                        value="Send Message">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


