@extends('layouts.app')


@section('content')




    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-12 mx-auto">
                    <h1 class="text-white text-center">Discover. Learn. Enjoy</h1>

                    <h6 class="text-center">platform for creatives around the world</h6>
                </div>

            </div>
        </div>
    </section>


 <section class="featured-section">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                 <div class="custom-block bg-white shadow-lg">
                     <a href="#section_2">
                         <div class="d-flex">
                             <div>
                                 <h5 class="mb-2">Private Workspaces</h5>
                                 <p class="mb-0">Enjoy focused work in our private desks and study pods designed for productivity and concentration.</p>
                             </div>
                             <span class="badge bg-design rounded-pill ms-auto">New</span>
                         </div>
                         <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt="">
                     </a>
                 </div>
             </div>

             <div class="col-lg-6 col-12">
                 <div class="custom-block custom-block-overlay">
                     <div class="d-flex flex-column h-100">
                         <img src="images/businesswoman-using-tablet-analysis.jpg" class="custom-block-image img-fluid" alt="">

                         <div class="custom-block-overlay-text d-flex">
                             <div>
                                 <h5 class="text-white mb-2">Corporate Solutions</h5>
                                 <p class="text-white">Our corporate packages offer flexible workspace solutions for teams of all sizes. Enjoy premium amenities, meeting rooms, and collaborative spaces designed to boost productivity.</p>
                                 <a href="#section_2" class="btn custom-btn mt-2 mt-lg-3">View Plans</a>
                             </div>
                             <span class="badge bg-finance rounded-pill ms-auto">Popular</span>
                         </div>

                         <div class="social-share d-flex">
                             <p class="text-white me-4">Share:</p>
                             <ul class="social-icon">
                                 <li class="social-icon-item">
                                     <a href="#" class="social-icon-link bi-twitter"></a>
                                 </li>
                                 <li class="social-icon-item">
                                     <a href="#" class="social-icon-link bi-facebook"></a>
                                 </li>
                             </ul>
                         </div>

                         <div class="section-overlay"></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>

    <section class="section-padding" id="pricing-section">
        <div class="container">
            <div class="pricing-header">
                <h2>Workspace Pricing Plans</h2>
                <p>Choose the perfect workspace solution for your needs</p>
            </div>

            <div class="discount-banner">
                <span class="discount-icon">🎓✨</span>
                <h4 class=" text-white">Student Discount Available!</h4>
                <p class="mb-0  text-white">
                    <span class="highlight text-white">15% off</span> with valid ID on all rates •
                    Special monthly study pods plan: <span class="highlight">₱3,800/month</span>
                </p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <ul class="nav nav-tabs" id="pricingTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hourly-tab" data-bs-toggle="tab" data-bs-target="#hourly-pane" type="button" role="tab">Hourly Rates</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="membership-tab" data-bs-toggle="tab" data-bs-target="#membership-pane" type="button" role="tab">Memberships</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="group-tab" data-bs-toggle="tab" data-bs-target="#group-pane" type="button" role="tab">Group Plans</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container">
            <div class="tab-content" id="pricingTabContent">
                <!-- Hourly Rates Tab -->
                <div class="tab-pane fade show active" id="hourly-pane" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="pricing-card">
                                <h3 class="pricing-title">Private Desk</h3>
                                <div class="pricing-rate">₱90<span>/hour</span></div>
                                <ul class="pricing-features">
                                    <li>Individual workspace</li>
                                    <li>High-speed Wi-Fi</li>
                                    <li>Power outlets</li>
                                    <li>Basic amenities</li>
                                </ul>
                                <button class="btn pricing-btn">Book Now</button>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="pricing-card featured">
                                <h3 class="pricing-title">Study Pod</h3>
                                <div class="pricing-rate">₱100<span>/hour</span></div>
                                <ul class="pricing-features">
                                    <li>Semi-private booth</li>
                                    <li>Enhanced privacy</li>
                                    <li>Premium comfort</li>
                                    <li>Study-focused environment</li>
                                </ul>
                                <button class="btn pricing-btn">Book Now</button>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="pricing-card">
                                <h3 class="pricing-title">Hot Desk</h3>
                                <div class="pricing-rate">₱80<span>/hour</span></div>
                                <ul class="pricing-features">
                                    <li>Flexible seating</li>
                                    <li>Open workspace</li>
                                    <li>Collaborative environment</li>
                                    <li>Cost-effective</li>
                                </ul>
                                <button class="btn pricing-btn">Book Now</button>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="pricing-card">
                                <h3 class="pricing-title">Meeting Room</h3>
                                <div class="pricing-rate">₱300<span>/hour</span></div>
                                <ul class="pricing-features">
                                    <li>Private meeting space</li>
                                    <li>Presentation equipment</li>
                                    <li>Whiteboard included</li>
                                    <li>Professional setting</li>
                                </ul>
                                <button class="btn pricing-btn">Reserve Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Membership Plans Tab -->
                <div class="tab-pane fade" id="membership-pane" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="pricing-card">
                                <h3 class="pricing-title">Daily Plan</h3>
                                <div class="pricing-rate">₱200<span>/day</span></div>
                                <ul class="pricing-features">
                                    <li>1-day hot desk access</li>
                                    <li>Wi-Fi & charging ports</li>
                                    <li>Free coffee/tea</li>
                                    <li>Basic amenities</li>
                                </ul>
                                <button class="btn pricing-btn">Get Started</button>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="pricing-card featured">
                                <h3 class="pricing-title">Weekly Plan</h3>
                                <div class="pricing-rate">₱900<span>/week</span></div>
                                <ul class="pricing-features">
                                    <li>5-day hot desk access</li>
                                    <li>3hrs meeting room/week</li>
                                    <li>Premium amenities</li>
                                    <li>Priority booking</li>
                                </ul>
                                <button class="btn pricing-btn">Most Popular</button>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="pricing-card">
                                <h3 class="pricing-title">Monthly Plan</h3>
                                <div class="pricing-rate">₱3,000<span>/month</span></div>
                                <ul class="pricing-features">
                                    <li>Unlimited hot desk access</li>
                                    <li>Free meeting room (4hrs/month)</li>
                                    <li>Locker included</li>
                                    <li>All premium features</li>
                                </ul>
                                <button class="btn pricing-btn">Go Premium</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Group Plans Tab -->
                <div class="tab-pane fade" id="group-pane" role="tabpanel">
                    <div class="group-pricing">
                        <h3><i class="bi bi-people-fill"></i> Group & Team Solutions</h3>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="group-card">
                                    <h4 style="color: #6096B4; margin-bottom: 15px;">Group Study Pack</h4>
                                    <div style="font-size: 1.8rem; font-weight: bold; color: #6096B4; margin-bottom: 15px;">
                                        ₱2,400<span style="font-size: 1rem; color: #93BFCF;">/month</span>
                                    </div>
                                    <ul style="list-style: none; padding: 0;">
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>Up to 6 students</li>
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>Office supplies included</li>
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>Whiteboard & group capsule</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="group-card">
                                    <h4 style="color: #6096B4; margin-bottom: 15px;">Startup Team Pack</h4>
                                    <div st yle="font-size: 1.8rem; font-weight: bold; color: #6096B4; margin-bottom: 15px;">
                                        ₱7,500<span style="font-size: 1rem; color: #93BFCF;">/month</span>
                                    </div>
                                    <ul style="list-style: none; padding: 0;">
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>Up to 7 members</li>
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>50hrs shared meeting room</li>
                                        <li style="padding: 5px 0; color: #6096B4;"><i class="bi bi-check-circle-fill" style="color: #93BFCF; margin-right: 10px;"></i>3 lockers included</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




 <section class="faq-section section-padding" id="section_4">
     <div class="container">
         <div class="row">

             <div class="col-lg-6 col-12">
                 <h2 class="mb-4">Frequently Asked Questions</h2>
             </div>

             <div class="clearfix"></div>

             <div class="col-lg-5 col-12">
                 <img src="images/faq_graphic.jpg" class="img-fluid" alt="FAQs">
             </div>

             <div class="col-lg-6 col-12 m-auto">
                 <div class="accordion" id="accordionExample">
                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingOne">
                             <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 How do I book a workspace?
                             </button>
                         </h2>

                         <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                             <div class="accordion-body">
                                 Booking a workspace at CoWorkly is simple! You can <strong>book online through our website</strong> by selecting your preferred space type, date, and time. Alternatively, you can visit our location during business hours and book in person. For monthly memberships or group bookings, please contact our customer service team.
                             </div>
                         </div>
                     </div>

                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingTwo">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 What amenities are included with my workspace?
                             </button>
                         </h2>

                         <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                             <div class="accordion-body">
                                 All workspaces include <strong>high-speed Wi-Fi, power outlets, and access to common areas</strong>. Premium memberships include additional benefits such as meeting room credits, locker usage, free printing allowance, and complimentary coffee/tea. Meeting rooms feature presentation equipment, whiteboards, and video conferencing capabilities.
                             </div>
                         </div>
                     </div>

                     <div class="accordion-item">
                         <h2 class="accordion-header" id="headingThree">
                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 Can I cancel or reschedule my booking?
                             </button>
                         </h2>

                         <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                             <div class="accordion-body">
                                 Yes, you can reschedule or cancel your booking through your account dashboard. For hourly and daily reservations, we offer full refunds with at least 24 hours' notice. For memberships, please refer to your <code>membership agreement</code> for specific cancellation policies. Please note that no-shows may affect future booking privileges.
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </section>


<section class="contact-section section-padding section-bg" id="section_5">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-5">Get in touch</h2>
                </div>

                <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                    <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.4025482344854!2d121.03855277577312!3d14.568010077384172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c9bd3ddb3461%3A0xf27a33ee85152c32!2sBonifacio%20Global%20City%2C%20Taguig%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1718294530733!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                    <h4 class="mb-3">BGC Branch</h4>

                    <p>32nd Street cor. 11th Avenue, Bonifacio Global City, Taguig, Metro Manila, Philippines</p>

                    <hr>

                    <p class="d-flex align-items-center mb-1">
                        <span class="me-2">Phone</span>

                        <a href="tel: (02) 8-888-7654" class="site-footer-link">
                            (02) 8-888-7654
                        </a>
                    </p>

                    <p class="d-flex align-items-center">
                        <span class="me-2">Email</span>

                        <a href="mailto:bgc@coworkly.ph" class="site-footer-link">
                            bgc@coworkly.ph
                        </a>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mx-auto">
                    <h4 class="mb-3">Makati Branch</h4>

                    <p>Ayala Avenue, Makati Central Business District, Makati City, Metro Manila, Philippines</p>

                    <hr>

                    <p class="d-flex align-items-center mb-1">
                        <span class="me-2">Phone</span>

                        <a href="tel: (02) 8-777-9876" class="site-footer-link">
                            (02) 8-777-9876
                        </a>
                    </p>

                    <p class="d-flex align-items-center">
                        <span class="me-2">Email</span>

                        <a href="mailto:makati@coworkly.ph" class="site-footer-link">
                            makati@coworkly.ph
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
