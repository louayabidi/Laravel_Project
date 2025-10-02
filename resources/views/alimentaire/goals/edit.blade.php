<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="goals"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Goal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Goal</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('goals.update', $goal->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Age</label>
                                    <input type="number" name="age" value="{{ $goal->age }}" class="form-control" required>
                                    @error('age')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="male" {{ $goal->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $goal->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" step="0.1" name="weight" value="{{ $goal->weight }}" class="form-control" required>
                                    @error('weight')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="number" step="0.1" name="height" value="{{ $goal->height }}" class="form-control" required>
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Activity Level</label>
                                    <select name="activity_level" class="form-control" required>
                                        <option value="sedentary" {{ $goal->activity_level == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                                        <option value="light" {{ $goal->activity_level == 'light' ? 'selected' : '' }}>Light</option>
                                        <option value="moderate" {{ $goal->activity_level == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="active" {{ $goal->activity_level == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="very_active" {{ $goal->activity_level == 'very_active' ? 'selected' : '' }}>Very Active</option>
                                    </select>
                                    @error('activity_level')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Goal Type</label>
                                    <select name="goal_type" class="form-control" required>
                                        <option value="lose" {{ $goal->goal_type == 'lose' ? 'selected' : '' }}>Lose Weight</option>
                                        <option value="maintain" {{ $goal->goal_type == 'maintain' ? 'selected' : '' }}>Maintain Weight</option>
                                        <option value="gain" {{ $goal->goal_type == 'gain' ? 'selected' : '' }}>Gain Weight</option>
                                    </select>
                                    @error('goal_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Protein Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_protein" value="{{ $goal->daily_protein }}" class="form-control">
                                    @error('daily_protein')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Carbs Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_carbs" value="{{ $goal->daily_carbs }}" class="form-control">
                                    @error('daily_carbs')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">Daily Fat Goal (g, optional)</label>
                                    <input type="number" step="0.1" name="daily_fat" value="{{ $goal->daily_fat }}" class="form-control">
                                    @error('daily_fat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-primary">Update</button>
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