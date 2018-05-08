import RPi.GPIO as GPIO
import time
import json
import requests

headers = {
    'Authorization': 'key= AAAAVjUAzTk:APA91bFpZLbUpXYTCV-wOXYZyG9RIKnhkZlVu1zOHnsFglpDSyQm-tEEZSAylVDcPzin4_nz3LXFUbJlLDH9Fhkk2ZPPdvqvgiJfyxDW_J2cY8uYQlsXfDZZjuJpUEEfNR1Yr9bPCkEI',
    'Content-Type': 'application/json',
}


data = {
    'to': '/topics/bell',
    'data': {
        'title': '외부인 접근 알림',
        'body': 'SMART DOOR SYSTEM',
    }
}

GPIO.setmode(GPIO.BCM)
pirPin = 26
GPIO.setup(pirPin, GPIO.IN)
count=0

#def DoorSensor():
    #문이 열리면 닫힐 때까지 아무 일도 안하는 코드


def MotionSensor(pirPin): #함수 안에 try except 예외처리 되나?
	global count

    #try:
	if count >= 4 :
		print ("Motion Detected!")
		response = requests.post('https://fcm.googleapis.com/fcm/send', headers=headers, data=json.dumps(data))
		print (response)
		count = 0
	else:
		count += 1
		print ("count = %d" % count)
		time.sleep(2)
    #except 마그네틱 도어센서사용 문이 열리면 모션 함수 빠져나와서 :

        #마그네틱 도어센서 함수 호출


print("Motion Sensor Alarm")
time.sleep(1)
print("Ready")

try:
    GPIO.add_event_detect(pirPin, GPIO.RISING, callback=MotionSensor)
    while 1:
        time.sleep(1)
except KeyboardInterrupt:
    print("Quit")
    GPIO.cleanup()
