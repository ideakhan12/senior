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
import pir_sensor


door_pin  = 21
pir_pin = 26

GPIO.setmode(GPIO.BCM)
GPIO.setup(pir_pin, GPIO.IN)
GPIO.setup(door_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

if __name__ == '__main__':
    print("Smart Door System")
    time.sleep(.5)
    print("Ready")

    try:
        while True:
            if GPIO.input(door_pin) == 0:
                switch_sensor.door_count = 0
            if pir_sensor.timer_count == 15:
                switch_sensor.count = 0
                pir_sensor.timer_count = 0
            if GPIO.input(door_pin):
                pir_sensor.count = 0
                switch_sensor.DoorSensor()
            if GPIO.input(pir_pin):
                pir_sensor.MotionSensor()
            time.sleep(1)
            pir_sensor.timer_count += 1
    #종료 예외처리
    except KeyboardInterrupt:
        print("Quit")
        GPIO.cleanup()
