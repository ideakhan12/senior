import time
import RPi.GPIO as GPIO


door_pin  = 21
GPIO.setmode(GPIO.BCM)
GPIO.setup(door_pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
while True:
	if GPIO.input(door_pin)==True:
		print("DOOR ALARM!")
	time.sleep(1)