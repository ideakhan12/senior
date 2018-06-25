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
import demand
import weather
import delivery


door_pin  = 21
pir_pin = 26

GPIO.setmode(GPIO.BCM)
GPIO.setup(pir_pin, GPIO.IN)
GPIO.setup(door_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)
timer_count=0
door_count=0

#스위치 도어 센서 작동
def DoorSensor():
    global door_count
    door_count += 1
    while True:
        #문열림 감지시 날씨 알림과 요구사항 데이터 음성 출력
        if door_count == 1:
            weather_len = weather.tts_weather()
            time.sleep(weather_len/8)
            demand.demand()
            door_count = door_count + 1
            delivery.crawling_main()
        elif door_count > 1:
            break
        elif GPIO.input(door_pin) == 0:
            door_count = 0
            break
        time.sleep(5)

