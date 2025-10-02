<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="category"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Category Badges"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <!-- Card wrapper -->
            <div class="card my-4">
                <!-- Card header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $category->name }} Badges</h6>
                    </div>
                </div>


                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="d-flex justify-content-end p-3">
                        <a href="{{ route('badges.create', ['badge_categorie_id' => $category->id]) }}" class="btn btn-primary">Create New Badge</a>
                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body px-3 pt-4">
                    <div class="row">
                        @foreach ($category->badges as $badge)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if($badge->image)
                                        <img src="{{ asset('storage/' . $badge->image) }}" class="card-img-top" alt="{{ $badge->name }}" style="height:200px; object-fit:cover;" onClick="window.location='{{ route('badges.show', $badge->id) }}'">
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
            </div> <!-- End card -->

            <x-footers.auth></x-footers.auth>
        </div> <!-- End container-fluid -->

        <x-plugins></x-plugins>
    </main>
</x-layout>
