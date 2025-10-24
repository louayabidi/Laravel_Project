<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @if(auth()->user()->role == 'admin')
        {{-- Admin layout --}}
        <x-navbars.sidebar activePage="badges"></x-navbars.sidebar>
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            <x-navbars.navs.auth titlePage="Détails du Badge"></x-navbars.navs.auth>
    @else
        {{-- User layout --}}
        <x-header.header></x-header.header>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
            <x-navbars.navs.auth titlePage="Détails du Badge"></x-navbars.navs.auth>
    @endif

    <div class="container py-5" style="background: linear-gradient(135deg, #ff5fa2 0%, #00c896 100%); border-radius: 1rem;">
        <div class="card-body px-3 pt-4">

            {{-- Badge Details --}}
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="card h-100 shadow-sm" style="border-radius: 1rem; overflow: hidden;">
                        @if($badge->image && file_exists(public_path('storage/' . $badge->image)))
                            <img src="{{ asset('storage/' . $badge->image) }}"
                                 alt="{{ $badge->name }}"
                                 class="w-100"
                                 style="height: auto; object-fit: cover;">
                        @else
                            <div class="bg-gray-200 w-100 d-flex align-items-center justify-content-center" style="height: 300px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif

                        <div class="card-body">
                            <h3 class="card-title" style="font-weight: bold; color: #333;">{{ $badge->name }}</h3>
                            <p class="card-text text-muted">{{ $badge->description ?? 'No description available.' }}</p>
                            <p class="text-muted" style="font-style: italic;">
                                <strong>Criteria:</strong> {{ $badge->criteria ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin-only: Add Goals --}}
            @if(auth()->user()->role === 'admin')
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        <div class="card shadow-sm p-4">
                            <h4 class="mb-3">Add Goals for this Badge</h4>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('badge-goals.store', $badge->id) }}" method="POST">
                                @csrf

                                <div id="goals-container">
                                    <div class="goal-group mb-3 border p-3 rounded">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Field</label>
                                                <select name="goals[0][field]" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="sommeil_heures">Sleep Hours</option>
                                                    <option value="eau_litres">Water (L)</option>
                                                    <option value="sport_minutes">Sport (min)</option>
                                                    <option value="stress_niveau">Stress Level</option>
                                                    <option value="meditation_minutes">Meditation (min)</option>
                                                    <option value="temps_ecran_minutes">Screen Time (min)</option>
                                                    <option value="cafe_cups">Coffee Cups</option>
                                                    <option value="calories">Calories</option>
                                                    <option value="protein">Protein</option>
                                                    <option value="carbs">Carbs</option>
                                                    <option value="fat">Fat</option>
                                                    <option value="sugar">Sugar</option>
                                                    <option value="fiber">Fiber</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Comparison</label>
                                                <select name="goals[0][comparison]" class="form-control">
                                                    <option value=">=">>=</option>
                                                    <option value="<="><=</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Value</label>
                                                <input type="number" step="0.1" name="goals[0][value]" class="form-control" />
                                            </div>
                                            <div class="col-md-2">
                                                <label>Points</label>
                                                <input type="number" name="goals[0][points]" class="form-control" value="10" />
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-goal w-100">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-goal" class="btn btn-secondary mt-3">+ Add Another Goal</button>
                                <button type="submit" class="btn btn-success mt-3">Save Goals</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Existing Goals --}}

                @if($badge->goals && $badge->goals->count() > 0)
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-8">
                            <div class="card shadow-sm p-4">
                                <h4 class="mb-3">Existing Goals</h4>
                                <ul class="list-group">
                                    @foreach($badge->goals as $goal)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $goal->field }}</strong> {{ $goal->comparison }} {{ $goal->value }}<br>
                                                <small class="text-muted">{{ $goal->points }} points</small>

                                            </div>
                                            <form action="{{ route('badge-goals.destroy', $goal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger ">
                <i class="fa fa-trash"></i> <!-- Bootstrap trash icon -->
            </button>
        </form>

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- JS for dynamic goal fields --}}
    @push('scripts')
        <script>
            let goalIndex = 1;
            document.getElementById('add-goal').addEventListener('click', () => {
                const container = document.getElementById('goals-container');
                const newGoal = container.firstElementChild.cloneNode(true);
                newGoal.querySelectorAll('input, select').forEach(input => {
                    const name = input.getAttribute('name').replace(/\d+/, goalIndex);
                    input.setAttribute('name', name);
                    if(input.type === 'number') input.value = input.defaultValue || '';
                    else input.selectedIndex = 0;
                });
                container.appendChild(newGoal);
                goalIndex++;
            });

            document.addEventListener('click', function(e){
                if(e.target && e.target.classList.contains('remove-goal')){
                    const group = e.target.closest('.goal-group');
                    if(group) group.remove();
                }
            });
        </script>
    @endpush

</x-layout>
