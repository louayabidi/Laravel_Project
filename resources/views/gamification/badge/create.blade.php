<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="category"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Categorie"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Create category</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                            <form action="{{ route('badges.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Badge Name</label>
                                    <input type="text" name="name" class="form-control"  required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Description</label>
                                    <input name="description" class="form-control" ></input>
                                </div>

                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label
                                        ">Criteria</label>
                                    <input name="criteria" class="form-control" ></input>
                                </div>
                                <input type="hidden" name="badge_categorie_id" value="{{ $selectedCategoryId }}">


                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label"></label>
                                    <!-- hidden file input -->
                                    <input type="file" name="image" id="iconInput" class="d-none" accept="image/*">

                                    <!-- styled button -->
                                    <label for="iconInput" class="btn btn-outline-primary">
                                        Choose Badge Image
                                    </label>
                                    <span id="fileName" class="ms-2"></span>
                                </div>

                                <!-- image preview -->
                                <div class="mb-3">
                                    <img id="iconPreview" src="" alt="Icon Preview" style="max-width: 100px; display: none; border:1px solid #ccc; padding:2px;">
                                </div>

                                @push('js')
                                <script>
                                    const iconInput = document.getElementById('iconInput');
                                    const fileName = document.getElementById('fileName');
                                    const iconPreview = document.getElementById('iconPreview');

                                    iconInput.addEventListener('change', function() {
                                        if (this.files && this.files.length > 0) {
                                            const file = this.files[0];
                                            fileName.textContent = file.name;

                                            // show image preview
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                iconPreview.src = e.target.result;
                                                iconPreview.style.display = 'inline-block';
                                            }
                                            reader.readAsDataURL(file);
                                        } else {
                                            fileName.textContent = '';
                                            iconPreview.style.display = 'none';
                                        }
                                    });
                                </script>
                                @endpush

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
</x-layout>
<script>
    document.getElementById('iconInput').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : '';
        document.getElementById('fileName').textContent = fileName;
    });
</script>

