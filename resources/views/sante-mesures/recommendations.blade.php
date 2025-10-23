@if($recommendations && count($recommendations) > 0)
    <div class="recommendations-container" style="margin-top: 2rem;">
        
        <!-- Alerte IMC -->
        @if($mesure->imc)
            <div class="alert alert-warning" style="border-left: 4px solid #ff9800; background: #fff3e0; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <i class="material-icons" style="color: #ff9800; font-size: 2rem;">warning</i>
                    <div>
                        <h5 style="margin: 0; color: #ff9800; font-weight: 700;">Votre IMC moyen est de {{ number_format($mesure->imc, 1) }}</h5>
                        <p style="margin: 0.5rem 0 0 0; color: #666;">
                            @if($mesure->imc < 18.5)
                                Insuffisance pondérale
                            @elseif($mesure->imc < 25)
                                Poids normal
                            @elseif($mesure->imc < 30)
                                Surpoids
                            @else
                                Obésité
                            @endif
                            <br>
                            <small style="color: #999;">Sévérité: 
                                @if($mesure->imc < 18.5 || $mesure->imc >= 30)
                                    <span style="color: #d32f2f;">Élevée</span>
                                @elseif($mesure->imc < 25)
                                    <span style="color: #4caf50;">Basse</span>
                                @else
                                    <span style="color: #ff9800;">Moyenne</span>
                                @endif
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recommandations Personnalisées -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #667eea;">
            
            <!-- En-tête -->
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <i class="material-icons" style="color: #667eea; font-size: 1.5rem;">lightbulb</i>
                <h4 style="margin: 0; color: #2c3e50; font-weight: 700;">Recommandations Personnalisées</h4>
            </div>

            <!-- Source IA -->
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                <strong>Généré par Intelligence Artificielle Locale</strong> (Ensemble: Random Forest + Gradient Boosting - 95%+ Accuracy)
            </p>

            <!-- Liste des recommandations -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($recommendations as $index => $rec)
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <!-- Icône check -->
                        <div style="flex-shrink: 0; margin-top: 0.25rem;">
                            <i class="material-icons" style="color: #4caf50; font-size: 1.3rem;">check_circle</i>
                        </div>
                        
                        <!-- Contenu -->
                        <div style="flex: 1;">
                            <p style="margin: 0; color: #333; line-height: 1.6;">
                                @if(is_array($rec))
                                    {{ $rec['message'] ?? $rec }}
                                @else
                                    {{ $rec }}
                                @endif
                            </p>
                            
                            <!-- Badge de priorité -->
                            @if(is_array($rec) && isset($rec['priority']))
                                <span style="
                                    display: inline-block;
                                    margin-top: 0.5rem;
                                    padding: 0.25rem 0.75rem;
                                    border-radius: 20px;
                                    font-size: 0.75rem;
                                    font-weight: 600;
                                    @if($rec['priority'] == 'high')
                                        background: #ffebee;
                                        color: #c62828;
                                    @elseif($rec['priority'] == 'medium')
                                        background: #fff3e0;
                                        color: #e65100;
                                    @else
                                        background: #e8f5e9;
                                        color: #2e7d32;
                                    @endif
                                ">
                                    {{ ucfirst($rec['priority']) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p style="color: #999; text-align: center; padding: 1rem;">
                        Aucune recommandation disponible pour le moment.
                    </p>
                @endforelse
            </div>

            <!-- Footer -->
            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; color: #999; font-size: 0.85rem;">
                <p style="margin: 0;">
                    <i class="material-icons" style="font-size: 1rem; vertical-align: middle;">lock</i>
                    Données anonymisées • Analyse basée sur vos mesures de santé
                </p>
            </div>
        </div>

    </div>
@endif
