from time import sleep

import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)

door_switch_pin = 23
motion_sensor_pin = 24

# Set up inputs
GPIO.setup(door_switch_pin, GPIO.IN)
GPIO.setup(motion_sensor_pin, GPIO.IN)

motion_LED_pin = 18
door_LED_pin = 25


prev_door = False

# sound files expect to be in the same directory as script
enter = pygame.mixer.Sound("./enter.wav")
exit = pygame.mixer.Sound("./exit.wav")

while True:
    # Update sensor and LED states each loop
    door = GPIO.input(door_switch_pin)
    motion = GPIO.input(motion_sensor_pin)

    # When the door is opened, if there is movement outside, it means that someone is entering. If not, someone is exiting
    if door and not prev_door:
        if motion:
            enter.play()
        else:
            exit.play()

    prev_door = door

    sleep(0.01)