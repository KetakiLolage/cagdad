import os
i =0
#NUM_OF_LINES=60
filename = sys.argv[1]
with open(filename) as files:
	for i, l in enumerate(files):
		pass
file_size = i + 1
print file_size
NUM_OF_LINES = int(file_size/32)
print NUM_OF_LINES
print "here"
with open(filename) as fin:
    fout = open("h0.fasta","wb")
    for i,line in enumerate(fin):
      fout.write(line)
      if (i+1) % NUM_OF_LINES == 0:
        fout.close()
        print "file 1"
        fout = open("h%d.fasta"%(i/NUM_OF_LINES+1),"wb")
      

    fout.close()
print "there"
