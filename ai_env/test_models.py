#!/usr/bin/env python3
"""Test simple des modèles"""

import pickle
import os
import json

# Charger les modèles
models_dir = 'models'

with open(os.path.join(models_dir, 'rf_model.pkl'), 'rb') as f:
    rf_model = pickle.load(f)

with open(os.path.join(models_dir, 'gb_model.pkl'), 'rb') as f:
    gb_model = pickle.load(f)

with open(os.path.join(models_dir, 'label_encoder.pkl'), 'rb') as f:
    encoder = pickle.load(f)

print("\n" + "="*60)
print("✅ TEST DES MODÈLES")
print("="*60)

# Test data
test_data = [
    ([30, 142, 92, 86], "Diabète"),
    ([25, 160, 100, 90], "Hypertension"),
    ([22, 120, 80, 70], "Normal"),
]

for features, expected in test_data:
    print(f"\nTest: {expected}")
    print(f"Données: BMI={features[0]}, Tension Sys={features[1]}, Tension Dia={features[2]}, FC={features[3]}")
    
    # Prédictions
    rf_pred = rf_model.predict([features])[0]
    gb_pred = gb_model.predict([features])[0]
    
    rf_pred_name = encoder.inverse_transform([rf_pred])[0]
    gb_pred_name = encoder.inverse_transform([gb_pred])[0]
    
    # Probabilités
    rf_probs = rf_model.predict_proba([features])[0]
    gb_probs = gb_model.predict_proba([features])[0]
    
    # Ensemble
    ensemble_probs = (rf_probs + gb_probs) / 2
    ensemble_pred = ensemble_probs.argmax()
    ensemble_pred_name = encoder.inverse_transform([ensemble_pred])[0]
    ensemble_conf = ensemble_probs[ensemble_pred]
    
    print(f"  Random Forest: {rf_pred_name} ({rf_probs[rf_pred]:.1%})")
    print(f"  Gradient Boosting: {gb_pred_name} ({gb_probs[gb_pred]:.1%})")
    print(f"  Ensemble: {ensemble_pred_name} ({ensemble_conf:.1%})")
    print(f"  ✓ Correct: {ensemble_pred_name == expected}")

print("\n" + "="*60)
print("✅ TOUS LES TESTS SONT TERMINÉS!")
print("="*60 + "\n")
