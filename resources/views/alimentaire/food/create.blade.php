<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="foods"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Food"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Create Food</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('foods.store') }}" method="POST">
                                @csrf
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Calories</label>
                                    <input type="number" step="0.01" name="calories" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Protein</label>
                                    <input type="number" step="0.01" name="protein" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Carbs</label>
                                    <input type="number" step="0.01" name="carbs" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Fat</label>
                                    <input type="number" step="0.01" name="fat" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Sugar</label>
                                    <input type="number" step="0.01" name="sugar" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Fiber</label>
                                    <input type="number" step="0.01" name="fiber" class="form-control" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label>Is Custom</label>
                                    <input type="checkbox" name="is_custom" value="1" class="form-check-input">
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
</x-layout>