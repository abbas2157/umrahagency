@extends('layouts.master')
@section('meta')
<title>Contact Us | Umrah Agency Pakistan - Plan Your Spiritual Hajj & Umrah Journey</title>
<meta name="description" content="Get in touch with Umrah Agency Pakistan for personalized Hajj and Umrah packages. Visit our Pakistan office, call us at 03251212747, or email info@umrahagency.pk.">
@endsection
@section('content')
<div class="pkg-header-top text-center">
    <div class="container">
        <h1>Contact Us</h1>
        <p class="lead text-muted">We're here to help you plan your spiritual journey</p>
    </div>
</div>

<section class="main-content-area py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="section-card h-100">
                    <div class="section-title mb-4">
                        <i class="fa fa-map-marker mr-3"></i> Get in Touch
                    </div>

                    <div class="contact-methods">
                        <div class="d-flex mb-4">
                            <div class="icon-box mr-3">
                                <i class="fa fa-phone fa-lg text-warning"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Phone Number</h6>
                                <p class="mb-0"><a href="tel:03251212747" class="text-dark">03251212747</a></p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="icon-box mr-3">
                                <i class="fa fa-envelope fa-lg text-warning"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Email Address</h6>
                                <p class="mb-0"><a href="mailto:info@umrahagency.pk" class="text-dark">info@umrahagency.pk</a></p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="icon-box mr-3">
                                <i class="fa fa-map-marker fa-lg text-warning"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Office Address</h6>
                                <p class="mb-0 text-dark">Doctor Hospital Johar Town Lahore</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 bg-light-cream rounded border">
                        <h6 class="font-weight-bold mb-2 uppercase small text-muted">About Our Services</h6>
                        <p class="small text-justify mb-0">Umrah Agency Pakistan is a trusted Hajj and Umrah travel agency in Pakistan. We offer all-inclusive Umrah packages for families, groups, and individuals. Our team is dedicated to providing you with the best spiritual experience.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="section-card">
                    <div class="section-title mb-4">
                        <i class="fa fa-paper-plane mr-3"></i> Send a Message
                    </div>

                    <form class="form" method="post" action="{{ route('sendInquiry') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Your Name *</label>
                                    <input class="form-control" type="text" name="n[name]" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Email Address *</label>
                                    <input class="form-control" type="email" name="n[email]" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Phone Number</label>
                                    <input class="form-control" type="text" name="n[Phone Number]" placeholder="Enter contact number">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Subject</label>
                                    <input class="form-control" type="text" name="n[subject]" placeholder="How can we help?">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Message *</label>
                                    <textarea name="message" class="form-control" style="min-height: 120px;" placeholder="Tell us more about your inquiry" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label class="small font-weight-bold">What is <span class="captcha-text">...</span>? *</label>
                                    <div class="d-flex">
                                        <input class="form-control" type="number" name="InquiryAnswer" placeholder="Answer" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-warning btn-block py-3 font-weight-bold rounded-pill text-uppercase shadow-sm" type="submit">
                                    <i class="fa fa-paper-plane mr-2"></i> Send Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection