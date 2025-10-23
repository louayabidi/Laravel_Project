<x-layout bodyClass="g-sidenav-show bg-gray-200">
    @push('styles')
    <link href="{{ asset('assets/css/regime-styles.css') }}" rel="stylesheet">
    <style>
        /* Toast Notification Styles */
        .toast-notification {
            position: fixed !important;
            top: 80px !important;
            right: 20px !important;
            left: auto !important;
            bottom: auto !important;
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%) !important;
            color: white !important;
            padding: 1.5rem 2rem !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            z-index: 9999 !important;
            max-width: 400px !important;
            animation: slideInRight 0.4s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        .toast-notification.hide {
            animation: slideOutRight 0.4s ease forwards;
        }

        .toast-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .toast-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.3s ease;
        }

        .toast-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0 0 8px 0;
            animation: progress 5s linear forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(400px);
            }
        }

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }

        /* Responsive */
        @media (max-width: 600px) {
            .toast-notification {
                left: 10px;
                right: 10px;
                max-width: none;
            }
        }
    </style>
    @endpush

    <x-header.header></x-header.header>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Détails de la Mesure"></x-navbars.navs.auth>
        <!-- End Navbar -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize ps-3">Détails de la Mesure</h6>
                            <div>
                                <a href="{{ route('sante-mesures.edit', $sante_mesure) }}" class="btn btn-sm btn-info me-2">
                                    <i class="material-icons">edit</i> Modifier
                                </a>
                                <a href="{{ route('sante-mesures.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="material-icons">arrow_back</i> Retour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alertes si nécessaire -->
                    @if($alertes)
                        <div class="alert alert-warning alert-with-icon">
                            <i class="material-icons me-2">warning</i>
                            <span data-notify="message">
                                <b>Attention</b> : Certaines mesures nécessitent votre attention
                            </span>
                        </div>
                    @endif

                    <!-- Recommandations Personnalisées (Vue Améliorée) -->
                    @include('sante-mesures.recommendations', ['mesure' => $sante_mesure, 'recommendations' => $recommendations])

                    <!-- Recommandations Anciennes Format (Gardé pour compatibilité) -->
                    @if(count($recommendations) > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="material-icons me-2">tips_and_updates</i>Recommandations</h5>
                            </div>
                            <div class="card-body">
                                <div class="recommendations">
                                    @foreach($recommendations as $recommendation)
                                        <div class="recommendation-item">
                                            <i class="material-icons text-primary me-2">lightbulb</i>
                                            {{ $recommendation }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informations utilisateur -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="material-icons me-2">person</i>Patient</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="material-icons text-primary me-2">account_circle</i>
                                <h6 class="mb-0">{{ $sante_mesure->user->name }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Détails des mesures -->
                    <div class="row">
                        <!-- Mesures principales -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Mesures Principales</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Date de mesure :</th>
                                            <td>{{ $sante_mesure->date_mesure->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date de remplissage :</th>
                                            <td>{{ $sante_mesure->date_remplie ? $sante_mesure->date_remplie->format('d/m/Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Poids :</th>
                                            <td>{{ $sante_mesure->poids_kg }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Taille :</th>
                                            <td>{{ $sante_mesure->taille_cm }} cm</td>
                                        </tr>
                                        <tr>
                                            <th>IMC :</th>
                                            <td>
                                                {{ $sante_mesure->imc }}
                                                <small class="text-muted">
                                                    @if($sante_mesure->imc < 18.5)
                                                        (Insuffisance pondérale)
                                                    @elseif($sante_mesure->imc < 25)
                                                        (Normal)
                                                    @elseif($sante_mesure->imc < 30)
                                                        (Surpoids)
                                                    @else
                                                        (Obésité)
                                                    @endif
                                                </small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Mesures cardiaques -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Mesures Cardiaques</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th>Fréquence cardiaque :</th>
                                            <td>
                                                {{ $sante_mesure->freq_cardiaque }} bpm
                                                @if($sante_mesure->freq_cardiaque < 60)
                                                    <span class="text-warning">(Basse)</span>
                                                @elseif($sante_mesure->freq_cardiaque > 100)
                                                    <span class="text-warning">(Élevée)</span>
                                                @else
                                                    <span class="text-success">(Normale)</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tension artérielle :</th>
                                            <td>
                                                {{ $sante_mesure->tension_systolique }}/{{ $sante_mesure->tension_diastolique }} mmHg
                                                @if($sante_mesure->tension_systolique > 140 || $sante_mesure->tension_diastolique > 90)
                                                    <span class="text-warning">(Élevée)</span>
                                                @else
                                                    <span class="text-success">(Normale)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information du Régime -->
                    <div class="card mt-4 regime-card">
                        <div class="card-header bg-gradient-info">
                            <h5 class="mb-0 text-white d-flex align-items-center">
                                <i class="material-icons me-2">fitness_center</i>
                                Information du Régime
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($regime)
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                <i class="material-icons text-info me-2 align-middle">sports_gymnastics</i>Type de Régime
                                            </th>
                                            <td class="align-middle ps-3">
                                                <span class="badge bg-gradient-{{ $regime->type_regime == 'Diabète' ? 'danger' : ($regime->type_regime == 'Hypertension' ? 'warning' : ($regime->type_regime == 'Grossesse' ? 'success' : ($regime->type_regime == 'Cholestérol élevé (hypercholestérolémie)' ? 'info' : ($regime->type_regime == 'Maladie cœliaque (intolérance au gluten)' ? 'primary' : 'secondary')))) }} px-3 py-2">
                                                    <i class="material-icons me-2 align-middle" style="font-size: 1.1rem;">
                                                        @if($regime->type_regime == 'Diabète')
                                                            local_hospital
                                                        @elseif($regime->type_regime == 'Hypertension')
                                                            favorite
                                                        @elseif($regime->type_regime == 'Grossesse')
                                                            pregnant_woman
                                                        @elseif($regime->type_regime == 'Cholestérol élevé (hypercholestérolémie)')
                                                            opacity
                                                        @elseif($regime->type_regime == 'Maladie cœliaque (intolérance au gluten)')
                                                            restaurant
                                                        @else
                                                            healing
                                                        @endif
                                                    </i>
                                                    {{ $regime->type_regime }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                <i class="material-icons text-info me-2 align-middle">track_changes</i>Valeur Cible
                                            </th>
                                            <td class="align-middle ps-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="font-weight-bold me-2">{{ $regime->valeur_cible }}</span>
                                                    <span class="text-secondary">kg</span>
                                                </div>
                                            </td>


                                        @if($regime->description)
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <i class="material-icons me-2">description</i>Description
                                            </th>
                                            <td class="align-middle">
                                                <p class="text-sm mb-0">{{ $regime->description }}</p>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="material-icons text-muted" style="font-size: 3rem;">fitness_center</i>
                                    <p class="text-muted mt-2">Aucun régime associé à cette mesure</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Remarques -->
                    @if($sante_mesure->remarque)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Remarques</h5>
                            </div>
                            <div class="card-body">
                                {{ $sante_mesure->remarque }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>

    @push('scripts')
    <script>
        // Ajouter les animations au style
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(400px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(400px);
                }
            }

            @keyframes progress {
                from {
                    width: 100%;
                }
                to {
                    width: 0%;
                }
            }
        `;
        document.head.appendChild(style);

        // Créer la toast notification
        function createToast() {
            const toast = document.createElement('div');
            toast.id = 'toastNotification';
            toast.style.cssText = `
                position: fixed !important;
                top: 80px !important;
                right: 20px !important;
                left: auto !important;
                bottom: auto !important;
                background: linear-gradient(135deg, #4caf50 0%, #45a049 100%) !important;
                color: white !important;
                padding: 1.5rem 2rem !important;
                border-radius: 8px !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                z-index: 99999 !important;
                max-width: 400px !important;
                display: flex !important;
                align-items: center !important;
                gap: 1rem !important;
                animation: slideInRight 0.4s ease !important;
                font-family: Arial, sans-serif !important;
            `;

            toast.innerHTML = `
                <div style="font-size: 1.5rem; flex-shrink: 0;">✓</div>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 1rem; margin-bottom: 0.25rem;">Mesure Enregistrée!</div>
                    <div style="font-size: 0.9rem; opacity: 0.95;">Recommandations générées par l'IA</div>
                </div>
                <button onclick="closeToast()" style="background: rgba(255, 255, 255, 0.2); border: none; color: white; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background 0.3s ease; font-size: 1.2rem; padding: 0; line-height: 1;">×</button>
                <div style="position: absolute; bottom: 0; left: 0; height: 3px; background: rgba(255, 255, 255, 0.5); border-radius: 0 0 8px 0; animation: progress 5s linear forwards; width: 100%;"></div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                closeToast();
            }, 5000);
        }

        function closeToast() {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                toast.style.animation = 'slideOutRight 0.4s ease forwards';
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }
        }

        // Afficher la toast si c'est une nouvelle mesure
        @if($showToast ?? false)
            console.log('Creating toast - showToast is true');
            createToast();
        @else
            console.log('showToast is false or not set');
        @endif
    </script>
    @endpush

    <x-plugins></x-plugins>
</x-layout>
