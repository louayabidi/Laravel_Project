<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @if(auth()->user()->role == 'admin')
        {{-- Admin layout with sidebar --}}
        <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            <x-navbars.navs.auth titlePage="User Profile"></x-navbars.navs.auth>
     @else
      <x-header.header></x-header.header>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-navbars.navs.auth titlePage="Détails de l'Habitude"></x-navbars.navs.auth>
    @endif
    <!-- Background wrapper -->
    <div class="container py-5"
         style="background: linear-gradient(135deg, #ff5fa2 0%, #00c896 100%); border-radius: 1rem;">
        <div class="card-body px-3 pt-4">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="card h-100 shadow-sm transition-all"
                         style="border-radius: 1rem; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;">
                        @if($badge->image && file_exists(public_path('storage/' . $badge->image)))
                            <img src="{{ asset('storage/' . $badge->image) }}"
                                 alt="{{ $badge->name }}"
                                 style="width:100%; height:auto; object-fit:cover;">
                        @else
                            <div class="bg-gray-200 w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="height: 300px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h3 class="card-title
                                style="font-weight: bold; color: #333;">{{ $badge->name }}</h3>
                            <p class="card-text text-muted">{{ $badge->description ?? 'No description available.' }}</p>
                            <p class="text-muted
                                 style="font-style: italic;"><strong>Criteria:</strong> {{ $badge->criteria ?? 'N/A' }}</p>
                            <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-layout>
