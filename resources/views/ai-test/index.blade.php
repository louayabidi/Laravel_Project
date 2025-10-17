@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>🤖 Test de l'Ensemble de Modèles IA</h6>
                    <p class="text-sm text-muted">Testez les prédictions du système IA avec vos données</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Formulaire -->
                        <div class="col-md-6">
                            <form id="aiTestForm">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">BMI (Index de Masse Corporelle)</label>
                                    <input type="number" class="form-control" id="bmi" name="bmi" step="0.1" min="10" max="60" value="25" required>
                                    <small class="text-muted">Entre 10 et 60</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tension Systolique (mmHg)</label>
                                    <input type="number" class="form-control" id="tension_systolique" name="tension_systolique" min="80" max="200" value="120" required>
                                    <small class="text-muted">Entre 80 et 200</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tension Diastolique (mmHg)</label>
                                    <input type="number" class="form-control" id="tension_diastolique" name="tension_diastolique" min="40" max="130" value="80" required>
                                    <small class="text-muted">Entre 40 et 130</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fréquence Cardiaque (bpm)</label>
                                    <input type="number" class="form-control" id="freq_cardiaque" name="freq_cardiaque" min="40" max="150" value="70" required>
                                    <small class="text-muted">Entre 40 et 150</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Condition Attendue</label>
                                    <select class="form-control" id="condition" name="condition" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="Diabète">Diabète</option>
                                        <option value="Hypertension">Hypertension</option>
                                        <option value="Grossesse">Grossesse</option>
                                        <option value="Cholestérol élevé (hypercholestérolémie)">Cholestérol élevé</option>
                                        <option value="Maladie cœliaque (intolérance au gluten)">Maladie cœliaque</option>
                                        <option value="Insuffisance rénale">Insuffisance rénale</option>
                                        <option value="Normal">Normal</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-brain"></i> Tester la Prédiction
                                </button>
                            </form>

                            <!-- Exemples -->
                            <div class="mt-4">
                                <h6 class="mb-3">📋 Exemples Rapides</h6>
                                <div id="samplesContainer"></div>
                            </div>
                        </div>

                        <!-- Résultats -->
                        <div class="col-md-6">
                            <div id="resultsContainer" style="display: none;">
                                <div class="alert alert-info">
                                    <h6>📊 Résultats de la Prédiction</h6>
                                </div>

                                <!-- Prédiction Principale -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">🎯 Prédiction Ensemble</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-muted">Condition Prédite:</p>
                                                <h5 id="predictedCondition" class="text-primary"></h5>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted">Confiance:</p>
                                                <h5 id="confidence" class="text-success"></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Prédictions Individuelles -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">🤖 Résultats de Tous les Modèles</h6>
                                        
                                        <!-- Random Forest -->
                                        <div class="mb-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-1"><strong>🌲 Random Forest</strong></p>
                                                    <p id="rfPrediction" class="mb-0 text-primary"></p>
                                                </div>
                                                <div class="text-end">
                                                    <small id="rfConfidence" class="text-muted d-block"></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Gradient Boosting -->
                                        <div class="mb-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-1"><strong>⚡ Gradient Boosting</strong></p>
                                                    <p id="gbPrediction" class="mb-0 text-success"></p>
                                                </div>
                                                <div class="text-end">
                                                    <small id="gbConfidence" class="text-muted d-block"></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Ensemble Vote -->
                                        <div class="p-3 border rounded" style="background-color: #e7f3ff; border: 2px solid #0066cc;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-1"><strong>🎯 Ensemble Vote (Recommandé)</strong></p>
                                                    <p id="ensemblePrediction" class="mb-0 text-primary" style="font-weight: bold; font-size: 1.1em;"></p>
                                                </div>
                                                <div class="text-end">
                                                    <small id="ensembleConfidence" class="text-muted d-block"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature Importance -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">📈 Importance des Facteurs</h6>
                                        <div id="featureImportanceContainer"></div>
                                    </div>
                                </div>

                                <!-- Explainability -->
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">💡 Explications</h6>
                                        <div id="explanations"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="loadingContainer" style="display: none; text-align: center;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                                <p class="mt-2">Traitement en cours...</p>
                            </div>

                            <div id="errorContainer" style="display: none;">
                                <div class="alert alert-danger" role="alert">
                                    <h6>❌ Erreur</h6>
                                    <p id="errorMessage"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .progress-bar-animated {
        animation: progress-bar-stripes 1s linear infinite;
    }
    
    .feature-bar {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        height: 20px;
        border-radius: 3px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Charger les exemples
    loadSamples();
    
    // Soumettre le formulaire
    document.getElementById('aiTestForm').addEventListener('submit', function(e) {
        e.preventDefault();
        testPrediction();
    });
});

function loadSamples() {
    fetch('{{ route("ai-test.sample") }}')
        .then(response => response.json())
        .then(samples => {
            const container = document.getElementById('samplesContainer');
            samples.forEach(sample => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-outline-primary w-100 mb-2';
                btn.innerHTML = `<i class="fas fa-flask"></i> ${sample.name}`;
                btn.onclick = () => loadSample(sample);
                container.appendChild(btn);
            });
        });
}

function loadSample(sample) {
    document.getElementById('bmi').value = sample.bmi;
    document.getElementById('tension_systolique').value = sample.tension_systolique;
    document.getElementById('tension_diastolique').value = sample.tension_diastolique;
    document.getElementById('freq_cardiaque').value = sample.freq_cardiaque;
    document.getElementById('condition').value = sample.condition;
}

function testPrediction() {
    const formData = new FormData(document.getElementById('aiTestForm'));
    
    document.getElementById('resultsContainer').style.display = 'none';
    document.getElementById('errorContainer').style.display = 'none';
    document.getElementById('loadingContainer').style.display = 'block';

    fetch('{{ route("ai-test.test") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingContainer').style.display = 'none';
        
        if (data.success) {
            displayResults(data.data);
            document.getElementById('resultsContainer').style.display = 'block';
        } else {
            showError(data.error);
        }
    })
    .catch(error => {
        document.getElementById('loadingContainer').style.display = 'none';
        showError(error.message);
    });
}

function displayResults(data) {
    // Prédiction principale
    document.getElementById('predictedCondition').textContent = data.predicted_condition || 'N/A';
    document.getElementById('confidence').textContent = (data.confidence * 100).toFixed(1) + '%';
    
    // Prédictions individuelles
    if (data.individual_predictions) {
        const rf = data.individual_predictions.random_forest;
        const gb = data.individual_predictions.gradient_boosting;
        
        document.getElementById('rfPrediction').textContent = rf.prediction;
        document.getElementById('rfConfidence').textContent = `Confiance: ${(rf.confidence * 100).toFixed(1)}%`;
        
        document.getElementById('gbPrediction').textContent = gb.prediction;
        document.getElementById('gbConfidence').textContent = `Confiance: ${(gb.confidence * 100).toFixed(1)}%`;
        
        // Ensemble Vote
        document.getElementById('ensemblePrediction').textContent = data.predicted_condition || 'N/A';
        document.getElementById('ensembleConfidence').textContent = `Confiance: ${(data.confidence * 100).toFixed(1)}%`;
    }
    
    // Feature Importance
    if (data.feature_importance) {
        const container = document.getElementById('featureImportanceContainer');
        container.innerHTML = '';
        
        const maxImportance = Math.max(...Object.values(data.feature_importance));
        
        Object.entries(data.feature_importance).forEach(([feature, importance]) => {
            const percentage = (importance / maxImportance * 100).toFixed(1);
            const html = `
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small><strong>${feature}</strong></small>
                        <small>${percentage}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: ${percentage}%"></div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });
    }
    
    // Explications
    if (data.explanation) {
        const container = document.getElementById('explanations');
        container.innerHTML = `<p>${data.explanation}</p>`;
    }
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorContainer').style.display = 'block';
}
</script>
@endsection
