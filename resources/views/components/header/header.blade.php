<header class="bg-white shadow-sm py-3 mb-3">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Logo + Nom -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/img/logosante.png') }}" alt="SmartHealth Logo" class="me-3" style="height:40px;">
            <span class="h5 mb-0 font-weight-bold text-primary">SmartHealth</span>
        </div>

        <!-- Navigation centrale -->
        <nav class="d-flex gap-4 align-items-center">
            <a href="{{ route('profile') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-user fa-sm"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('dashboard') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-home fa-sm"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('foods.index') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-utensils fa-sm"></i>
                <span>Aliments</span>
            </a>
            <a href="{{ route('meals.index') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-apple-alt fa-sm"></i>
                <span>Repas</span>
            </a>
            <a href="{{ route('objectifs.index') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-chart-line fa-sm"></i>
                <span>Habitudes</span>
            </a>
            <a href="{{ route('sante-mesures.index') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-heartbeat fa-sm"></i>
                <span>Santé</span>
            </a>
            <a href="{{ route('badges.index') }}" class="text-dark font-weight-bold text-sm text-decoration-none d-flex align-items-center gap-1">
                <i class="fas fa-medal fa-sm"></i>
                <span>Badges</span>
            </a>
        </nav>

        <!-- Espace pour éventuels éléments à droite (profil, etc.) -->
        <div class="d-flex align-items-center gap-3">
            <!-- Vous pouvez ajouter ici des éléments comme le profil utilisateur, notifications, etc. -->
            <span class="text-xs text-muted">Bienvenue</span>
        </div>
    </div>
</header>
