#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Script de prédiction simplifié - Ensemble de modèles (RF + GB)
Sans dépendance TensorFlow
"""

import json
import pickle
import sys
import os
import numpy as np
import warnings
warnings.filterwarnings('ignore')

# Fix encoding issues on Windows
if sys.platform == 'win32':
    import io
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def load_models(model_dir):
    """Charger tous les modèles et les encoders"""
    try:
        # Random Forest
        with open(os.path.join(model_dir, 'rf_model.pkl'), 'rb') as f:
            rf_model = pickle.load(f)
        
        # Gradient Boosting
        with open(os.path.join(model_dir, 'gb_model.pkl'), 'rb') as f:
            gb_model = pickle.load(f)
        
        # Label Encoder
        with open(os.path.join(model_dir, 'label_encoder.pkl'), 'rb') as f:
            encoder = pickle.load(f)
        
        # Scaler
        with open(os.path.join(model_dir, 'scaler.pkl'), 'rb') as f:
            scaler = pickle.load(f)
        
        # Feature names
        with open(os.path.join(model_dir, 'feature_names.pkl'), 'rb') as f:
            feature_names = pickle.load(f)
        
        return rf_model, gb_model, encoder, scaler, feature_names
    except Exception as e:
        raise Exception(f"Erreur lors du chargement des modèles: {str(e)}")

def predict_ensemble(health_data, rf_model, gb_model, encoder, scaler):
    """Prédire avec l'ensemble de modèles"""
    # Extraire les features
    bmi = health_data.get('bmi', 25)
    sys_bp = health_data.get('tension_systolique', 120)
    dia_bp = health_data.get('tension_diastolique', 80)
    hr = health_data.get('freq_cardiaque', 70)
    
    X = np.array([[bmi, sys_bp, dia_bp, hr]])
    
    # Prédictions individuelles
    rf_pred = rf_model.predict(X)[0]
    gb_pred = gb_model.predict(X)[0]
    
    # Probabilités
    rf_probs = rf_model.predict_proba(X)[0]
    gb_probs = gb_model.predict_proba(X)[0]
    
    # Vote pondéré (poids égaux pour chaque modèle)
    ensemble_probs = (rf_probs + gb_probs) / 2
    ensemble_pred = np.argmax(ensemble_probs)
    ensemble_confidence = ensemble_probs[ensemble_pred]
    
    # Décoder la prédiction
    condition = encoder.inverse_transform([ensemble_pred])[0]
    
    # Si l'utilisateur a sélectionné un type de régime spécifique, utiliser celui-ci
    regime_type = health_data.get('regime_type')
    if regime_type and regime_type != 'Normal':
        condition = regime_type
    
    return {
        'condition': condition,
        'confidence': float(ensemble_confidence),
        'ensemble_probs': ensemble_probs.tolist(),
        'rf_pred': encoder.inverse_transform([rf_pred])[0],
        'gb_pred': encoder.inverse_transform([gb_pred])[0],
        'rf_confidence': float(rf_probs[rf_pred]),
        'gb_confidence': float(gb_probs[gb_pred])
    }

def calculate_feature_importance(health_data, rf_model, gb_model, feature_names):
    """Calculer l'importance des features"""
    # Importance du Random Forest
    rf_importance = rf_model.feature_importances_
    
    # Importance du Gradient Boosting
    gb_importance = gb_model.feature_importances_
    
    # Moyenne des importances
    avg_importance = (rf_importance + gb_importance) / 2
    
    # Normaliser
    avg_importance = avg_importance / avg_importance.sum()
    
    importance_dict = {}
    for i, name in enumerate(feature_names):
        importance_dict[name] = float(avg_importance[i])
    
    return importance_dict

def generate_explanation(prediction_result, health_data, feature_importance):
    """Générer une explication textuelle"""
    condition = prediction_result['condition']
    confidence = prediction_result['confidence']
    
    # Déterminer le facteur le plus important
    top_feature = max(feature_importance, key=feature_importance.get)
    
    explanation = f"Le modèle prédit '{condition}' avec une confiance de {confidence*100:.1f}%. "
    explanation += f"Le facteur le plus influent est '{top_feature}'. "
    
    # Ajouter des détails basés sur la condition
    if condition == "Diabète":
        explanation += "Cette condition est généralement associée à un IMC élevé et une tension artérielle élevée."
    elif condition == "Hypertension":
        explanation += "Cette condition est caractérisée par une tension artérielle élevée."
    elif condition == "Normal":
        explanation += "Vos paramètres de santé sont dans les normes acceptables."
    
    return explanation

def main():
    try:
        # Récupérer les arguments
        if len(sys.argv) < 3:
            raise ValueError("Usage: python predict_ensemble_simple.py <health_data_json> <model_dir>")
        
        health_data_json = sys.argv[1]
        model_dir = sys.argv[2]
        
        # Parser les données de santé
        health_data = json.loads(health_data_json)
        
        # Charger les modèles
        rf_model, gb_model, encoder, scaler, feature_names = load_models(model_dir)
        
        # Faire la prédiction
        prediction = predict_ensemble(health_data, rf_model, gb_model, encoder, scaler)
        
        # Calculer l'importance des features
        feature_importance = calculate_feature_importance(health_data, rf_model, gb_model, feature_names)
        
        # Générer une explication
        explanation = generate_explanation(prediction, health_data, feature_importance)
        
        # Préparer la réponse
        response = {
            'success': True,
            'predicted_condition': prediction['condition'],
            'confidence': prediction['confidence'],
            'confidence_percent': prediction['confidence'] * 100,
            'individual_predictions': {
                'random_forest': {
                    'prediction': prediction['rf_pred'],
                    'confidence': prediction['rf_confidence']
                },
                'gradient_boosting': {
                    'prediction': prediction['gb_pred'],
                    'confidence': prediction['gb_confidence']
                }
            },
            'feature_importance': feature_importance,
            'explanation': explanation,
            'recommendations': [
                {
                    'type': 'health',
                    'message': explanation,
                    'priority': 'high' if prediction['confidence'] > 0.8 else 'medium',
                    'source': 'ensemble_model'
                }
            ]
        }
        
        # Afficher le résultat en JSON
        print(json.dumps(response, ensure_ascii=False, indent=2))
        
    except Exception as e:
        error_response = {
            'success': False,
            'error': str(e)
        }
        print(json.dumps(error_response, ensure_ascii=False))
        sys.exit(1)

if __name__ == '__main__':
    main()
