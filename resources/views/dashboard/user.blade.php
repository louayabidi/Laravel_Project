<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <x-header.header></x-header.header>

        <!-- Navbar secondaire -->
        <x-navbars.navs.auth titlePage="Accueil SmartHealth"></x-navbars.navs.auth>
        <!-- End Navbar -->

       <!-- Hero Section -->
<div class="container py-5" 
     style="background: linear-gradient(135deg, #ff5fa2 0%, #00c896 100%); border-radius: 1rem;">
    <div class="row align-items-center">
        
        <!-- Texte à gauche -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="font-weight-bold text-white mb-3">
                Bienvenue sur SmartHealth Tracker
            </h1>
            <p class="text-light mb-4">
                Suivez vos habitudes de vie, améliorez votre bien-être et atteignez vos objectifs quotidiens.
            </p>
            <a href="#features" class="btn btn-light btn-lg shadow px-4 py-2">
                Découvrir
            </a>
        </div>

        <!-- Image à droite avec effet moderne -->
        <div class="col-lg-6 text-center position-relative">
            <!-- Ombre colorée derrière l’image -->
            <div class="position-absolute top-50 start-50 translate-middle rounded-circle" 
                 style="width: 400px; height: 400px; background: rgba(255, 95, 162, 0.2); filter: blur(60px); z-index:0;">
            </div>

            <!-- Image -->
            <img src="{{ asset('assets/img/acceuil.png') }}" 
                 class="img-fluid rounded-4 shadow-lg position-relative" 
                 style="max-width: 85%; transform: rotate(-3deg) translateX(20px);" 
                 alt="SmartHealth Tracker Illustration">
        </div>
    </div>
</div>


        <!-- Cards Section -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-lg border-radius-xl">
                        <div class="card-body text-center p-4">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary border-radius-xl mb-3">
                                <i class="material-icons opacity-10">fitness_center</i>
                            </div>
                            <h5 class="font-weight-bold">Suivi des habitudes</h5>
                            <p class="text-sm">
                                Enregistrez votre activité physique, sommeil et nutrition facilement.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-lg border-radius-xl">
                        <div class="card-body text-center p-4">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success border-radius-xl mb-3">
                                <i class="material-icons opacity-10">psychology</i>
                            </div>
                            <h5 class="font-weight-bold">Motivation & conseils</h5>
                            <p class="text-sm">
                                Recevez des recommandations et notifications pour rester motivé.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-lg border-radius-xl">
                        <div class="card-body text-center p-4">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info border-radius-xl mb-3">
                                <i class="material-icons opacity-10">group</i>
                            </div>
                            <h5 class="font-weight-bold">Pour étudiants et enseignants</h5>
                            <p class="text-sm">
                                Partagez vos progrès, créez des challenges et collaborez facilement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth></x-footers.auth>
    </main>
    <x-plugins></x-plugins>
</x-layout>
