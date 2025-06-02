@extends('layouts.admin.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-4 text-center">
                            <h2 class="fw-bold">Checkout</h2>
                            <p class="text-muted">Complete your booking payment</p>

                            <!-- Simulation notice -->
                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle"></i> This is a simulated payment gateway for demonstration purposes only. No actual transactions will occur.
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Booking Details</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Workspace:</strong> {{ $booking->workspace->name }}</li>
                                    <li class="mb-2"><strong>Dates:</strong>
                                        {{ $booking->start_datetime->format('M d, Y') }}
                                        @if($booking->start_datetime->format('Y-m-d') != $booking->end_datetime->format('Y-m-d'))
                                            to {{ $booking->end_datetime->format('M d, Y') }}
                                        @endif
                                    </li>
                                    <li class="mb-2"><strong>Hours:</strong> 9:00 AM - 5:00 PM</li>
                                    <li class="mb-2"><strong>Type:</strong> {{ ucfirst($booking->booking_type) }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>₱{{ number_format($booking->total_cost, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span>₱0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span>₱{{ number_format($booking->total_cost, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-3">Select Payment Method</h5>

                        <div class="row mb-4">
                            <div class="col-12">
                                <form id="paymentForm" action="{{ route('checkout.process', $booking) }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card payment-option" data-payment="gcash">
                                                <div class="card-body text-center p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" value="gcash" id="gcash" checked>
                                                        <label class="form-check-label w-100" for="gcash">
                                                            <div class="my-2">
                                                                <img src="{{ asset('images/gcash-logo.png') }}" alt="GCash" style="height: 40px;">
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="card payment-option" data-payment="paymaya">
                                                <div class="card-body text-center p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="payment_method" value="paymaya" id="paymaya">
                                                        <label class="form-check-label w-100" for="paymaya">
                                                            <div class="my-2">
                                                                <img src="{{ asset('images/paymaya-logo.png') }}" alt="PayMaya" style="height: 40px;">
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="payment-details mt-4">
                                        <!-- Simulated payment instructions -->
                                        <div class="alert alert-secondary">
                                            <div class="gcash-instructions">
                                                <h6 class="fw-bold mb-2">GCash Payment Instructions</h6>
                                                <ol class="mb-0">
                                                    <li>Open your GCash app</li>
                                                    <li>Scan this QR code (simulated)</li>
                                                    <li>Enter amount: ₱{{ number_format($booking->total_cost, 2) }}</li>
                                                    <li>Complete the payment in your app</li>
                                                    <li>Enter the reference number below</li>
                                                </ol>
                                                <div class="text-center my-3">
                                                    <img src="{{asset('images/rickrollqr.png')}}" alt="GCash QR" class="img-fluid" style="max-width: 150px;">
                                                </div>
                                            </div>

                                            <div class="paymaya-instructions" style="display: none;">
                                                <h6 class="fw-bold mb-2">PayMaya Payment Instructions</h6>
                                                <ol class="mb-0">
                                                    <li>Open your PayMaya app</li>
                                                    <li>Scan this QR code (simulated)</li>
                                                    <li>Enter amount: ₱{{ number_format($booking->total_cost, 2) }}</li>
                                                    <li>Complete the payment in your app</li>
                                                    <li>Enter the reference number below</li>
                                                </ol>
                                                <div class="text-center my-3">
                                                    <img src="{{asset('images/rickrollqr.png')}}" alt="PayMaya QR" class="img-fluid" style="max-width: 150px;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="reference_number" class="form-label">Reference Number</label>
                                            <input type="text"
                                                   class="form-control @error('reference_number') is-invalid @enderror"
                                                   id="reference_number"
                                                   name="reference_number"
                                                   value="{{ old('reference_number', 'DEMO-' . rand(10000000, 99999999)) }}"
                                                   required>
                                            <div class="form-text">
                                                Enter the reference number from your payment app (pre-filled for demo)
                                            </div>
                                            @error('reference_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Complete Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const gcashInstructions = document.querySelector('.gcash-instructions');
            const paymayaInstructions = document.querySelector('.paymaya-instructions');

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const paymentMethod = this.dataset.payment;
                    const radioInput = this.querySelector('input[type="radio"]');

                    // Select the radio button
                    radioInput.checked = true;

                    // Show appropriate instructions
                    if (paymentMethod === 'gcash') {
                        gcashInstructions.style.display = 'block';
                        paymayaInstructions.style.display = 'none';
                    } else {
                        gcashInstructions.style.display = 'none';
                        paymayaInstructions.style.display = 'block';
                    }
                });
            });

            // Make entire card clickable
            document.querySelectorAll('.payment-option').forEach(card => {
                card.style.cursor = 'pointer';
            });

            // Generate random reference number for demo
            document.getElementById('reference_number').addEventListener('focus', function() {
                this.select();
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .payment-option {
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
        }

        .payment-option:hover {
            border-color: #adb5bd;
        }

        .payment-option input[type="radio"]:checked + label + div,
        .payment-option input[type="radio"]:checked ~ div {
            color: #0d6efd;
        }

        .payment-option input[type="radio"]:checked ~ .card-body {
            background-color: #f8f9fa;
        }

        .payment-option input[type="radio"]:checked + .card-body,
        .payment-option input[type="radio"]:checked ~ .card-body {
            border-color: #0d6efd;
        }

        .payment-option input[type="radio"]:checked,
        .payment-option:has(input[type="radio"]:checked) {
            border-color: #0d6efd;
        }
    </style>
@endpush
