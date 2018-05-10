import datetime
import pytz
import urllib.request
import json

pop_dic = {} # 강우확률을 저장해둘 리스트
pty_dic = {} # 강우 종류를 저장해둘 리스트
time_arr = []
time_arr2 = []

def get_api_date():
    standard_time = [2, 5, 8, 11, 14, 17, 20, 23]
    time_now = datetime.datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%H')
    check_time = int(time_now) - 1
    day_calibrate = 0
    while not check_time in standard_time:
        check_time -= 1
        if check_time < 2:
            day_calibrate = 1
            check_time = 23

    date_now = datetime.datetime.now(tz=pytz.timezone('Asia/Seoul')).strftime('%Y%m%d')
    check_date = int(date_now) - day_calibrate

    return (str(check_date), (str(check_time) + '00'))


def get_weather_data():
    api_date, api_time = get_api_date()
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

    parsed_json = data_json['response']['body']['items']['item']

    target_date = parsed_json[0]['fcstDate']  # get date and time
    target_time = parsed_json[0]['fcstTime']

    date_calibrate = target_date  # date of TMX, TMN

    if int(target_time) > 1300 :
        date_calibrate = str(int(target_date) + 1)

    for one_parsed in parsed_json:
        if one_parsed['category'] == "POP":
            if one_parsed['fcstTime'] not in time_arr :
                pop_dic[one_parsed['fcstTime']] = one_parsed['fcstValue']
                time_arr.append(one_parsed['fcstTime'])
        if one_parsed['category'] == "PTY":
            if one_parsed['fcstTime'] not in time_arr2 :
                pty_dic[one_parsed['fcstTime']] = one_parsed['fcstValue']
                time_arr2.append(one_parsed['fcstTime'])
        if one_parsed['fcstDate'] == target_date and one_parsed['fcstTime'] == target_time:  # get today's data
            if one_parsed['category'] == "SKY":
                sky = one_parsed['fcstValue']
                print(sky)
        if one_parsed['fcstDate'] == date_calibrate and (one_parsed['category'] == 'TMX'):  # TMX, TMN at calibrated day
            TMX = one_parsed['fcstValue']
            print(TMX)

    print(pop_dic)
    print(pty_dic)

    return 0


if __name__ == '__main__':
    get_weather_data()