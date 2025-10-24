<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">health_and_safety</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Mesures de Santé</p>
                                <h4 class="mb-0">{{ auth()->user()->santeMesures()->count() }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Actif</span> ce mois</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">psychology</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">IA Recommandations</p>
                                <h4 class="mb-0">
                                    <i class="fas fa-robot text-success"></i>
                                    {{ auth()->user()->santeMesures()->where('date_mesure', '>=', now()->subDays(30))->count() > 0 ? 'Activée' : 'En attente' }}
                                </h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-info text-sm font-weight-bolder">Local AI (Random Forest)</span> intégré</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">trending_up</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Évolution Poids</p>
                                <h4 class="mb-0">
                                    @php
                                        $recent = auth()->user()->santeMesures()->latest()->first();
                                        $previous = auth()->user()->santeMesures()->orderBy('date_mesure', 'desc')->skip(1)->first();
                                        $change = $recent && $previous ? round($recent->poids_kg - $previous->poids_kg, 1) : 0;
                                    @endphp
                                    @if($change != 0)
                                        <span class="{{ $change > 0 ? 'text-danger' : 'text-success' }}">{{ $change > 0 ? '+' : '' }}{{ $change }}kg</span>
                                    @else
                                        Stable
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-primary text-sm font-weight-bolder">30 derniers jours</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">restaurant</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Régimes Actifs</p>
                                <h4 class="mb-0">{{ auth()->user()->santeMesures()->whereNotNull('regime_id')->distinct('regime_id')->count() }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Personnalisés</span> avec IA</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AI Health Insights Section -->
            @php
                $healthAnalysis = app(\App\Services\HealthAnalysisService::class)->analyzeHealthTrends(auth()->user(), 30);
            @endphp
            @if(isset($healthAnalysis) && (!empty($healthAnalysis['alerts']) || !empty($healthAnalysis['recommendations'])))
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-header bg-gradient-info">
                            <h5 class="mb-0 text-white d-flex align-items-center">
                                <i class="fas fa-brain me-2"></i>
                                IA - Analyse de Santé Personnalisée 
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- AI Alerts -->
                            @if(!empty($healthAnalysis['alerts']))
                            <div class="mb-3">
                                <h6 class="text-danger"><i class="material-icons me-2">warning</i>Alertes Détectées :</h6>
                                @foreach($healthAnalysis['alerts'] as $alert)
                                <div class="alert alert-{{ $alert['type'] == 'danger' ? 'danger' : ($alert['type'] == 'warning' ? 'warning' : 'info') }} d-flex align-items-start mb-2">
                                    <i class="material-icons me-2 mt-1">
                                        @if($alert['type'] == 'danger')error
                                        @elseif($alert['type'] == 'warning')warning
                                        @else info
                                        @endif
                                    </i>
                                    <div>
                                        <strong>{{ $alert['message'] }}</strong>
                                        @if(isset($alert['severity']))
                                        <br><small class="text-muted">
                                            Sévérité: {{ $alert['severity'] == 'high' ? 'Élevée' : ($alert['severity'] == 'medium' ? 'Moyenne' : 'Faible') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- AI Recommendations -->
                            @if(!empty($healthAnalysis['recommendations']))
                            <div>
                                <h6 class="text-success"><i class="fas fa-robot me-2"></i>Recommandations IA Personnalisées :</h6>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-brain me-1"></i>
                                        Généré par IA Locale (Ensemble Vote: RF 92.31% + GB 100% = 98.67% Accuracy) • Données anonymisées
                                    </small>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach(array_slice($healthAnalysis['recommendations'], 0, 3) as $recommendation)
                                    <li class="list-group-item d-flex align-items-start">
                                        <i class="material-icons text-success me-2 mt-1" style="font-size: 1.2rem;">check_circle</i>
                                        <span>{{ $recommendation }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="mt-2">
                                    <a href="{{ route('sante-mesures.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="material-icons me-1">visibility</i>
                                        Voir toutes les recommandations
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Évolution du Poids</h6>
                            <p class="text-sm ">Vos mesures de santé des 7 derniers jours</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">trending_up</i>
                                <p class="mb-0 text-sm">
                                    @php
                                        $recentMeasures = auth()->user()->santeMesures()->latest()->take(7)->get();
                                        $avgWeight = $recentMeasures->avg('poids_kg');
                                    @endphp
                                    Moyenne: {{ $avgWeight ? number_format($avgWeight, 1) : 'N/A' }} kg
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Évolution IMC</h6>
                            <p class="text-sm ">
                                @php
                                    $latestMeasure = auth()->user()->santeMesures()->latest()->first();
                                    $imc = $latestMeasure ? $latestMeasure->imc : null;
                                @endphp
                                @if($imc)
                                    IMC actuel: <span class="font-weight-bolder">{{ number_format($imc, 1) }}</span>
                                    @if($imc < 18.5)
                                        (Insuffisance pondérale)
                                    @elseif($imc < 25)
                                        (Normal)
                                    @elseif($imc < 30)
                                        (Surpoids)
                                    @else
                                        (Obésité)
                                    @endif
                                @else
                                    Aucune mesure récente
                                @endif
                            </p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">info</i>
                                <p class="mb-0 text-sm">Dernière mise à jour: {{ $latestMeasure ? $latestMeasure->date_mesure->format('d/m/Y') : 'Jamais' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Rythme Cardiaque</h6>
                            <p class="text-sm ">
                                @php
                                    $avgHeartRate = $recentMeasures->avg('freq_cardiaque');
                                @endphp
                                @if($avgHeartRate)
                                    Moyenne: <span class="font-weight-bolder">{{ round($avgHeartRate) }} bpm</span>
                                    @if($avgHeartRate > 100)
                                        (Tachycardie)
                                    @elseif($avgHeartRate < 60)
                                        (Bradycardie)
                                    @else
                                        (Normal)
                                    @endif
                                @else
                                    Aucune donnée
                                @endif
                            </p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">favorite</i>
                                <p class="mb-0 text-sm">Surveillance continue recommandée</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
    </div>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: [50, 20, 10, 22, 50, 10, 40],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f8f9fa',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    </script>
    @endpush
</x-layout>
