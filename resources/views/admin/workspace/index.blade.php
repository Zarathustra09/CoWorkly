@extends('layouts.admin.app')

                                    @section('content')
                                        <div class="container py-4">
                                            <div class="card shadow-sm mb-4" style="border: none; border-radius: 15px; background-color: #EEE9DA;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h2 class="fw-bold mb-0" style="color: #6096B4;">My Bookings</h2>
                                                        <a href="{{ route('bookings.index') }}" class="btn"
                                                           style="border: 1px solid #6096B4; background-color: transparent; color: #6096B4;">
                                                            <i class="bx bx-search me-1"></i> Browse Workspaces
                                                        </a>
                                                    </div>

                                                    <!-- Booking status tabs -->
                                                    <ul class="nav nav-tabs mb-4" style="border-bottom-color: #BDCDD6;">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                                                               style="color: #6096B4; border-color: #BDCDD6 #BDCDD6 #EEE9DA;">All Bookings</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="confirmed-tab" data-bs-toggle="tab" href="#confirmed" role="tab"
                                                               style="color: #93BFCF; border-color: transparent;">Confirmed</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab"
                                                               style="color: #93BFCF; border-color: transparent;">Pending</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="cancelled-tab" data-bs-toggle="tab" href="#cancelled" role="tab"
                                                               style="color: #93BFCF; border-color: transparent;">Cancelled</a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                                                            @forelse(Auth::user()->bookings as $booking)
                                                                @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <i class="bx bx-calendar fs-1 mb-3" style="color: #BDCDD6;"></i>
                                                                    <h4 style="color: #6096B4;">No bookings found</h4>
                                                                    <p style="color: #93BFCF;">You haven't made any workspace bookings yet.</p>
                                                                    <a href="{{ route('bookings.index') }}" class="btn mt-2"
                                                                       style="background-color: #6096B4; color: #EEE9DA;">
                                                                        <i class="bx bx-calendar-plus me-1"></i> Browse Workspaces
                                                                    </a>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="tab-pane fade" id="confirmed" role="tabpanel">
                                                            @forelse(Auth::user()->bookings->where('status', 'confirmed') as $booking)
                                                                @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <h4 style="color: #6096B4;">No confirmed bookings</h4>
                                                                    <p style="color: #93BFCF;">You don't have any confirmed bookings at the moment.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="tab-pane fade" id="pending" role="tabpanel">
                                                            @forelse(Auth::user()->bookings->where('status', 'pending') as $booking)
                                                                @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <h4 style="color: #6096B4;">No pending bookings</h4>
                                                                    <p style="color: #93BFCF;">You don't have any pending payments at the moment.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="tab-pane fade" id="cancelled" role="tabpanel">
                                                            @forelse(Auth::user()->bookings->where('status', 'cancelled') as $booking)
                                                                @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <h4 style="color: #6096B4;">No cancelled bookings</h4>
                                                                    <p style="color: #93BFCF;">You don't have any cancelled bookings.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endsection

                                    @push('scripts')
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Activate tab based on URL hash or status parameter
                                                const urlParams = new URLSearchParams(window.location.search);
                                                const status = urlParams.get('status');

                                                if (status) {
                                                    const tab = document.getElementById(`${status}-tab`);
                                                    if (tab) {
                                                        bootstrap.Tab.getOrCreateInstance(tab).show();
                                                    }
                                                } else if (window.location.hash) {
                                                    const hash = window.location.hash.substring(1);
                                                    const tab = document.getElementById(`${hash}-tab`);
                                                    if (tab) {
                                                        bootstrap.Tab.getOrCreateInstance(tab).show();
                                                    }
                                                }

                                                // Add SweetAlert for success messages
                                                @if(session('success'))
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success!',
                                                        text: "{{ session('success') }}",
                                                        confirmButtonColor: '#6096B4',
                                                        confirmButtonText: 'OK',
                                                        background: '#EEE9DA',
                                                        iconColor: '#6096B4'
                                                    });
                                                @endif

                                                @if(session('error'))
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: "{{ session('error') }}",
                                                        confirmButtonColor: '#6096B4',
                                                        confirmButtonText: 'OK',
                                                        background: '#EEE9DA',
                                                        iconColor: '#6096B4'
                                                    });
                                                @endif

                                                // Attach click handlers to all "Details" buttons
                                                document.querySelectorAll('.booking-details-btn').forEach(button => {
                                                    button.addEventListener('click', function(e) {
                                                        e.preventDefault();

                                                        const bookingId = this.dataset.bookingId;
                                                        const workspaceName = this.dataset.workspaceName;
                                                        const bookingDate = this.dataset.bookingDate;
                                                        const bookingType = this.dataset.bookingType;
                                                        const bookingStatus = this.dataset.bookingStatus;
                                                        const bookingCost = this.dataset.bookingCost;
                                                        const bookingUrl = this.href;

                                                        // Show SweetAlert with booking details
                                                        Swal.fire({
                                                            title: 'Booking Details',
                                                            html: `
                                                                <div class="text-start">
                                                                    <p><strong style="color: #6096B4;">Workspace:</strong> <span style="color: #93BFCF;">${workspaceName}</span></p>
                                                                    <p><strong style="color: #6096B4;">Date:</strong> <span style="color: #93BFCF;">${bookingDate}</span></p>
                                                                    <p><strong style="color: #6096B4;">Type:</strong> <span style="color: #93BFCF;">${bookingType}</span></p>
                                                                    <p><strong style="color: #6096B4;">Status:</strong> <span class="badge" style="background-color: ${
                                                                        bookingStatus === 'confirmed' ? '#6096B4' :
                                                                        bookingStatus === 'pending' ? '#BDCDD6' : '#93BFCF'
                                                                    }; color: ${bookingStatus === 'pending' ? '#6096B4' : '#EEE9DA'};">${bookingStatus.charAt(0).toUpperCase() + bookingStatus.slice(1)}</span></p>
                                                                    <p><strong style="color: #6096B4;">Cost:</strong> <span style="color: #93BFCF;">₱${bookingCost}</span></p>
                                                                    <p class="mt-3 text-center small" style="color: #BDCDD6;">This is a simulated transaction for demonstration purposes only.</p>
                                                                </div>
                                                            `,
                                                            showCloseButton: true,
                                                            showCancelButton: true,
                                                            cancelButtonText: 'Close',
                                                            confirmButtonColor: '#6096B4',
                                                            cancelButtonColor: '#BDCDD6',
                                                            confirmButtonText: 'View Details',
                                                            background: '#EEE9DA',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Navigate to full details page
                                                                window.location.href = bookingUrl;
                                                            }
                                                        });
                                                    });
                                                });

                                                // Attach click handlers to all "Chat" buttons
                                                document.querySelectorAll('.chat-btn').forEach(button => {
                                                    button.addEventListener('click', function(e) {
                                                        e.preventDefault(); // Prevent any default action

                                                        const groupChatId = this.dataset.groupChatId;

                                                        // Redirect to the group chat page
                                                        window.location.href = `{{ url('group-chats') }}/${groupChatId}`;
                                                    });
                                                });

                                                // Style tab switching
                                                const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
                                                tabLinks.forEach(tab => {
                                                    tab.addEventListener('click', function() {
                                                        tabLinks.forEach(t => {
                                                            if (t.classList.contains('active')) {
                                                                t.style.color = '#6096B4';
                                                                t.style.borderColor = '#BDCDD6 #BDCDD6 #EEE9DA';
                                                            } else {
                                                                t.style.color = '#93BFCF';
                                                                t.style.borderColor = 'transparent';
                                                            }
                                                        });
                                                    });
                                                });
                                            });
                                        </script>
                                    @endpush
