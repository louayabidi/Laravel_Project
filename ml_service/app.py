from flask import Flask, request, jsonify
import joblib
from typing import Dict, List, Any
from datetime import datetime
import numpy as np
import logging

app = Flask(__name__)

model = joblib.load('objectif_predictor.joblib')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json

    features = [
        'avg_sommeil', 'avg_eau', 'avg_sport', 
        'avg_stress', 'avg_meditation', 'avg_ecran', 'avg_cafe'
    ]
    X = [[data.get(f, 0) for f in features]] 

    try:
        proba = model.predict_proba(X)[0][1]  
        return jsonify({'probability': round(proba * 100, 1)})
    except Exception as e:
        return jsonify({'error': str(e), 'probability': 0})
   
if __name__ == '__main__':
    app.run(debug=True, host='127.0.0.1', port=5001)
