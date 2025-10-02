<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @if(auth()->user()->role == 'admin')
        {{-- Admin layout with sidebar --}}
        <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            <x-navbars.navs.auth titlePage="User Profile"></x-navbars.navs.auth>
            <div class="container-fluid py-4">
                 <div class="card-body px-3 pt-4">
                    <div class="row">
                        @foreach ($badges as $badge)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if($badge->image)
                                        <img src="{{ asset('storage/' . $badge->image) }}" class="card-img-top" alt="{{ $badge->name }}" style="height:200px; object-fit:cover;" onclick="window.location='{{ route('badges.show', $badge->id) }}'">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $badge->name }}</h5>
                                        <p class="card-text">{{ $badge->description }}</p>
                                        <p class="text-muted mb-3"><strong>Criteria:</strong> {{ $badge->criteria }}</p>
                                        <div class="mt-auto d-flex justify-content-between">
                                            <a href="{{ route('badges.show', $badge->id) }}" class="btn btn-sm btn-outline-primary">Show</a>
                                            <a href="{{ route('badges.edit', $badge->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <form action="{{ route('badges.destroy', $badge->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> <!-- End card body -->
            </div>
        </div>
    @else
    <x-header.header></x-header.header>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-navbars.navs.auth titlePage="Détails de l'Habitude"></x-navbars.navs.auth>

    <!-- Background wrapper -->
    <div class="container py-5"
       style="background: linear-gradient(135deg, #ff5fa2 0%, #00c896 100%); border-radius: 1rem;">

        <div class="card-body px-3 pt-4">
            <div class="row">
                @foreach ($badges as $badge)
                    @php
                        // Check if the user has this badge
                        $hasBadge = $user->badges->contains($badge->id);
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm transition-all"
                             style="
                                 {{ $hasBadge ? '' : 'filter: grayscale(100%); opacity: 0.7;' }}
                                 border-radius: 1rem;
                                 overflow: hidden;
                                 transition: transform 0.3s, box-shadow 0.3s;
                             "
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.15)';"
                             onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">

                            @if($badge->image)
                                <img src="{{ asset('storage/' . $badge->image) }}"
                                     class="card-img-top"
                                     alt="{{ $badge->name }}"
                                     style="height:200px; object-fit:cover;"
                                     onclick="window.location='{{ route('badges.show', $badge->id) }}'">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $badge->name }}</h5>
                                <p class="card-text">{{ $badge->description }}</p>
                                <p class="text-muted mb-3">
                                    <strong>Criteria:</strong> {{ $badge->criteria }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> <!-- End card body -->
    </div>
</main>

@endif

</x-layout>
