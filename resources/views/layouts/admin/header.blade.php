<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                        <div class="app-brand demo">
                            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
        <img src="{{ asset('coworkly.png') }}" alt="Coworkly Logo" class="app-brand-logo" width="75">
              </span>
                                <span class="app-brand-text demo menu-text fw-bolder ms-2">{{env('APP_NAME')}}</span>
                            </a>

                            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                                <i class="bx bx-chevron-left bx-sm align-middle"></i>
                            </a>
                        </div>

                        <div class="menu-inner-shadow"></div>

                        <ul class="menu-inner py-4">
                            <!-- Dashboard -->
                            <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-home-alt"></i>
                                    <div data-i18n="Dashboard">Dashboard</div>
                                </a>
                            </li>


                            <li class="menu-header small text-uppercase"><span class="menu-header-text">Booking Management</span></li>

                         <li class="menu-item {{ request()->routeIs('bookings.create') ? 'active' : '' }}">
                             <a href="javascript:void(0);" class="menu-link">
                                 <i class="menu-icon tf-icons bx bx-calendar-plus"></i>
                                 <div data-i18n="Book a Workspace">Book a Workspace</div>
                             </a>
                         </li>



                        </ul>
                    </aside>
