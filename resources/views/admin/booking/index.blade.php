@extends('layouts.admin.app')

                    @section('content')
                    <div class="container py-5">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="fw-bold">Available Workspaces</h1>
                                <p class="text-muted">Find and book your perfect workspace</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="dropdown">
                                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="categoryFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter by Category
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="categoryFilter">
                                        <li><a class="dropdown-item" href="{{ route('workspace.index') }}">All Categories</a></li>
                                        @foreach(App\Models\WorkSpaceCategory::all() as $category)
                                            <li><a class="dropdown-item" href="{{ route('workspace.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            @forelse($workspaces as $workspace)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm">
                                        @php
                                            $imagesArray = [];
                                            if (is_array($workspace->images)) {
                                                $imagesArray = $workspace->images;
                                            } else if (is_string($workspace->images)) {
                                                try {
                                                    $imagesArray = json_decode($workspace->images, true) ?? [];
                                                } catch (\Exception $e) {
                                                    $imagesArray = [];
                                                }
                                            }
                                        @endphp

                                        @if(count($imagesArray) > 0)
                                            <div id="carousel-{{ $workspace->id }}" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($imagesArray as $key => $image)
                                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/workspace_images/' . $image) }}"
                                                                 class="card-img-top"
                                                                 alt="{{ $workspace->name }}"
                                                                 style="height: 200px; object-fit: cover;"
                                                                 onerror="this.onerror=null; this.src='{{ asset('images/default_workspace.jpg') }}'">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if(count($imagesArray) > 1)
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $workspace->id }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $workspace->id }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <img src="{{ asset('images/default_workspace.jpg') }}" class="card-img-top" alt="{{ $workspace->name }}" style="height: 200px; object-fit: cover;">
                                        @endif

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">{{ $workspace->category->name }}</span>
                                                @if($workspace->is_premium)
                                                    <span class="badge bg-warning text-dark">Premium</span>
                                                @endif
                                            </div>
                                            <h5 class="card-title">{{ $workspace->name }}</h5>
                                            <p class="card-text text-muted small">{{ Str::limit($workspace->description, 100) }}</p>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between small text-muted mb-2">
                                                    <span><i class="bi bi-geo-alt"></i> {{ $workspace->location }}</span>
                                                    <span><i class="bi bi-people"></i> Capacity: {{ $workspace->capacity }}</span>
                                                </div>

                                                @php
                                                    $amenitiesArray = [];
                                                    if (is_array($workspace->amenities)) {
                                                        $amenitiesArray = $workspace->amenities;
                                                    } else if (is_string($workspace->amenities)) {
                                                        try {
                                                            $amenitiesArray = json_decode($workspace->amenities, true) ?? [];
                                                        } catch (\Exception $e) {
                                                            $amenitiesArray = [];
                                                        }
                                                    }
                                                @endphp

                                                @if(count($amenitiesArray) > 0)
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        @foreach(array_slice($amenitiesArray, 0, 3) as $amenity)
                                                            <span class="badge bg-light text-dark">{{ $amenity }}</span>
                                                        @endforeach
                                                        @if(count($amenitiesArray) > 3)
                                                            <span class="badge bg-light text-dark">+{{ count($amenitiesArray) - 3 }} more</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    @if($workspace->hourly_rate)
                                                        <p class="mb-0 fw-bold">₱{{ number_format($workspace->hourly_rate) }} <small class="text-muted fw-normal">/ hour</small></p>
                                                    @endif
                                                    <p class="mb-0 fw-bold">₱{{ number_format($workspace->daily_rate) }} <small class="text-muted fw-normal">/ day</small></p>
                                                </div>
                                                <a href="" class="btn btn-primary">Book Now</a>
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
                            <nav aria-label="Workspace pagination">
                                {{ $workspaces->links('pagination::bootstrap-5') }}
                            </nav>
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
