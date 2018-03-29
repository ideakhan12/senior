import time
import RPi.GPIO as GPIO


PIN  = 12
GPIO.setmode(GPIO.BOARD)
GPIO.setup(PIN, GPIO.IN, pull_up_down=GPIO.PUD_UP)
while True:
	if GPIO.input(PIN)==True:
		print("DOOR ALARM!")
	time.sleep(1)
