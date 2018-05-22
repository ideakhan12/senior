import requests
import json
import os
from gtts import gTTS
from datetime import datetime

params = {'id':'test'}
res = requests.post('http://52.79.133.253/demand.php', data=params)
text = res.text.encode('utf8')[3:].decode('utf8')

data = json.loads(text)
val = data[0]['text']

#시작시간 저장
sdate = data[0]['s_date']
s_date = datetime.datetime.strptime(sdate, '%Y-%m-%d %H:%M:%S')

#종료시간 저장
edate = data[0]['e_date']
e_date = datetime.datetime.strptime(edate, '%Y-%m-%d %H:%M:%S')

# 시스템시간 저장
systime = datetime.datetime.now()

#시간비교 후 출력
if systime.time() > s_date.time() & systime.time() < e_date.time():
    tts = gTTS(text=val, lang='en')
    tts.save("input_test2.mp3")
    os.system("C:/Users/YUNKYUNG/PycharmProjects/untitled/input_test2.mp3")