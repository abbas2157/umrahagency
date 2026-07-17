    <section class="search-banner">
        <!--slider section Start-->
        <div class="banner">
            <img src="{{asset('assets/media/pages/home-page-banner-for-haditours-1.png')}}" class="img-fluid" alt="Home Page Banner - Umrah Agency Pakistan">
            <div class="banner-text">
                <h1>Trusted Umrah Agency&nbsp;in Pakistan</h1>
                <h4>For Umrah Services</h4>
                </h4>
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
                            <i class="fa fa-calendar fa-2x text-warning mr-1"   style="color: #C88916 !important; font-size: 1.4em;"></i> Departure Date
                        </label>
                        <input type="text" id="enquiry-departuredate" name="n[Departure Date]" class="DepartureDate form-control" readonly placeholder="Departure Date" required/>
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


