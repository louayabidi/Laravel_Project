<header class="bg-white shadow-sm py-3 mb-3">
    <div class="container-fluid d-flex align-items-center">
        <!-- Logo + Nom -->
        <img src="{{ asset('assets/img/logosante.png') }}" alt="SmartHealth Logo" class="me-2" style="height:40px;">
        <span class="h5 mb-0 font-weight-bold text-primary me-4">SmartHealth</span>

        <!-- Nav à côté du logo -->
        <nav class="d-flex gap-3 align-items-center">
            <a href="{{ route('dashboard') }}" class="text-secondary font-weight-bold text-xs">Acceuil</a>
            <a href="{{ route('foods.index') }}" class="text-secondary font-weight-bold text-xs">Foods</a>
            <a href="{{ route('meals.index') }}" class="text-secondary font-weight-bold text-xs">Meals</a>
            <a href="{{ route('habitudes.index') }}" class="text-secondary font-weight-bold text-xs">Habitudes</a>
    
        </nav>
    </div>
</header>
