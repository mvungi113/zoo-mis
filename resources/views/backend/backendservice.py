import cv2
from datetime import datetime
from ultralytics import YOLO
import firebase_admin
from firebase_admin import credentials, db

# Firebase setup
cred = credentials.Certificate("C:/project/zoomis/resources/views/backend/zoomisapi-firebase.json")
if not firebase_admin._apps:
    firebase_admin.initialize_app(cred, {
        'databaseURL': 'https://zoomisapi-default-rtdb.firebaseio.com/'
    })

# Load YOLO models
animal_model = YOLO('C:/project/model/ZOO-MANAGEMENT-12/ZOO-MANAGEMENT-12/runs/detect/train_zoo3/weights/best.pt')
stress_model = YOLO('C:/project/model/Animal-Behavior-12/Animal-Behavior-12/runs/classify/train/weights/best.pt')

# Define behavior categories
hazard_behaviors = ["attacking", "cage scratching", "restricted zone", "aggressive", "animal escape attempt"]
warning_behaviors = ["visitor close", "user interacting with animal"]

# Start webcam
cap = cv2.VideoCapture(0)

while True:
    ret, frame = cap.read()
    if not ret:
        break

    try:
        results = animal_model(frame)
    except Exception as e:
        print("Animal model inference error:", e)
        continue

    for result in results:
        if not hasattr(result, 'boxes') or result.boxes is None:
            continue
        for box in result.boxes:
            x1, y1, x2, y2 = map(int, box.xyxy[0])
            cls = int(box.cls[0])
            detection_conf = float(box.conf[0]) if hasattr(box, 'conf') else 0.0

            animal_name = animal_model.names[cls].lower()
            cropped = frame[y1:y2, x1:x2]

            # Run stress classification
            try:
                stress_result = stress_model(cropped)
                stress_cls = int(stress_result[0].probs.top1)
                status = stress_model.names[stress_cls].lower()
                class_conf = float(stress_result[0].probs.data[stress_cls]) if hasattr(stress_result[0].probs, 'data') else 0.0
            except Exception as e:
                print("Stress model inference error:", e)
                status = "unknown"
                class_conf = 0.0

            label = f'{animal_name.capitalize()}: {status.capitalize()}'
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
                # Always log to zoo_logs
                db.reference("zoo_logs").push(log_data)
                print("Logged to zoo_logs:", log_data)

                # Handle notifications
                send_notification = False
                notification_type = None

                if animal_name == "injury":
                    # Always send hazard notification for Injury (no behavior classification check)
                    send_notification = True
                    notification_type = "Hazard"
                    status = "injury detected"  # Override status for clarity

                elif animal_name == "person":
                    # For Person, send notification only if behavior is warning and confidence thresholds met
                    if (status in warning_behaviors and detection_conf >= 0.8 and class_conf >= 0.8):
                        send_notification = True
                        notification_type = "Warning"

                else:
                    # For other animals, send notifications if hazard or warning with confidence thresholds
                    if (status in hazard_behaviors and detection_conf >= 0.8 and class_conf >= 0.8):
                        send_notification = True
                        notification_type = "Hazard"
                    elif (status in warning_behaviors and detection_conf >= 0.8 and class_conf >= 0.8):
                        send_notification = True
                        notification_type = "Warning"

                if send_notification:
                    notification_data = {
                        "type": notification_type,
                        "message": f"{status.capitalize()} detected for {animal_name.capitalize()}",
                        "animal_name": animal_name,
                        "classification": status,
                        "timestamp": timestamp,
                        "camera": "cam1",
                        "confidence": round(class_conf * 100, 2)
                    }
                    db.reference("notifications").push(notification_data)
                    print("Notification sent:", notification_data)

            except Exception as e:
                print("Firebase error:", e)

    cv2.imshow("Zoo Surveillance", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()
