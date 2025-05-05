import cv2
from datetime import datetime
from ultralytics import YOLO
import firebase_admin
from firebase_admin import credentials, db

# Firebase setup
cred = credentials.Certificate("C:/project/zoomis/resources/views/backend/zoomisapi-firebase.json")
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://zoomisapi-default-rtdb.firebaseio.com/'
})

# Load YOLO models
animal_model = YOLO('C:/project/model/ZOO-MANAGEMENT-12/ZOO-MANAGEMENT-12/runs/detect/train_zoo3/weights/best.pt')
stress_model = YOLO('C:/project/model/Animal-Behavior-12/Animal-Behavior-12/runs/classify/train/weights/best.pt')

# Define behavior categories
hazard_behaviors = ["Attacking", "Cage Scratching", "Restricted Zone", "Aggressive", "animal escape attempt"]
warning_behaviors = ["Visitor Close", "User Interacting With Animal"]

# Start webcam
cap = cv2.VideoCapture(0)

while True:
    ret, frame = cap.read()
    if not ret:
        break

    results = animal_model(frame)

    for result in results:
        for box in result.boxes:
            x1, y1, x2, y2 = map(int, box.xyxy[0])
            cls = int(box.cls[0])
            detection_conf = float(box.conf[0])  # confidence of object detection

            animal_name = animal_model.names[cls]
            cropped = frame[y1:y2, x1:x2]

            # Run stress classification
            stress_result = stress_model(cropped)
            stress_cls = int(stress_result[0].probs.top1)
            status = stress_model.names[stress_cls]
            class_conf = float(stress_result[0].probs.data[stress_cls])  # classification confidence

            label = f'{animal_name}: {status}'
            cv2.rectangle(frame, (x1, y1), (x2, y2), (0, 255, 0), 2)
            cv2.putText(frame, label, (x1, y1 - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

            # Prepare log data
            timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            log_data = {
                "created_at": timestamp,
                "animal_name": animal_name,
                "confidence": round(detection_conf * 100, 2),
                "classification": status,
                "camera": "cam1"
            }

            try:
                # Push to zoo_logs (always)
                db.reference("zoo_logs").push(log_data)

                # Push to notifications if confidence ≥ 0.5 and hazard/warning
                if class_conf >= 0.5 and (status in hazard_behaviors or status in warning_behaviors):
                    notification_type = "Hazard" if status in hazard_behaviors else "Warning"
                    db.reference("notifications").push({
                        "type": notification_type,
                        "message": f"{status} detected for {animal_name}",
                        "animal_name": animal_name,
                        "classification": status,
                        "timestamp": timestamp,
                        "camera": "cam1",
                        "confidence": round(class_conf * 100, 2)
                    })

                print("Logged:", log_data)
            except Exception as e:
                print("Firebase error:", e)

    cv2.imshow("Zoo Surveillance", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()
