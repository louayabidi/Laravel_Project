import os
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score, roc_auc_score
import joblib

csv_path = '../storage/app/private/datasets/objectifs_dataset1.csv'

if not os.path.exists(csv_path):
    raise FileNotFoundError(f"Le fichier CSV n'existe pas : {csv_path}")

df = pd.read_csv(csv_path)

features = ['avg_sommeil','avg_eau','avg_sport','avg_stress','avg_meditation','avg_ecran','avg_cafe']


X = df[features].fillna(0)
y = df['achieved']

X_train, X_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, random_state=42, stratify=y
)

model = RandomForestClassifier(n_estimators=200, random_state=42)
model.fit(X_train, y_train)


y_pred = model.predict(X_test)
y_proba = model.predict_proba(X_test)[:, 1]
print("Accuracy:", accuracy_score(y_test, y_pred))
print("ROC AUC:", roc_auc_score(y_test, y_proba))

joblib.dump(model, 'objectif_predictor.joblib')
print("Model saved to objectif_predictor.joblib")
