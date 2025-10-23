#!/usr/bin/env python3
"""
Script d'entraînement d'un ensemble de modèles IA pour recommandations de santé
Modèles: Random Forest + Gradient Boosting + Neural Network
Avec explainability via SHAP
"""

import json
import pickle
import os
import numpy as np
from sklearn.ensemble import RandomForestClassifier, GradientBoostingClassifier
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.model_selection import cross_val_score, train_test_split
from sklearn.metrics import classification_report, confusion_matrix, accuracy_score
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout
from tensorflow.keras.optimizers import Adam
import warnings
warnings.filterwarnings('ignore')

# Données d'entraînement (même que avant)
training_data = [
    # Diabète (12 samples)
    {"bmi": 28, "blood_pressure_sys": 140, "blood_pressure_dia": 90, "heart_rate": 85, "condition": "Diabète"},
    {"bmi": 32, "blood_pressure_sys": 145, "blood_pressure_dia": 95, "heart_rate": 88, "condition": "Diabète"},
    {"bmi": 26, "blood_pressure_sys": 135, "blood_pressure_dia": 85, "heart_rate": 80, "condition": "Diabète"},
    {"bmi": 30, "blood_pressure_sys": 142, "blood_pressure_dia": 92, "heart_rate": 86, "condition": "Diabète"},
    {"bmi": 29, "blood_pressure_sys": 138, "blood_pressure_dia": 88, "heart_rate": 84, "condition": "Diabète"},
    {"bmi": 33, "blood_pressure_sys": 148, "blood_pressure_dia": 96, "heart_rate": 90, "condition": "Diabète"},
    {"bmi": 27, "blood_pressure_sys": 136, "blood_pressure_dia": 86, "heart_rate": 81, "condition": "Diabète"},
    {"bmi": 31, "blood_pressure_sys": 144, "blood_pressure_dia": 94, "heart_rate": 87, "condition": "Diabète"},
    {"bmi": 28, "blood_pressure_sys": 139, "blood_pressure_dia": 89, "heart_rate": 83, "condition": "Diabète"},
    {"bmi": 32, "blood_pressure_sys": 146, "blood_pressure_dia": 93, "heart_rate": 89, "condition": "Diabète"},
    {"bmi": 26, "blood_pressure_sys": 134, "blood_pressure_dia": 84, "heart_rate": 79, "condition": "Diabète"},
    {"bmi": 30, "blood_pressure_sys": 141, "blood_pressure_dia": 91, "heart_rate": 85, "condition": "Diabète"},
    
    # Hypertension (12 samples)
    {"bmi": 24, "blood_pressure_sys": 160, "blood_pressure_dia": 100, "heart_rate": 90, "condition": "Hypertension"},
    {"bmi": 25, "blood_pressure_sys": 155, "blood_pressure_dia": 98, "heart_rate": 88, "condition": "Hypertension"},
    {"bmi": 23, "blood_pressure_sys": 150, "blood_pressure_dia": 95, "heart_rate": 85, "condition": "Hypertension"},
    {"bmi": 26, "blood_pressure_sys": 162, "blood_pressure_dia": 102, "heart_rate": 92, "condition": "Hypertension"},
    {"bmi": 24, "blood_pressure_sys": 158, "blood_pressure_dia": 99, "heart_rate": 89, "condition": "Hypertension"},
    {"bmi": 27, "blood_pressure_sys": 165, "blood_pressure_dia": 104, "heart_rate": 94, "condition": "Hypertension"},
    {"bmi": 22, "blood_pressure_sys": 148, "blood_pressure_dia": 93, "heart_rate": 83, "condition": "Hypertension"},
    {"bmi": 25, "blood_pressure_sys": 159, "blood_pressure_dia": 100, "heart_rate": 90, "condition": "Hypertension"},
    {"bmi": 23, "blood_pressure_sys": 151, "blood_pressure_dia": 96, "heart_rate": 86, "condition": "Hypertension"},
    {"bmi": 26, "blood_pressure_sys": 164, "blood_pressure_dia": 103, "heart_rate": 93, "condition": "Hypertension"},
    {"bmi": 24, "blood_pressure_sys": 157, "blood_pressure_dia": 98, "heart_rate": 88, "condition": "Hypertension"},
    
    # Grossesse (10 samples)
    {"bmi": 26, "blood_pressure_sys": 130, "blood_pressure_dia": 85, "heart_rate": 80, "condition": "Grossesse"},
    {"bmi": 27, "blood_pressure_sys": 135, "blood_pressure_dia": 88, "heart_rate": 82, "condition": "Grossesse"},
    {"bmi": 25, "blood_pressure_sys": 128, "blood_pressure_dia": 83, "heart_rate": 78, "condition": "Grossesse"},
    {"bmi": 28, "blood_pressure_sys": 132, "blood_pressure_dia": 86, "heart_rate": 81, "condition": "Grossesse"},
    {"bmi": 26, "blood_pressure_sys": 129, "blood_pressure_dia": 84, "heart_rate": 79, "condition": "Grossesse"},
    {"bmi": 27, "blood_pressure_sys": 134, "blood_pressure_dia": 87, "heart_rate": 81, "condition": "Grossesse"},
    {"bmi": 25, "blood_pressure_sys": 127, "blood_pressure_dia": 82, "heart_rate": 77, "condition": "Grossesse"},
    {"bmi": 28, "blood_pressure_sys": 133, "blood_pressure_dia": 86, "heart_rate": 80, "condition": "Grossesse"},
    {"bmi": 26, "blood_pressure_sys": 130, "blood_pressure_dia": 85, "heart_rate": 79, "condition": "Grossesse"},
    {"bmi": 27, "blood_pressure_sys": 135, "blood_pressure_dia": 88, "heart_rate": 82, "condition": "Grossesse"},
    
    # Cholestérol élevé (12 samples)
    {"bmi": 27, "blood_pressure_sys": 130, "blood_pressure_dia": 80, "heart_rate": 75, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 29, "blood_pressure_sys": 135, "blood_pressure_dia": 85, "heart_rate": 78, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 28, "blood_pressure_sys": 132, "blood_pressure_dia": 82, "heart_rate": 76, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 30, "blood_pressure_sys": 138, "blood_pressure_dia": 87, "heart_rate": 80, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 27, "blood_pressure_sys": 131, "blood_pressure_dia": 81, "heart_rate": 76, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 29, "blood_pressure_sys": 136, "blood_pressure_dia": 86, "heart_rate": 79, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 28, "blood_pressure_sys": 133, "blood_pressure_dia": 83, "heart_rate": 77, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 30, "blood_pressure_sys": 139, "blood_pressure_dia": 88, "heart_rate": 81, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 27, "blood_pressure_sys": 130, "blood_pressure_dia": 80, "heart_rate": 75, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 29, "blood_pressure_sys": 134, "blood_pressure_dia": 84, "heart_rate": 77, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 28, "blood_pressure_sys": 131, "blood_pressure_dia": 81, "heart_rate": 76, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    {"bmi": 30, "blood_pressure_sys": 137, "blood_pressure_dia": 86, "heart_rate": 79, "condition": "Cholestérol élevé (hypercholestérolémie)"},
    
    # Maladie cœliaque (10 samples)
    {"bmi": 20, "blood_pressure_sys": 118, "blood_pressure_dia": 76, "heart_rate": 68, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 21, "blood_pressure_sys": 120, "blood_pressure_dia": 78, "heart_rate": 70, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 19, "blood_pressure_sys": 116, "blood_pressure_dia": 74, "heart_rate": 66, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 20, "blood_pressure_sys": 119, "blood_pressure_dia": 77, "heart_rate": 69, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 21, "blood_pressure_sys": 121, "blood_pressure_dia": 79, "heart_rate": 71, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 19, "blood_pressure_sys": 117, "blood_pressure_dia": 75, "heart_rate": 67, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 20, "blood_pressure_sys": 118, "blood_pressure_dia": 76, "heart_rate": 68, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 21, "blood_pressure_sys": 120, "blood_pressure_dia": 78, "heart_rate": 70, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 19, "blood_pressure_sys": 116, "blood_pressure_dia": 74, "heart_rate": 66, "condition": "Maladie cœliaque (intolérance au gluten)"},
    {"bmi": 20, "blood_pressure_sys": 119, "blood_pressure_dia": 77, "heart_rate": 69, "condition": "Maladie cœliaque (intolérance au gluten)"},
    
    # Insuffisance rénale (10 samples)
    {"bmi": 25, "blood_pressure_sys": 145, "blood_pressure_dia": 92, "heart_rate": 82, "condition": "Insuffisance rénale"},
    {"bmi": 26, "blood_pressure_sys": 150, "blood_pressure_dia": 95, "heart_rate": 85, "condition": "Insuffisance rénale"},
    {"bmi": 24, "blood_pressure_sys": 142, "blood_pressure_dia": 90, "heart_rate": 80, "condition": "Insuffisance rénale"},
    {"bmi": 27, "blood_pressure_sys": 152, "blood_pressure_dia": 97, "heart_rate": 87, "condition": "Insuffisance rénale"},
    {"bmi": 25, "blood_pressure_sys": 146, "blood_pressure_dia": 93, "heart_rate": 83, "condition": "Insuffisance rénale"},
    {"bmi": 26, "blood_pressure_sys": 149, "blood_pressure_dia": 94, "heart_rate": 84, "condition": "Insuffisance rénale"},
    {"bmi": 24, "blood_pressure_sys": 143, "blood_pressure_dia": 91, "heart_rate": 81, "condition": "Insuffisance rénale"},
    {"bmi": 27, "blood_pressure_sys": 151, "blood_pressure_dia": 96, "heart_rate": 86, "condition": "Insuffisance rénale"},
    {"bmi": 25, "blood_pressure_sys": 144, "blood_pressure_dia": 91, "heart_rate": 81, "condition": "Insuffisance rénale"},
    {"bmi": 26, "blood_pressure_sys": 148, "blood_pressure_dia": 93, "heart_rate": 83, "condition": "Insuffisance rénale"},
    
    # Normal (10 samples)
    {"bmi": 22, "blood_pressure_sys": 120, "blood_pressure_dia": 80, "heart_rate": 70, "condition": "Normal"},
    {"bmi": 21, "blood_pressure_sys": 118, "blood_pressure_dia": 78, "heart_rate": 68, "condition": "Normal"},
    {"bmi": 23, "blood_pressure_sys": 122, "blood_pressure_dia": 82, "heart_rate": 72, "condition": "Normal"},
    {"bmi": 22, "blood_pressure_sys": 119, "blood_pressure_dia": 79, "heart_rate": 69, "condition": "Normal"},
    {"bmi": 21, "blood_pressure_sys": 117, "blood_pressure_dia": 77, "heart_rate": 67, "condition": "Normal"},
    {"bmi": 23, "blood_pressure_sys": 121, "blood_pressure_dia": 81, "heart_rate": 71, "condition": "Normal"},
    {"bmi": 22, "blood_pressure_sys": 120, "blood_pressure_dia": 80, "heart_rate": 70, "condition": "Normal"},
    {"bmi": 21, "blood_pressure_sys": 118, "blood_pressure_dia": 78, "heart_rate": 68, "condition": "Normal"},
    {"bmi": 23, "blood_pressure_sys": 122, "blood_pressure_dia": 82, "heart_rate": 72, "condition": "Normal"},
    {"bmi": 22, "blood_pressure_sys": 119, "blood_pressure_dia": 79, "heart_rate": 69, "condition": "Normal"},
]

# Préparer les données
X = np.array([[d["bmi"], d["blood_pressure_sys"], d["blood_pressure_dia"], d["heart_rate"]] for d in training_data])
y = np.array([d["condition"] for d in training_data])

# Encoder les labels
le = LabelEncoder()
y_encoded = le.fit_transform(y)

# Normaliser les features pour le Neural Network
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Créer le dossier models s'il n'existe pas
models_dir = os.path.join(os.path.dirname(__file__), 'models')
os.makedirs(models_dir, exist_ok=True)

print("\n" + "="*60)
print(" ENTRAÎNEMENT DE L'ENSEMBLE DE MODÈLES")
print("="*60)

# ============ 1. RANDOM FOREST ============
print("\n 1. Entraînement du Random Forest...")
rf_model = RandomForestClassifier(
    n_estimators=200,
    max_depth=10,
    min_samples_split=5,
    min_samples_leaf=2,
    random_state=42,
    n_jobs=-1,
    class_weight='balanced'
)
rf_model.fit(X, y_encoded)
rf_score = rf_model.score(X, y_encoded)
print(f"   ✓ Précision (train): {rf_score:.2%}")

# ============ 2. GRADIENT BOOSTING ============
print("\n 2. Entraînement du Gradient Boosting...")
gb_model = GradientBoostingClassifier(
    n_estimators=150,
    learning_rate=0.1,
    max_depth=5,
    min_samples_split=5,
    min_samples_leaf=2,
    random_state=42,
    subsample=0.8
)
gb_model.fit(X, y_encoded)
gb_score = gb_model.score(X, y_encoded)
print(f"   ✓ Précision (train): {gb_score:.2%}")

# ============ 3. NEURAL NETWORK ============
print("\n 3. Entraînement du Neural Network...")
nn_model = Sequential([
    Dense(64, activation='relu', input_shape=(4,)),
    Dropout(0.3),
    Dense(32, activation='relu'),
    Dropout(0.3),
    Dense(16, activation='relu'),
    Dense(len(np.unique(y_encoded)), activation='softmax')
])

nn_model.compile(
    optimizer=Adam(learning_rate=0.001),
    loss='sparse_categorical_crossentropy',
    metrics=['accuracy']
)

nn_model.fit(
    X_scaled, y_encoded,
    epochs=100,
    batch_size=8,
    verbose=0,
    validation_split=0.2
)

nn_score = nn_model.evaluate(X_scaled, y_encoded, verbose=0)[1]
print(f"   ✓ Précision (train): {nn_score:.2%}")

# ============ SAUVEGARDER LES MODÈLES ============
print("\n Sauvegarde des modèles...")

# Random Forest
with open(os.path.join(models_dir, 'rf_model.pkl'), 'wb') as f:
    pickle.dump(rf_model, f)

# Gradient Boosting
with open(os.path.join(models_dir, 'gb_model.pkl'), 'wb') as f:
    pickle.dump(gb_model, f)

# Neural Network
nn_model.save(os.path.join(models_dir, 'nn_model.h5'))

# Label Encoder
with open(os.path.join(models_dir, 'label_encoder.pkl'), 'wb') as f:
    pickle.dump(le, f)

# Scaler
with open(os.path.join(models_dir, 'scaler.pkl'), 'wb') as f:
    pickle.dump(scaler, f)

# Feature names
feature_names = ['BMI', 'Tension Systolique', 'Tension Diastolique', 'Fréquence Cardiaque']
with open(os.path.join(models_dir, 'feature_names.pkl'), 'wb') as f:
    pickle.dump(feature_names, f)

print(f"   ✓ Random Forest sauvegardé")
print(f"   ✓ Gradient Boosting sauvegardé")
print(f"   ✓ Neural Network sauvegardé")
print(f"   ✓ Label Encoder sauvegardé")
print(f"   ✓ Scaler sauvegardé")
print(f"   ✓ Feature names sauvegardés")

# ============ RÉSUMÉ ============
print("\n" + "="*60)
print(" RÉSUMÉ DES PERFORMANCES")
print("="*60)
print(f"Random Forest:      {rf_score:.2%}")
print(f"Gradient Boosting:  {gb_score:.2%}")
print(f"Neural Network:     {nn_score:.2%}")
print(f"Moyenne:            {(rf_score + gb_score + nn_score) / 3:.2%}")
print("\n Ensemble de modèles entraîné avec succès!")
print("="*60)
