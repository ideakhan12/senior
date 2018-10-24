<<<<<<< HEAD
import json
import requests
import datetime
import pygame
from gtts import gTTS
from bs4 import BeautifulSoup
import pandas as pd
from datetime import datetime

=======
﻿import requests
from bs4 import BeautifulSoup
import pandas as pd
>>>>>>> origin/MJH

def get_html(url):
    _html = ""
    resp = requests.get(url)
<<<<<<< HEAD
    return resp

def crawling(del_com, del_no):
    # url 조합
    front_url = "http://www.deliverytracking.kr/?dummy=dummy&deliverytype="
    middle_url = "&keyword="
    url = front_url + del_com + middle_url + str(del_no)

    re = []
    res = get_html(url)  #완성된 주소 반환
    soup = BeautifulSoup(res.content, 'html.parser', from_encoding='utf-8')  #파싱 객체 생성, UTF-8설정
    table = soup.find_all('table', {'class': 'table table-bordered table-condensed table-hover'})  # 밑에 데이터들을 가져와서 반복문으로 끝에 있는걸 출력하면 됨. 예은이꺼 참고

    li = []
    for tr in table[1].find('tbody').find_all('tr'):
        re = tr

    for td in re.find_all('td'):
        li.append(td.text)
    
    try:
        if str(li[2]) != '고객' :
            d_msg = "현재위치" + "," + str(li[2]) + ", " + str(li[3])
        else:
            d_msg = "주문하신 물품이 이미 배송완료되었습니다"
        tts = gTTS(text=d_msg, lang='ko')
        tts.save("delivery.mp3")
        pygame.mixer.init()  # 파이썬 한글은 3비트
        pygame.mixer.music.load("delivery.mp3")
        pygame.mixer.music.play()
        
        print(d_msg)
    except:
        print("null")
    

def crawling_main():
    tts = gTTS(text='주문하신 택배를 추적하고있습니다.', lang='ko')
    tts.save("delivery.mp3")
    pygame.mixer.init()  # 파이썬 한글은 3비트
    pygame.mixer.music.load("delivery.mp3")
    pygame.mixer.music.play()
    
    params = {'id': 'test'}
    res = requests.post('http://52.79.133.253/demand_delivery.php', data=params)
    delivery_company = res.text.encode('utf8')[3:].decode('utf8')

    now = datetime.strptime(datetime.now().strftime("%Y-%m-%d %H:%M:%S"), '%Y-%m-%d %H:%M:%S')

    data = json.loads(delivery_company)
    text = ""

    for d in data:
        delivery_company = d['delivery_company']
        delivery_no = d['delivery_no']
        df = pd.DataFrame(crawling(delivery_company, delivery_no))
        
    

            
=======
    _html = resp
    return _html

def crawling(D_type, key):
    # url 조합
    front_url = "http://www.deliverytracking.kr/?dummy=dummy&deliverytype="
    middle_url = "&keyword="
    url = front_url + D_type + middle_url + str(key)

    re = []
    res = get_html(url)  #
    soup = BeautifulSoup(res.text, "lxml") #파싱 객체 생성
    table = soup.find('table', {'class': 'table table-bordered table-condensed table-hover table-responsive'})
    table = table.find('table', {'class':'table table-bordered table-condensed table-hover'})
    print(table)        #밑에 데이터들을 가져와서 반복문으로 끝에 있는걸 출력하면 됨. 예은이꺼 참고
    result = soup.select(".list_netizen .title ")  #파싱 결과 담음.

    # 불필요한 텍스트 및 앞뒤 공백 제거  필요 없나??
    for i in result:
        i.find(class_="   ").extract()  #class_ ????
        i.find(class_="   ").extract()  #??
        re.append(i.text.strip())

def main():
    # 영화 고유코드와 긁어올 페이지 수
    D_type = "lotteglogis"  # 배송사 별 주소
    key = 229221353896  # 사용자가 입력할 운송장 번호

    df = pd.DataFrame(crawling(D_type, key))
    print(df)

main()
>>>>>>> origin/MJH
