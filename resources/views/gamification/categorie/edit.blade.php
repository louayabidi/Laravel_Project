<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="category"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Category"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Category</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Category Name -->
                                <div class="input-group input-group-outline mb-3 is-focused">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                </div>

                                <!-- Description -->
                                <div class="input-group input-group-outline mb-3 is-focused">
                                    <label class="form-label">Description</label>
                                    <input name="description" class="form-control" value="{{ $category->description }}">
                                </div>

                                <!-- File Input -->
                                <div class="input-group input-group-outline mb-3">
                                    <!-- Hidden file input -->
                                    <input type="file" name="icon" id="iconInput" class="d-none" accept="image/*">

                                    <!-- Styled button -->
                                    <label for="iconInput" class="btn btn-outline-primary">
                                        Choose Category Icon
                                    </label>
                                    <span id="fileName" class="ms-2">

                                    </span>
                                </div>

                                <!-- Icon Preview -->
                                <div class="mb-3">
                                    <div style="width: 120px; height: 120px; border:1px solid #ccc; border-radius:12px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f8f8f8;">
                                        <img id="iconPreview"
                                             src="{{ $category->icon ? asset('storage/'.$category->icon) : '' }}"
                                             alt="Icon Preview"
                                             style="max-width: 100%; max-height: 100%; display: {{ $category->icon ? 'block' : 'none' }};">
                                    </div>
                                </div>

                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
    <script>
        const iconInput = document.getElementById('iconInput');
        const fileName = document.getElementById('fileName');
        const iconPreview = document.getElementById('iconPreview');

        iconInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                fileName.textContent = file.name;

                const reader = new FileReader();
                reader.onload = function(e) {
                    iconPreview.src = e.target.result;
                    iconPreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = '';
                iconPreview.src = '';
                iconPreview.style.display = 'none';
            }
        });
    </script>
    @endpush
</x-layout>
