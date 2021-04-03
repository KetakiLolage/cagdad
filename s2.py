import socket
from threading import Thread
from SocketServer import ThreadingMixIn
from pymongo import MongoClient
from bson.objectid import ObjectId
import pymongo
from datetime import datetime
import threading
import os
import subprocess

client = MongoClient()
db = client.slavelist
collection = db.statusreview

clientTasks = MongoClient()
dbTasks = clientTasks.gsa
collTasks = dbTasks.tasks


TCP_IP = '192.168.53.12'
TCP_PORT = 8164
BUFFER_SIZE = 1024
i=0
results=[0,0]
class ClientThread(Thread):

	def __init__(self,ip,port,sock,filename,f2,opfile,id1,taskid):
		Thread.__init__(self)
		self.ip = ip
		self.port = port
		self.sock = sock
		self.fnnm=filename
		self.fnnm1 = f2
		self.opfile = opfile
		self.id1 = id1
		self.taskid = taskid
		print " New thread started for "+ip+":"+str(port)
	

	def run(self):
		f = open(self.fnnm,'rb')
		f11 = open(self.opfile,'wb')
		while True:
			try:
				l = f.read(BUFFER_SIZE)
				while (l):
					self.sock.send(l)
			#print('Sent ',repr(l))
					l = f.read(BUFFER_SIZE)
	    				if not l:
				#print 'hini'
				#ClientThread.calc(self)
						f.close()
						self.sock.shutdown(socket.SHUT_WR)
						
						break
						
				
						#self.sock.connect((self.ip,self.port))
				filee = self.sock.recv(BUFFER_SIZE)
				while filee:
					f11.write(filee)
		
					filee = self.sock.recv(BUFFER_SIZE)
					
				if not filee:
					f11.write(filee)
					
					collection.update({"_id":self.id1},{"$set":{"status":"active"}})
					collTasks.update({"_id":self.taskid},{"$set":{"completion_time":unicode(datetime.now())}})
					collTasks.update({"_id":self.taskid},{"$set":{"status":"done"}})
				
					f11.close()
					newsing = subprocess.check_output("tail -2 "+self.opfile+" | head -1",shell="True")
					newsing = newsing.rstrip()
					collTasks.update({"_id":self.taskid},{"$set":{"score":newsing}})
					break
				
					
				
    			except socket.timeout:
				print 'kuch nahii'
				pass	
	

	def calc(self):
		
		while True:
			l1 = self.sock.recv(1)
			while l1:
				f11.write(l1)
				
				
				
tcpsock = socket.socket()
#tcpsock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
tcpsock.bind((TCP_IP, TCP_PORT))
threads = []

while True:
	
	tcpsock.listen(15)	
	print "Waiting for incoming connections..."
	(conn, (ip,port)) = tcpsock.accept()
	#print 'Got connection from ', (ip,port)
	recvid = int(conn.recv(1))
	print "client ID received: ", recvid
	collection.update({"_id":recvid},{"$set":{"status":"active"}})
	obj = collection.find_one({"status":"active"})
	if not obj:
		continue 
	id1 = obj['_id']
	
	#Get task from tasks
	task = collTasks.find_one({"status":"todo"})
	if not task:
		continue 
	taskid = task['_id']
	filename=task['seq1']
	print filename
	f2 = str(int(task['seq2']))
	f2 = f2+".fasta"
	pid = task['patient_id']
	collTasks.update({"_id":taskid},{"$set":{"submit_time":unicode(datetime.now())}})
	opfile = 'outputfile'+str(int(pid))+"_"+str(int(taskid))+'.txt'
	i=i+1
	print len(filename)
	conn.send(str(len(filename)))
	conn.send(filename)
	conn.send(str(len(f2)))
	conn.send(f2)
	conn.send(opfile)
	newthread = ClientThread(ip,port,conn,filename,f2,opfile,id1,taskid)	#human, disease, output
	collection.update({"_id":id1},{"$set":{"status":"busy"}})
	collTasks.update({"_id":taskid},{"$set":{"status":"underprocess"}})
	newthread.start()

	threads.append(newthread)

	#f=open(opfile,'r')
#	while i-1>=0:
#			results[i-1]=f.readline()
#	i = i-1
#	f.close()
#	print results
	
for t in threads:
	t.join()




