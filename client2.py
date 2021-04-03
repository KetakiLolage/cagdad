# client2.py
#!/usr/bin/env python

import socket
import subprocess

TCP_IP = '192.168.53.12'
TCP_PORT = 8161
BUFFER_SIZE = 1024

while True:
	s = socket.socket()
	s.connect((TCP_IP, TCP_PORT))
	'''command = s.recv(BUFFER_SIZE)
	print(command)
	if command==1:
		output = subprocess.check_output('python check.py', shell=True)
		s.send(output)
	'''
	id1 = 2
	s.send(str(id1))
	file_size = s.recv(2)
	print file_size
	filename = s.recv(int(file_size))
	filename = subprocess.check_output("basename "+filename,shell=True)
	filename = filename.rstrip()
	print(filename)

	#s.send("Filename received")
	f2_size = s.recv(1)
	print f2_size
	f2 = s.recv(int(f2_size))
	print(f2)
	opfile= s.recv(17)
	print('Output file name: {}'.format(opfile))
	#with open(filename, 'wb') as f:
	with open(filename, 'wb') as f:
	    print 'file opened'
	    while True:
		data = s.recv(BUFFER_SIZE)
	#       print('data=%s', (data))
		if not data:
		    f.close()
		    print 'file close()'
		    break
		f.write(data)

	msg = "/usr/bin/python /home/admin1/mynodpenauto1.py {} {} > {}".format(filename,f2,opfile)
	x=subprocess.check_call(msg, shell=True)
	print('Returned')
	#print(x)
	f1 = open(opfile,'r')
	l1 = f1.read(BUFFER_SIZE)
	while True:
		s.send(l1)
		l1 = f1.read(BUFFER_SIZE)
		if not l1:
			break
		
		
	f1.close()
	
	
		
	#print('Successfully got the file')

	#print('connection closed and algo started')
