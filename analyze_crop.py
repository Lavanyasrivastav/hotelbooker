import sys
import json

image_path = sys.argv[1]

# TODO: Load your AI model here and analyze image
# For demo, returning dummy result
result = {
    "diagnosis": "Powdery Mildew",
    "recommendation": "Spray sulfur-based fungicide, ensure good ventilation.",
    "organic": "Apply neem oil spray every 10 days."
}

print(json.dumps(result))
