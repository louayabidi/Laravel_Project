<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="{{ $user->name }}'s Profile"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/bruce-mars.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $user->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $user->badge }}
                            </p>
                        </div>
                        <h6>User Badges</h6>
<div class="row">
    @forelse($badges as $badge)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm text-center" style="width:100%; aspect-ratio:1/1; overflow:hidden;">

                {{-- Badge image --}}
                @if($badge->image && file_exists(public_path('storage/' . $badge->image)))
                    <img src="{{ asset('storage/' . $badge->image) }}"
                         alt="{{ $badge->name }}"
                         style="width:100%; height:100%; object-fit:cover;"
                         onclick="window.location='{{ route('badges.show', $badge->id) }}'">
                @else
                    <div class="bg-gray-200 w-100 h-100 d-flex align-items-center justify-content-center">
                        <span class="text-muted">No Image</span>
                    </div>
                @endif

                {{-- Card footer for name --}}
                <div class="card-footer p-2">
                    <h6 class="mb-1">{{ $badge->name }}</h6>
                    <small class="text-muted">{{ $badge->description ?? '' }}</small>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No badges found.</p>
    @endforelse
</div>

</div>

                    </div>

                </div>


</x-layout>
