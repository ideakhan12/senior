import socket
import cv2
import numpy
import time

TCP_IP = '52.79.133.253'
TCP_PORT = 5001

sock = socket.socket()
sock.connect((TCP_IP, TCP_PORT))

capture = cv2.VideoCapture(0)
while True :
	capture.set(3, 640)
	capture.set(4, 480)

	ret, frame = capture.read()

	encode_param = [int(cv2.IMWRITE_JPEG_QUALITY),60]
	result, imgencode = cv2.imencode('.jpg', frame, encode_param)
	data = numpy.array(imgencode)
	stringData = data.tostring()

	sock.send(str(len(stringData)).ljust(16))
	sock.send(stringData)
	
	time.sleep(0.1)
	
sock.close()

decimg = cv2.imdecode(data,1)
cv2.imshow('CLIENT', decimg)
cv2.waitKey(0)
cv2.destroyAllWindows()
