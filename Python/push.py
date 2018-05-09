"""
from pyfcm import FCMNotification

proxy_dict = {
    "http" : "http://fcm.googleapis.com/fcm/send"
    #"https" : "https://fcm.googleapis.com/fcm/send"
}
push_service = FCMNotification(api_key="AAAAVjUAzTk:APA91bFpZLbUpXYTCV-wOXYZyG9RIKnhkZlVu1zOHnsFglpDSyQm-tEEZSAylVDcPzin4_nz3LXFUbJlLDH9Fhkk2ZPPdvqvgiJfyxDW_J2cY8uYQlsXfDZZjuJpUEEfNR1Yr9bPCkEI", proxy_dict=proxy_dict)

registration_id = "/topics/news"
title = "Go"
contents = "Home"
result = push_service.notify_single_device(registration_id=registration_id, message_title=title, message_body=contents)

print(result)
"""

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