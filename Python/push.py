'''
제목 : push.py
주제 : 앱에 푸시알림 전송
'''

import json
import requests

headers = {
    'Authorization': 'key= AAAAVjUAzTk:APA91bFpZLbUpXYTCV-wOXYZyG9RIKnhkZlVu1zOHnsFglpDSyQm-tEEZSAylVDcPzin4_nz3LXFUbJlLDH9Fhkk2ZPPdvqvgiJfyxDW_J2cY8uYQlsXfDZZjuJpUEEfNR1Yr9bPCkEI',
    'Content-Type': 'application/json',
}

data = {
    'to': '/topics/bell',
    'data': {
        'title' : '외부인 접근',
        'body': '누구세홈',
    },
}

response = requests.post('https://fcm.googleapis.com/fcm/send', headers=headers, data=json.dumps(data))
print(response)