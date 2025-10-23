#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import json
import subprocess
import sys

# Test data
test_data = {
    "bmi": 30,
    "tension_systolique": 142,
    "tension_diastolique": 92,
    "freq_cardiaque": 86
}

# Call the prediction script
result = subprocess.run([
    sys.executable,
    'ai_env/predict_ensemble_simple.py',
    json.dumps(test_data),
    'ai_env/models'
], capture_output=True, text=True)

print("STDOUT:")
print(result.stdout)
print("\nSTDERR:")
print(result.stderr)
print("\nReturn code:", result.returncode)
