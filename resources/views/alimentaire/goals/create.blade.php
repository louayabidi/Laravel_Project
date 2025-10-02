<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="goals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Create Goal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Create Goal</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('goals.store') }}" method="POST">
                                @csrf
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Age</label>
                                    <input type="number" name="age" class="form-control" required placeholder="e.g., 30">
                                    @error('age')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" step="0.1" name="weight" class="form-control" required placeholder="e.g., 70">
                                    @error('weight')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="number" step="0.1" name="height" class="form-control" required placeholder="e.g., 170">
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Activity Level</label>
                                    <select name="activity_level" class="form-control" required>
                                        <option value="sedentary">Sedentary</option>
                                        <option value="light">Light</option>
                                        <option value="moderate">Moderate</option>
                                        <option value="active">Active</option>
                                        <option value="very_active">Very Active</option>
                                    </select>
                                    @error('activity_level')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Goal Type</label>
                                    <select name="goal_type" class="form-control" required>
                                        <option value="lose">Lose Weight</option>
                                        <option value="maintain">Maintain Weight</option>
                                        <option value="gain">Gain Weight</option>
                                    </select>
                                    @error('goal_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Protein Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_protein" class="form-control" placeholder="e.g., 100">
                                    @error('daily_protein')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Carbs Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_carbs" class="form-control" placeholder="e.g., 200">
                                    @error('daily_carbs')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Fat Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_fat" class="form-control" placeholder="e.g., 50">
                                    @error('daily_fat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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