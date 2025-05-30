@extends('layouts.admin.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4">My Conversations</h1>

                @if($groupChats->isEmpty())
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-chat-square-text fs-1 text-secondary mb-3"></i>
                            <h5>No conversations yet</h5>
                            <p class="text-muted">You don't have any active conversations. Conversations are created automatically when you make a booking.</p>
                            <a href="{{ route('bookings.index') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Create a Booking
                            </a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach($groupChats as $chat)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0 text-truncate">
                                            <i class="bi bi-chat-left-text-fill me-2"></i>{{ $chat->name }}
                                        </h5>
                                        <span class="badge bg-light text-dark">
                                            {{ $chat->messages_count }} {{ Str::plural('message', $chat->messages_count) }}
                                        </span>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">Workspace</small>
                                            <p class="mb-0 fw-bold">{{ $chat->booking->workspace->name }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">Date</small>
                                            <p class="mb-0">
                                                {{ $chat->booking->start_datetime->format('M d, Y') }}
                                                @if($chat->booking->start_datetime->format('Y-m-d') != $chat->booking->end_datetime->format('Y-m-d'))
                                                    - {{ $chat->booking->end_datetime->format('M d, Y') }}
                                                @endif
                                            </p>
                                        </div>

                                        <div>
                                            <small class="text-muted d-block mb-1">Participants</small>
                                            <div class="d-flex align-items-center">
                                                @foreach($chat->users->take(3) as $user)
                                                    <div class="me-1" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                                        @if($user->profile_image)
                                                            <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                                 class="rounded-circle" width="24" height="24" alt="{{ $user->name }}">
                                                        @else
                                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                                 style="width: 24px; height: 24px; font-size: 10px;">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                @if($chat->users->count() > 3)
                                                    <div class="ms-1 text-muted small">
                                                        +{{ $chat->users->count() - 3 }} more
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-light border-top-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-muted small">
                                                <i class="bi bi-clock me-1"></i>
                                                @if($chat->messages->isNotEmpty())
                                                    @if($chat->messages->last()->created_at->isToday())
                                                        Today {{ $chat->messages->last()->created_at->format('g:i A') }}
                                                    @elseif($chat->messages->last()->created_at->isYesterday())
                                                        Yesterday {{ $chat->messages->last()->created_at->format('g:i A') }}
                                                    @else
                                                        {{ $chat->messages->last()->created_at->format('M d, Y') }}
                                                    @endif
                                                @else
                                                    No messages yet
                                                @endif
                                            </div>

                                            <a href="{{ route('group-chats.show', $chat) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-chat-text me-1"></i> Open Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
