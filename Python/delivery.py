import requests
from bs4 import BeautifulSoup
import pandas as pd

def get_html(url):
    _html = ""
    resp = requests.get(url)
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