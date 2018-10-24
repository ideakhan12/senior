import RPi.GPIO as GPIO
import time
import json
import requests
import timeit
import os
import datetime
import pytz
import urllib.request
import pygame
from gtts import gTTS
from datetime import datetime
import switch_sensor
import main

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
GPIO.setup(door_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)
count = 0
timer_count = 0
word = 0 # sleep word count

#PIR 모션 센서 작동
def MotionSensor():
    global count
    global timer_count
    try:
        # 2초 간격으로 모션센서 작동 count증가, count가 3이상일 경우 푸시 알람
        if count >= 2 :
            print ("Motion Detected!")
            response = requests.post('https://fcm.googleapis.com/fcm/send', headers=headers, data=json.dumps(data))
            print (response)
            count = 0
            timer_count = 0
        else:
            count += 1
            print ("count = %d" % count)
            timer_count = 0
            time.sleep(2)
    # 모션 감지 도중 문열림 감지시 스위치 도어 센서 함수 호출
    except GPIO.add_event_detect(door_pin, GPIO.RISING):
        GPIO.add_event_callback(door_pin, switch_sensor.DoorSensor())