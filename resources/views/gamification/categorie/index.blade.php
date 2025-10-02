<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="category"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Categories"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="card my-4">
                <!-- Card header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Categories</h6>
                    </div>
                </div>

                <!-- Create button header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="d-flex justify-content-end p-3">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body px-3 pt-4">
                    <div class="row">
                        @forelse($categories as $category)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm text-center">
                                    @if($category->icon)
                                        <img src="{{ asset('storage/' . $category->icon) }}"
                                             alt="{{ $category->name }}"
                                             class="card-img-top"
                                             style="height:200px; object-fit:cover; cursor:pointer;"
                                             onclick="window.location='{{ route('categories.show', $category) }}'">
                                    @else
                                        <div class="bg-gray-200" style="height:200px; display:flex; align-items:center; justify-content:center;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                        <p class="card-text text-muted">{{ $category->description }}</p>

                                        <div class="mt-auto d-flex justify-content-between">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">Edit</a>

                                            <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No categories found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <x-footers.auth></x-footers.auth>
        </div>

        <x-plugins></x-plugins>
    </main>
</x-layout>
