@extends('layouts.admin.app')

                        @section('content')
                        <div class="container py-5">
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h1 class="fw-bold">Available Workspaces</h1>
                                    <p class="text-muted">Find and book your perfect workspace</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="d-flex justify-content-md-end gap-2">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="categoryFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                                Category
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="categoryFilter">
                                                <li><a class="dropdown-item" href="{{ route('bookings.index') }}">All Categories</a></li>
                                                @foreach($categories as $category)
                                                    <li><a class="dropdown-item" href="{{ route('bookings.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="typeFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                                Type
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="typeFilter">
                                                <li><a class="dropdown-item" href="{{ route('bookings.index') }}">All Types</a></li>
                                                <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'desk']) }}">Desk</a></li>
                                                <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'meeting_room']) }}">Meeting Room</a></li>
                                                <li><a class="dropdown-item" href="{{ route('bookings.index', ['type' => 'study_pod']) }}">Study Pod</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                @forelse($workspaces as $workspace)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 shadow-sm">
                                            <img src="{{ $workspace->image ? asset('storage/workspace_images/' . $workspace->image) : asset('images/default_workspace.jpg') }}"
                                                 class="card-img-top"
                                                 alt="{{ $workspace->name }}"
                                                 style="height: 200px; object-fit: cover;">

                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="badge bg-primary">{{ $workspace->category->name }}</span>
                                                    @if(!$workspace->is_available)
                                                        <span class="badge bg-danger">Unavailable</span>
                                                    @endif
                                                </div>
                                                <h5 class="card-title">{{ $workspace->name }}</h5>
                                                <p class="card-text text-muted small">{{ Str::limit($workspace->description, 100) }}</p>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between small text-muted mb-2">
                                                        <span>
                                                            <i class="bi bi-tag"></i>
                                                            {{ ucfirst(str_replace('_', ' ', $workspace->type)) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        @if($workspace->hourly_rate)
                                                            <p class="mb-0 fw-bold">₱{{ number_format($workspace->hourly_rate) }} <small class="text-muted fw-normal">/ hour</small></p>
                                                        @endif
                                                        <p class="mb-0 fw-bold">₱{{ number_format($workspace->daily_rate) }} <small class="text-muted fw-normal">/ day</small></p>
                                                    </div>
                                                    <a href="{{ route('bookings.create', $workspace->id) }}" class="btn btn-primary">Book Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-5">
                                        <i class="bi bi-search display-1 text-muted"></i>
                                        <h3 class="mt-3">No workspaces found</h3>
                                        <p class="text-muted">Try adjusting your search criteria</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $workspaces->links('pagination::bootstrap-5') }}
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
