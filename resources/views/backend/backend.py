from flask import Flask, request, jsonify
import base64
import io
import datetime
import numpy as np
import cv2
from PIL import Image
from io import BytesIO
from flask_cors import CORS
from ultralytics import YOLO  # Import YOLOv8 from ultralytics

# Initialize Flask app
app = Flask(__name__)
CORS(app)  # Enable Cross-Origin Resource Sharing

# Load YOLOv8 models
detection_model = YOLO('C:/project/model/ZOO-MANAGEMENT-12/ZOO-MANAGEMENT-12/runs/detect/train_zoo3/weights/best.pt')  # Update with your correct path
classification_model = YOLO('C:/project/model/Animal-Behavior-12/Animal-Behavior-12/runs/classify/train/weights/best.pt')  # Update with your correct path

# Function to decode the base64 image
def decode_image(base64_str):
    image_data = base64.b64decode(base64_str.split(',')[1])
    image = Image.open(BytesIO(image_data))
    return np.array(image)

# Function to process the image
def process_image(image):
    # Run object detection
    detection_results = detection_model(image)

    detections = []

    # Loop through each detection result
    for *xyxy, conf, cls in detection_results[0].boxes.data:
        animal_name = detection_model.names[int(cls)]  # Get the name of the animal from YOLO
        confidence = round(float(conf), 2)

        # Run classification model
        classification_result = classify_behavior(image)

        detections.append({
            "animal_name": animal_name,
            "confidence": confidence,
            "classification": classification_result
        })
    
    return detections

# Function to classify animal behavior using the classification model
def classify_behavior(image):
    classification_results = classification_model(image)
    classification_result = classification_results[0].probs.top1  # Get the top classification result
    return classification_model.names[classification_result]

# Route to process the camera feed
@app.route('/process-feed', methods=['POST'])
def process_feed():
    try:
        # Get the base64 image data from the request
        data = request.get_json()
        base64_image = data.get('image')
        
        # Decode the base64 image to an array
        img = decode_image(base64_image)
        
        # Process the image and get the detections
        detections = process_image(img)
        
        # Return the results
        return jsonify({"detections": detections})

    except Exception as e:
        print(f"Error: {e}")
        return jsonify({"error": "An error occurred"}), 500

# Run the Flask app
if __name__ == '__main__':
    app.run(debug=True)
