import cv2
from datetime import datetime
from ultralytics import YOLO
import firebase_admin
from firebase_admin import credentials, db

# Initialize Firebase
cred = credentials.Certificate("C:/project/zoomis/resources/views/backend/zoomisapi-firebase.json")
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://zoomisapi-default-rtdb.firebaseio.com/'
})

# Load YOLO models
animal_model = YOLO('C:/project/model/ZOO-MANAGEMENT-12/ZOO-MANAGEMENT-12/runs/detect/train_zoo3/weights/best.pt')
stress_model = YOLO('C:/project/model/Animal-Behavior-12/Animal-Behavior-12/runs/classify/train/weights/best.pt')

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
            confidence = float(box.conf[0])  # Get confidence

            animal_name = animal_model.names[cls]
            cropped = frame[y1:y2, x1:x2]

            # Stress classification
            stress_result = stress_model(cropped)
            stress_cls = int(stress_result[0].probs.top1)
            status = stress_model.names[stress_cls]

            label = f'{animal_name}: {status}'
            cv2.rectangle(frame, (x1, y1), (x2, y2), (0,255,0), 2)
            cv2.putText(frame, label, (x1, y1 - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

            # Prepare log data
            data = {
                "created_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
                "animal_name": animal_name,
                "confidence": round(confidence * 100, 2),  # convert to %
                "classification": status,
                "camera": "cam1"
            }

            try:
                db.reference("zoo_logs").push(data)
                print("Sent to Firebase:", data)
            except Exception as e:
                print("Firebase error:", e)

    cv2.imshow("Zoo Surveillance", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()
