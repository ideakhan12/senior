'''
제목 : weather.py
주제 : 기상청 API를 활용하여 시간대별 기상종류와 하늘상태, 낮 최고온도 출력
출력 예 : 현재 비가 내리고 있습니다. 이후 09시에 그칠 예정이며 흐림 예정입니다. 금일 낮 최고 온도는 21도 입니다.
'''

import datetime
import pytz
import urllib.request
import json

# GET : API를 호출할 시간과 날짜
def get_api_date():
    # API 호출 가능 시간은 standard_time에 시간만 가능
    standard_time = [2, 5, 8, 11, 14, 17, 20, 23]
    time_now = datetime.datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%H')
    check_time = int(time_now) - 1
    day_calibrate = 0
    # GET : standard_time 중 현재시간과 가장 가까운 시간
    while not check_time in standard_time:
        check_time -= 1
        if check_time < 2:
            day_calibrate = 1
            check_time = 23

    date_now = datetime.datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%Y%m%d')
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
            pty_dic[all] = "비"
        elif pty_dic[all] == 2 :
            pty_dic[all] = "진눈깨비"
        elif pty_dic[all] == 3 :
            pty_dic[all] = "눈"

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
                msg = "현재 "+str(pty_dic[time])+"가 내리고 있습니다"
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

if __name__ == '__main__':
    tts_weather()