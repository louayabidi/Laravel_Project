<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="category"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Badge"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <!-- Card Header -->
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Badge</h6>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('badges.update', $badge->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Hidden category ID -->
                                <input type="hidden" name="badge_categorie_id" value="{{ $badge->badge_categorie_id }}">

                                <!-- Badge Name -->
                                <div class="input-group input-group-outline mb-3 is-focused">
                                    <label class="form-label">Badge Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $badge->name }}" required>
                                </div>

                                <!-- Description -->
                                <div class="input-group input-group-outline mb-3 is-focused">
                                    <label class="form-label">Description</label>
                                    <input name="description" class="form-control" value="{{ $badge->description }}">
                                </div>

                                <!-- Criteria -->
                                <div class="input-group input-group-outline mb-3 is-focused">
                                    <label class="form-label">Criteria</label>
                                    <input name="criteria" class="form-control" value="{{ $badge->criteria }}">
                                </div>

                                <!-- Image Upload -->
                                <div class="input-group input-group-outline mb-3">
                                    <input type="file" name="image" id="iconInput" class="d-none" accept="image/*">
                                    <label for="iconInput" class="btn btn-outline-primary">Choose Badge Image</label>
                                    <span id="fileName" class="ms-2"></span>
                                </div>

                                <!-- Image Preview -->
                                <div class="mb-3">
                                    <div style="width: 120px; height: 120px; border: 1px solid #ccc; border-radius:12px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f8f8f8;">
                                        <img id="iconPreview"
                                             src="{{ $badge->image ? asset('storage/'.$badge->image) : '' }}"
                                             alt="Icon Preview"
                                             style="max-width: 100%; max-height: 100%; object-fit: cover; display: {{ $badge->image ? 'block' : 'none' }};">
                                        <span id="placeholderText" style="color: #666; font-size: 14px; display: {{ $badge->image ? 'none' : 'block' }};">No image selected</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                            </form>
                        </div> <!-- End Card Body -->
                    </div> <!-- End Card -->
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div> <!-- End container-fluid -->
        <x-plugins></x-plugins>
    </main>
    @push('js')
<script>
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    const placeholderText = document.getElementById('placeholderText');

    // Store the original image for reset
    const originalImage = "{{ $badge->image ? asset('storage/'.$badge->image) : '' }}";

    iconInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const file = this.files[0];

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                this.value = '';
                return;
            }

            // Show new image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                iconPreview.src = e.target.result;
                iconPreview.style.display = 'block';
                placeholderText.style.display = 'none';
                iconPreview.style.opacity = '0';
                setTimeout(() => {
                    iconPreview.style.transition = 'opacity 0.3s ease';
                    iconPreview.style.opacity = '1';
                }, 50);
            };
            reader.readAsDataURL(file);
        } else {
            // Reset to original image if file selection is cleared
            if (originalImage) {
                iconPreview.src = originalImage;
                iconPreview.style.display = 'block';
                placeholderText.style.display = 'none';
            } else {
                iconPreview.style.display = 'none';
                placeholderText.style.display = 'block';
            }
        }
    });
</script>
@endpush
</x-layout>

