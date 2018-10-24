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
count=0
timer_count=0
door_count=0

def demand():
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

    tts = gTTS(text=text, lang='ko')
    tts.save("input_test2.mp3")

    pygame.mixer.init()
    pygame.mixer.music.load("input_test2.mp3")
    pygame.mixer.music.play()


# GET : API를 호출할 시간과 날짜
def get_api_date():
    # API 호출 가능 시간은 standard_time에 시간만 가능
    standard_time = [2, 5, 8, 11, 14, 17, 20, 23]
    time_now = datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%H')
    check_time = int(time_now) - 1
    day_calibrate = 0
    # GET : standard_time 중 현재시간과 가장 가까운 시간
    while not check_time in standard_time:
        check_time -= 1
        if check_time < 2:
            day_calibrate = 1
            check_time = 23

    date_now =datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%Y%m%d')
    check_date = int(date_now) - day_calibrate

    return (str(check_date), (str(check_time) + '00'))

# API 호출
def get_weather_data():
    api_date, api_time = get_api_date()
    # 키값은 시간 value값은 pty 혹은 sky 인 딕셔너리 선언 (pty = 기상종류, sky = 하늘상태), key값 중복을 막기위한 time_arr 선언
    pty_dic, sky_dic, time_arr, time_arr2 = {}, {}, [], []
    url = "http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService2/ForecastSpaceData?"
    key = "serviceKey=xiwyodx6q6TGfsaTJuKAy%2Fr96A7r1A6KIlGCeXxXRV3V%2B1J1RPWNPo22N4udyQr%2BuBlhJYWh9e%2FANYiTbtzcSw%3D%3D"
    date = "&base_date=" + api_date
    time = "&base_time=" + api_time
    nx = "&nx=56"
    ny = "&ny=122"
    numOfRows = "&numOfRows=100"
    type = "&_type=json"
    api_url = url + key + date + time + nx + ny + numOfRows + type

    data = urllib.request.urlopen(api_url).read().decode('utf8')
    data_json = json.loads(data)

    # PARSING : 받아온 json에서 필요한 부분만
    parsed_json = data_json['response']['body']['items']['item']

    # GET : parsed_json에서 첫 줄 시간과 날짜
    target_date = parsed_json[0]['fcstDate']
    target_time = parsed_json[0]['fcstTime']

    date_calibrate = str(target_date)

    if int(target_time) > 1500 :
        date_calibrate = str(int(target_date) + 1)

    # PARSING : 카테고리별 (TMX = 낮 최고 온도)
    for one_parsed in parsed_json:
        # CREATE : 시간대 별 PTY를 얻고 시간과 PTY값으로 딕셔너리
        if one_parsed['category'] == "PTY":
            if one_parsed['fcstTime'] not in time_arr :
                pty_dic[one_parsed['fcstTime']] = one_parsed['fcstValue']
                time_arr.append(one_parsed['fcstTime'])
        # CREATE : 시간대 별 SKY를 얻고 시간과 SKY값으로 딕셔너리
        if one_parsed['category'] == "SKY":
            if one_parsed['fcstTime'] not in time_arr2 :
                sky_dic[one_parsed['fcstTime']] = one_parsed['fcstValue']
                time_arr2.append(one_parsed['fcstTime'])
        # GET : TMX
        if one_parsed['category'] == 'TMX' :
            TMX = one_parsed['fcstValue']

    return (pty_dic, sky_dic, TMX, target_time, time_arr)

def tts_weather() :
    pty_dic, sky_dic, TMX, target_time, all_time = get_weather_data()
    change_time = [target_time] # 기상상태 바뀌는 시간을 저장할 배열
    TMX = int(TMX)

    # 코드명으로 된 Value값 한글로 변환
    for all in all_time :
        if sky_dic[all] == 1 :
            sky_dic[all] = "맑음"
        elif sky_dic[all] == 2 :
            sky_dic[all] = "구름조금"
        elif sky_dic[all] == 3 :
            sky_dic[all] = "구름많음"
        else :
            sky_dic[all] = "흐림"

    for all in all_time :
        if pty_dic[all] == 1 :
            pty_dic[all] = "비가"
        elif pty_dic[all] == 2 :
            pty_dic[all] = "진눈깨비가"
        elif pty_dic[all] == 3 :
            pty_dic[all] = "눈이"

    # GET : 기상상태가 바뀌는 시간
    for i in range(len(all_time)) :
        if i != 7 :
            if pty_dic[all_time[i]] != pty_dic[all_time[i+1]] :
                change_time.append(all_time[i+1])

    # CREATE : 출력할 msg
    flag = 1
    for time in change_time :
        if flag == 1 :
            if pty_dic[time] != 0:
                msg = "현재 "+str(pty_dic[time])+" 내리고 있습니다"
            else :
                msg = "현재 " +str(sky_dic[time])+ " 입니다"
            flag += 1
        else :
            if pty_dic[time] != 0:
                msg += " 이후 "+str(time[0:2])+"시에 "+str(pty_dic[time])+" 예상됩니다"
            else :
                msg += " 이후 "+str(time[0:2])+"시에 그칠 예정이며 "+str(sky_dic[time]) + " 예상됩니다"

    if TMX > 33 :
        msg+=" 금일 낮 최고 온도는 "+str(TMX)+"도로 예상되며 폭염에 주의하세요"
    elif TMX < -12 :
        msg+=" 금일 낮 최고 온도는 영하 "+str(TMX)+"도로 예상되며 한파에 주의하세요"
    elif TMX > 0 :
        msg+= " 금일 낮 최고 온도는 "+str(TMX)+"도로 예상됩니다."
    else :
        msg += " 금일 낮 최고 온도는 영하 "+str(TMX)+"도로 예상됩니다."

    print(msg)
    tts = gTTS(text=msg, lang='ko')
    tts.save("demand+weather.mp3")

    #msg 크기 or 문자 수에 따라 타임 슬립 다르게 주기
    pygame.mixer.init()     #파이썬 한글은 3비트
    if  len(msg) > 100 :
        pygame.mixer.music.load("demand+weather.mp3")
        pygame.mixer.music.play()
        #time.sleep()
    elif  len(msg) > 70 and len(msg) <= 100 :
        pygame.mixer.music.load("demand+weather.mp3")
        pygame.mixer.music.play()
    else :
        pygame.mixer.music.load("demand+weather.mp3")
        pygame.mixer.music.play()


#스위치 도어 센서 작동
def DoorSensor():
    global door_count
    door_count += 1
    while True:
        #문열림 감지시 날씨 알림과 요구사항 데이터 음성 출력
        if door_count == 1:
            tts_weather()
            time.sleep(8)
            demand()
        elif (GPIO.input(door_pin) == 1) and (door_count > 1):
            continue
        elif GPIO.input(door_pin) == 0:
            door_count = 0
            break
        time.sleep(5)

#PIR 모션 센서 작동
def MotionSensor():
    global count
    global timer_count
    try:
        # 2초 간격으로 모션센서 작동 count증가, count가 3이상일 경우 푸시 알람
        if count >= 3 :
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
        GPIO.add_event_callback(door, DoorSensor)

#메인 함수
if __name__ == '__main__':
    print("Smart Door System")
    time.sleep(.5)
    print("Ready")

    try:
        while True:
            if timer_count == 15:
                count = 0
                timer_count=0
            if GPIO.input(door_pin):
                count = 0
                DoorSensor()
            if GPIO.input(pir_pin):
                MotionSensor()
            time.sleep(1)
            timer_count += 1
    #종료 예외처리
    except KeyboardInterrupt:
        print("Quit")
        GPIO.cleanup()

#타이머 보완 threading.Timer(second, execute_func, [second]).star()