@extends('layouts.master')
@section('meta')
<title>Customer Reviews | Umrah Agency Pakistan</title>
<meta name="description" content="Read reviews from our spiritual travelers who performed Umrah with Umrah Agency Pakistan. We offer all-inclusive Umrah packages from major cities in Pakistan.">
@endsection
@section('content')
<div class="pkg-header-top text-center">
    <div class="container">
        <h1>Customer Reviews</h1>
        <p class="lead text-muted">What our spiritual travelers say about their journey with Umrah Agency Pakistan</p>
    </div>
</div>

<section class="main-content-area py-5">
    <div class="container">
        <div class="row">
            <!-- Review Summary & Form Trigger -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="section-card text-center h-100">
                    <div class="section-title mb-4">
                        <i class="fa fa-star mr-2"></i> Share Your Experience
                    </div>
                    <div class="mb-4">
                        <div class="h2 font-weight-bold text-dark mb-1">4.9 / 5.00</div>
                        <div class="stars mb-3">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                        </div>
                        <p class="small text-muted">Based on 500+ verified customer reviews</p>
                    </div>
                    <button class="btn btn-warning btn-block py-3 font-weight-bold rounded-pill text-uppercase shadow-sm" type="button" data-toggle="collapse" data-target=".collapse-review">
                        <i class="fa fa-pencil mr-2"></i> Write a Review
                    </button>

                    <div class="mt-5 p-4 bg-light-cream rounded border text-left">
                        <h6 class="font-weight-bold mb-2 small text-muted text-uppercase">Trusted by Thousands</h6>
                        <p class="small text-justify mb-0">Umrah Agency Pakistan is dedicated to providing an exceptional Umrah experience. Your feedback helps us maintain our high standards of service for all pilgrims.</p>
                    </div>
                </div>
            </div>

            <!-- Review Content Area -->
            <div class="col-lg-8">
                <!-- Review Form -->
                <div class="review-form collapse collapse-review mb-5">
                    <div class="section-card border-warning shadow">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="font-weight-bold mb-0">Submit Your Review</h4>
                            <button class="btn btn-sm btn-outline-dark rounded-circle" type="button" data-toggle="collapse" data-target=".collapse-review">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>

                        <form method="post" class="form" action="#">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Full Name *</label>
                                        <input class="form-control" type="text" name="n[fullname]" placeholder="Enter your name" required>
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
                                        <label class="small font-weight-bold">Booking Reference *</label>
                                        <input class="form-control" type="text" name="n[bookingrefrence]" placeholder="e.g. HT-123456" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="small font-weight-bold mb-2 d-block">Overall Rating</label>
                                        <fieldset class="rating">
                                            <input type="radio" id="star5" name="n[reviewstars]" value="5" checked><label class="full" for="star5" title="5 stars"></label>
                                            <input type="radio" id="star4" name="n[reviewstars]" value="4"><label class="full" for="star4" title="4 stars"></label>
                                            <input type="radio" id="star3" name="n[reviewstars]" value="3"><label class="full" for="star3" title="3 stars"></label>
                                            <input type="radio" id="star2" name="n[reviewstars]" value="2"><label class="full" for="star2" title="2 stars"></label>
                                            <input type="radio" id="star1" name="n[reviewstars]" value="1"><label class="full" for="star1" title="1 star"></label>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Review Message *</label>
                                        <textarea class="form-control" name="n[review]" rows="5" placeholder="Tell us about your trip..." required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-7 mb-4">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">What is <span class="captcha-text">...</span>? *</label>
                                        <input class="form-control" type="number" name="ReviewAnswer" placeholder="Answer" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="privacy-check" name="policy_check" required>
                                        <label class="custom-control-label small text-muted" for="privacy-check">
                                            By checking this box, you agree to our <a href="{{ route('termsConditions') }}" class="text-warning">Terms & Conditions</a> and <a href="{{ route('privacyPolicy') }}" class="text-warning">Privacy Policy</a>.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-warning px-5 py-2 font-weight-bold rounded-pill text-uppercase" type="submit">
                                        Post Review
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Existing Reviews -->
                <div class="review-list">
                    @php
                    $sample_reviews = [
                    ['name' => 'Sultana Sameer', 'img' => 'testimonial-image.webp', 'stars' => 4, 'text' => 'I booked my Umrah package with Umrah Agency Pakistan and performed Umrah in April 2018. Staying at the Fairmont Royal Clock Tower was amazing, just minutes from Masjid Al Haram gate number 1.'],
                    ['name' => 'Saika Khan', 'img' => 'testimonial-image3.webp', 'stars' => 3, 'text' => 'Jazakallah for everything you did to make our journey amazing. The service was fantastic, transport was bang on time. Will definitely use your company again!'],
                    ['name' => 'Ismael Peerally', 'img' => 'testimonial-image2%20%281%29.webp', 'stars' => 4, 'text' => 'The experience with Umrah Agency Pakistan was absolutely seamless. From the flight bookings to the hotel stays in both Makkah and Madinah, everything was handled with care.'],
                    ['name' => 'Iqbal Husain', 'img' => 'image.jpg', 'stars' => 5, 'text' => 'I booked my Umrah in April 2023. The entire experience was truly unforgettable. I highly recommend Umrah Agency Pakistan to anyone looking to make this spiritual journey.']
                    ];
                    @endphp

                    @foreach($sample_reviews as $review)
                    <div class="section-card mb-4 p-4 shadow-sm hover-up border-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="review-avatar mr-3">
                                <img width="60" height="60" class="rounded-circle border" src="{{ asset('assets/media/reviews/' . $review['img']) }}" alt="{{ $review['name'] }}">
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0 text-dark">{{ $review['name'] }} <i class="fa fa-check-circle text-success small ml-1" title="Verified Traveler"></i></h6>
                                <div class="stars small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $review['stars'] ? 'text-warning' : 'text-muted opacity-2' }}"></i>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 text-justify text-muted italic">"{{ $review['text'] }}"</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection