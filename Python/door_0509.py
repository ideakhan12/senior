import RPi.GPIO as GPIO
import time
import json
import requests
import timeit

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

door_pin  = 21
pir_pin = 26

GPIO.setmode(GPIO.BCM)
GPIO.setup(pir_pin, GPIO.IN)
GPIO.setup(door_pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
count=0

#타이머 함수 사용 count 초기화 할것
#def timer(f):
#    start = timeit.default_timer()
#    함수
#    end = timeit.default_timer()
#    timer = end - start


def DoorSensor():
    while True:
        if GPIO.input(door_pin) == True:
            print("DOOR OPEN")
        else:
            break
        time.sleep(5)


def MotionSensor(pir_pin):
    global count

    if count >= 4 :
        print ("Motion Detected!")
        response = requests.post('https://fcm.googleapis.com/fcm/send', headers=headers, data=json.dumps(data))
        print (response)
        count = 0
    else:
        count += 1
        print ("count = %d" % count)
        time.sleep(2)


print("Smart Door System")
time.sleep(.5)
print("Ready")

try:
    GPIO.add_event_detect(door_pin, GPIO.RISING)
    GPIO.add_event_detect(pir_pin, GPIO.RISING)
    GPIO.add_event_callback(채널, my_callback_one)
    GPIO.add_event_callback(채널, my_callback_two)





    while True:
        if io.input(pir_pin):
            print("PIR ALARM!")
        if io.input(door_pin):
            print("DOOR ALARM!")
        time.sleep(0.5)






    if GPIO.intput(door_pin):
        GPIO.remove_event_detect(pir_pin)
        count = 0
        DoorSensor()
    if GPIO.input(pir_pin):
        MotionSensor()
    #GPIO.add_event_detect(pir_pin, GPIO.RISING, callback=MotionSensor)
    while 1:
        time.sleep(1)
except KeyboardInterrupt:
    print("Quit")
    GPIO.cleanup()


#except (GPIO.input(door_pin) != True):
#    DoorSensor()

#GPIO. 함수들 찾아볼 것


