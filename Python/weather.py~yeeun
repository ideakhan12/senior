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
import collections
from gtts import gTTS
from datetime import datetime

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

    date_now = datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%Y%m%d')
    check_date = int(date_now) - day_calibrate

    return (str(check_date), (str(check_time) + '00'))

# API 호출
def get_weather_data():
    api_date, api_time = get_api_date()
    # 키값은 시간 value값은 pty 혹은 sky 인 딕셔너리 선언 (pty = 기상종류, sky = 하늘상태), key값 중복을 막기위한 time_arr 선언
    pty_dic = collections.OrderedDict()
    sky_dic = collections.OrderedDict()
    time_arr, time_arr2 = [], []
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
            pty_dic[str(one_parsed['fcstDate'])+str(one_parsed['fcstTime'])] = one_parsed['fcstValue']
            time_arr.append(one_parsed['fcstTime'])
        # CREATE : 시간대 별 SKY를 얻고 시간과 SKY값으로 딕셔너리
        if one_parsed['category'] == "SKY":
            sky_dic[str(one_parsed['fcstDate'])+str(one_parsed['fcstTime'])] = one_parsed['fcstValue']
        # GET : TMX
        if one_parsed['category'] == 'TMX' :
            TMX = one_parsed['fcstValue']

    return (pty_dic, sky_dic, TMX, target_time, target_date, time_arr)

def tts_weather() :
    pty_dic, sky_dic, TMX, target_time, target_date, all_time = get_weather_data()
    TMX = int(TMX)
    new_pty_dic = collections.OrderedDict()
    new_sky_dic = collections.OrderedDict()
    all_key = []

    for key, value in sky_dic.items() :
        if str(key[0:8]) == str(target_date) :
            keys = "금일 " + str(key[8:10])
            new_sky_dic[keys] = value
        else :
            keys = "익일 " + str(key[8:10])
            new_sky_dic[keys] = value
        all_key.append(keys)

    for key, value in pty_dic.items() :
        if str(key[0:8]) == str(target_date) :
            new_pty_dic["금일 "+str(key[8:10])] = value
        else :
            new_pty_dic["익일 "+str(key[8:10])] = value

    # 코드명으로 된 Value값 한글로 변환
    for all in all_key :
        if new_sky_dic[all] == 1 :
            new_sky_dic[all] = "맑음"
        elif new_sky_dic[all] == 2 :
            new_sky_dic[all] = "구름조금"
        elif new_sky_dic[all] == 3 :
            new_sky_dic[all] = "구름많음"
        else :
            new_sky_dic[all] = "흐림"

    for all in all_key :
        if new_pty_dic[all] == 1 :
            new_pty_dic[all] = "비가"
        elif new_pty_dic[all] == 2 :
            new_pty_dic[all] = "진눈깨비가"
        elif new_pty_dic[all] == 3 :
            new_pty_dic[all] = "눈이"

    change_time = [all_key[0]]  # 기상상태 바뀌는 시간을 저장할 배열
    
    # GET : 기상상태가 바뀌는 시간
    for i in range(len(all_key)) :
        if i != 9 :
            if str(new_pty_dic[all_key[i]]) != str(new_pty_dic[all_key[i+1]]) :
                change_time.append(all_key[i+1])
    # CREATE : 출력할 msg
    flag = 1
    for time in change_time :
        if flag == 1 :
            if new_pty_dic[time] != 0:
                msg = "현재 "+str(new_pty_dic[time])+" 내리고 있습니다."
            else :
                msg = "현재 " +str(new_sky_dic[time])+ " 입니다."
            flag += 1
        else :
            if new_pty_dic[time] != 0:
                msg += " 이후 "+str(time)+"시에 "+str(new_pty_dic[time])+" 예상됩니다."
            else :
                msg += " 이후 "+str(time)+"시에 그칠 예정이며, "+str(sky_dic[time]) + " 예상됩니다."

    if TMX > 33 :
        msg+=" 금일 낮 최고 온도는 "+str(TMX)+"도로 예상되며 폭염에 주의하세요."
    elif TMX < -12 :
        msg+=" 금일 낮 최고 온도는 영하 "+str(TMX)+"도로 예상되며 한파에 주의하세요."
    elif TMX > 0 :
        msg+= " 금일 낮 최고 온도는 "+str(TMX)+"도로 예상됩니다."
    else :
        msg += " 금일 낮 최고 온도는 영하 "+str(TMX)+"도로 예상됩니다."

    print(msg)
    
    tts = gTTS(text=msg, lang='ko')
    tts.save("weather.mp3")
    
    #time.sleep()
    #msg 크기 or 문자 수에 따라 타임 슬립 다르게 주기
    pygame.mixer.init()     #파이썬 한글은 3비트
    
    pygame.mixer.music.load("weather.mp3")
    pygame.mixer.music.play()
    
    return len(msg)