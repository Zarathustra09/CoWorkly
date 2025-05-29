<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show(Booking $booking)
    {
        // Only allow pending bookings to be checked out
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking has already been processed.');
        }

        // Ensure the user can only access their own bookings
        if (auth()->id() != $booking->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('bookings.index')
                ->with('error', 'You are not authorized to checkout this booking.');
        }

        return view('checkout.show', compact('booking'));
    }

    public function process(Request $request, Booking $booking)
    {
        try {
            $request->validate([
                'payment_method' => 'required|in:gcash,paymaya',
                'reference_number' => 'required|string|min:8|max:20'
            ]);

            // In a real system, you would verify the payment with the payment gateway here

            // Update booking status to confirmed
            $booking->update([
                'status' => 'confirmed',
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->reference_number
            ]);

            Log::info('Payment processed successfully', [
                'booking_id' => $booking->id,
                'payment_method' => $request->payment_method,
                'reference' => $request->reference_number
            ]);

            // Redirect to the user's workspace/bookings index instead of booking.show
            return redirect()->route('workspace.index')
                ->with('success', 'Payment successful! Your booking has been confirmed.');

        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'payment_method' => $request->payment_method ?? 'unknown'
            ]);

            return back()
                ->with('error', 'Payment processing failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
