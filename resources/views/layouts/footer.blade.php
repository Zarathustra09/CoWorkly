
<footer class="site-footer section-padding">
    <div class="container">
        <div class="row">

          <div class="col-lg-3 col-12 mb-4 pb-2">
              <a class="navbar-brand mb-2" href="index.html">
                  <span class="app-brand-logo">
                      <img src="{{ asset('coworkly.png') }}" alt="{{env('APP_NAME')}} Logo" width="75">
                  </span>
                  <span class="app-brand-text fw-bolder ms-2">{{env('APP_NAME')}}</span>
              </a>
          </div>

            <div class="col-lg-3 col-md-4 col-6">
                <h6 class="site-footer-title mb-3">Resources</h6>

                <ul class="site-footer-links">
                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">Home</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">How it works</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">FAQs</a>
                    </li>

                    <li class="site-footer-link-item">
                        <a href="#" class="site-footer-link">Contact</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                <h6 class="site-footer-title mb-3">Information</h6>

                <p class="text-white d-flex mb-1">
                    <a href="tel: 305-240-9671" class="site-footer-link">
                        305-240-9671
                    </a>
                </p>

                <p class="text-white d-flex">
                    <a href="mailto:info@company.com" class="site-footer-link">
                        info@company.com
                    </a>
                </p>
            </div>

            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        English</button>

                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="button">Thai</button></li>

                        <li><button class="dropdown-item" type="button">Myanmar</button></li>

                        <li><button class="dropdown-item" type="button">Arabic</button></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</footer>


<!-- JAVASCRIPT FILES -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.sticky.js')}}"></script>
<script src="{{asset('js/click-scroll.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
