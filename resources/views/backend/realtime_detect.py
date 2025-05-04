import cv2
import requests
from datetime import datetime
from ultralytics import YOLO

# Load both YOLO models
animal_model = YOLO('C:/project/model/ZOO-MANAGEMENT-12/ZOO-MANAGEMENT-12/runs/detect/train_zoo3/weights/best.pt')
stress_model = YOLO('C:/project/model/Animal-Behavior-12/Animal-Behavior-12/runs/classify/train/weights/best.pt')

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
            animal_name = animal_model.names[cls]

            # Crop detected animal region
            cropped = frame[y1:y2, x1:x2]

            # Run stress classification
            stress_result = stress_model(cropped)
            stress_cls = int(stress_result[0].probs.top1)
            status = stress_model.names[stress_cls]

            # Draw on frame
            label = f'{animal_name}: {status}'
            cv2.rectangle(frame, (x1, y1), (x2, y2), (0,255,0), 2)
            cv2.putText(frame, label, (x1, y1 - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 255, 0), 2)

            # Extract confidence value
            confidence_value = float(box.conf[0])

            # Send data to Laravel
            data = {
                "camera": "cam1",
                "animal": animal_name,
                "status": status,
                "confidence": confidence_value,
            }

            try:
                requests.post("http://127.0.0.1:8000/api/logs", json=data)
            except:
                print("Failed to send to Laravel")

    # Show frame
    cv2.imshow("Zoo Surveillance", frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()
