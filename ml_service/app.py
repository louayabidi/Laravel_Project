from flask import Flask, request, jsonify
import joblib

app = Flask(__name__)

# Charger le modèle
model = joblib.load('objectif_predictor.joblib')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json

    # Vérifier les clés et compléter les valeurs manquantes
    features = [
        'avg_sommeil', 'avg_eau', 'avg_sport', 
        'avg_stress', 'avg_meditation', 'avg_ecran', 'avg_cafe'
    ]
    X = [[data.get(f, 0) for f in features]]  # mettre 0 si manquant

    try:
        proba = model.predict_proba(X)[0][1]  # probabilité de succès
        return jsonify({'probability': round(proba * 100, 1)})
    except Exception as e:
        return jsonify({'error': str(e), 'probability': 0})
    
if __name__ == '__main__':
    app.run(debug=True, host='127.0.0.1', port=5001)
