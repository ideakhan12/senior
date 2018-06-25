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


def demand():
    try:
        params = {'id': 'test'}
        res = requests.post('http://52.79.133.253/demand.php', data=params)
        text = res.text.encode('utf8')[3:].decode('utf8')
        
        now = datetime.strptime(datetime.now().strftime("%Y-%m-%d %H:%M:%S"), '%Y-%m-%d %H:%M:%S')

        data = json.loads(text)
        text = ""

        for d in data:
            s_date = datetime.strptime(d['s_date'], '%Y-%m-%d %H:%M:%S')
            e_date = datetime.strptime(d['e_date'], '%Y-%m-%d %H:%M:%S')

            if (now > s_date) and (now < e_date):
                text = text + d['text'] + " ″"
        text = "금일 일정은" + "," + text + "입니다."

        tts = gTTS(text=text, lang='ko')
        
        tts.save("input_test2.mp3")
        print(text)
        
        pygame.mixer.init()
        pygame.mixer.music.load("input_test2.mp3")
        pygame.mixer.music.play()
        time.sleep(len(text)/8)
        
    except :
        return
