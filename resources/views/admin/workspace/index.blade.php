@extends('layouts.admin.app')

        @section('content')
            <div class="container py-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold mb-0">My Bookings</h2>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">Browse Workspaces</a>
                        </div>

                        <!-- Booking status tabs -->
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab">All Bookings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="confirmed-tab" data-bs-toggle="tab" href="#confirmed" role="tab">Confirmed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cancelled-tab" data-bs-toggle="tab" href="#cancelled" role="tab">Cancelled</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                @forelse(Auth::user()->bookings as $booking)
                                    @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                @empty
                                    <div class="text-center py-5">
                                        <img src="{{ asset('images/empty-bookings.svg') }}" alt="No bookings" class="img-fluid mb-3" style="max-width: 200px;">
                                        <h4 class="text-muted">No bookings found</h4>
                                        <p class="text-muted">You haven't made any workspace bookings yet.</p>
                                        <a href="{{ route('bookings.index') }}" class="btn btn-primary mt-2">Browse Workspaces</a>
                                    </div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="confirmed" role="tabpanel">
                                @forelse(Auth::user()->bookings->where('status', 'confirmed') as $booking)
                                    @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                @empty
                                    <div class="text-center py-5">
                                        <h4 class="text-muted">No confirmed bookings</h4>
                                        <p class="text-muted">You don't have any confirmed bookings at the moment.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="pending" role="tabpanel">
                                @forelse(Auth::user()->bookings->where('status', 'pending') as $booking)
                                    @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                @empty
                                    <div class="text-center py-5">
                                        <h4 class="text-muted">No pending bookings</h4>
                                        <p class="text-muted">You don't have any pending payments at the moment.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                                @forelse(Auth::user()->bookings->where('status', 'cancelled') as $booking)
                                    @include('admin.booking.partials.booking-card', ['booking' => $booking])
                                @empty
                                    <div class="text-center py-5">
                                        <h4 class="text-muted">No cancelled bookings</h4>
                                        <p class="text-muted">You don't have any cancelled bookings.</p>
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
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    @endif

                    @if(session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "{{ session('error') }}",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
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
                                        <p><strong>Workspace:</strong> ${workspaceName}</p>
                                        <p><strong>Date:</strong> ${bookingDate}</p>
                                        <p><strong>Type:</strong> ${bookingType}</p>
                                        <p><strong>Status:</strong> <span class="badge bg-${
                                            bookingStatus === 'confirmed' ? 'success' :
                                            bookingStatus === 'pending' ? 'warning' : 'danger'
                                        }">${bookingStatus.charAt(0).toUpperCase() + bookingStatus.slice(1)}</span></p>
                                        <p><strong>Cost:</strong> ₱${bookingCost}</p>
                                        <p class="mt-3 text-center text-muted small">This is a simulated transaction for demonstration purposes only.</p>
                                    </div>
                                `,
                                showCloseButton: true,
                                showCancelButton: true,
                                cancelButtonText: 'Close',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#6c757d',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Navigate to full details page
                                    window.location.href = bookingUrl;
                                }
                            });
                        });
                    });


                    // Add this to the existing DOMContentLoaded function in admin/workspace/index.blade.php
// Attach click handlers to all "Chat" buttons

                    // Replace the existing chat-btn event handler with this code
                    document.querySelectorAll('.chat-btn').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent any default action

                            const groupChatId = this.dataset.groupChatId;

                            // Redirect to the group chat page
                            window.location.href = `{{ url('group-chats') }}/${groupChatId}`;
                        });
                    });
                });
            </script>
        @endpush
