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
                    document.querySelectorAll('.chat-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const bookingId = this.dataset.bookingId;
                            const workspaceName = this.dataset.workspaceName;

                            Swal.fire({
                                title: `Chat about ${workspaceName}`,
                                html: `
                <div class="text-start">
                    <div class="chat-container p-2" style="height: 200px; overflow-y: auto; background: #f8f9fa; border-radius: 5px; border: 1px solid #dee2e6;">
                        <p class="mb-2"><strong>System:</strong> <span class="text-muted">Welcome to support chat for booking #${bookingId}.</span></p>
                        <p class="mb-2"><strong>System:</strong> <span class="text-muted">A support agent will respond shortly.</span></p>
                    </div>
                    <div class="mt-3">
                        <textarea class="form-control" id="chat-message" rows="2" placeholder="Type your message here..."></textarea>
                    </div>
                </div>
            `,
                                showCancelButton: true,
                                confirmButtonText: 'Send',
                                cancelButtonText: 'Close',
                                confirmButtonColor: '#28a745',
                                cancelButtonColor: '#6c757d',
                                allowOutsideClick: false,
                                showLoaderOnConfirm: true,
                                preConfirm: () => {
                                    const message = document.getElementById('chat-message').value;
                                    if (!message.trim()) {
                                        Swal.showValidationMessage('Please enter a message');
                                        return false;
                                    }
                                    return message;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Here you would normally send the message to your backend
                                    // For now, just show a confirmation
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Message Sent',
                                        text: 'Your message has been sent to support.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            });
                        });
                    });
                });
            </script>
        @endpush
