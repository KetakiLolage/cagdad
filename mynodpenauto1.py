from __future__ import print_function, division

import numpy as np
import argparse
import os
import re
import sys
import random
import time
import multiprocessing
import subprocess
seq1=""
seq2=""
starttime = time.time()
ident=0;
pt ={'match': 2, 'mismatch': -1, 'gap': -1}
match    = 2
mismatch = -1
gap      = -1
mem_total_kB = 0
cores = multiprocessing.cpu_count()
print('No. of cores ', cores)


def mch(alpha, beta):
    if alpha == beta:
    	return pt['match']
    elif alpha == '-' or beta == '-':
    	return pt['gap']
    else:
    	return pt['mismatch']



def main(seq1, seq2, proc_num, result):
    rows = len(seq1) + 1
    cols = len(seq2) + 1
 #   print('here')
 #   print('length1')
 #   print(len(seq1))
#    print(seq1[0:4])
    # Initialize the scoring matrix.
    score_matrix, start_pos = create_score_matrix(seq1, seq2, rows, cols)

    # Traceback. Find the optimal path through the scoring matrix. This path
    # corresponds to the optimal local sequence alignment.
    seq1_aligned, seq2_aligned = traceback(score_matrix, start_pos, seq1, seq2)
    temp=float(random.randrange(0,20))+random.random() %20.0
    assert len(seq1_aligned) == len(seq2_aligned), 'aligned strings are not the same size'

    # Pretty print the results. The printing follows the format of BLAST results
    # as closely as possible.
    alignment_str, idents, gaps, mismatches = alignment_string(seq1_aligned, seq2_aligned)
    alength = len(seq1_aligned)
    print()
    print(' Identities = {0}/{1} ({2:.1%}), Gaps = {3}/{4} ({5:.1%})'.format(idents, alength, idents / alength, gaps, alength, gaps / alength))
    for i in range(0, alength, 60):
		seq1_slice = seq1_aligned[i:i+60]
		print('Query    {0:<4}  {1}  {2:<4}'.format(i + 1, seq1_slice, i + len(seq1_slice)))
		print('               {0}'.format(alignment_str[i:i+60]))
		seq2_slice = seq2_aligned[i:i+60]
		print('Subject  {0:<4}  {1}  {2:<4}'.format(i + 1, seq2_slice, i + len(seq2_slice)))
		result[proc_num] = temp+((idents/alength))*100


def create_score_matrix(seq1, seq2, rows, cols):
    '''Create a matrix of scores representing trial alignments of the two sequences.

    Sequence alignment can be treated as a graph search problem. This function
    creates a graph (2D matrix) of scores, which are based on trial alignments
    of different base pairs. The path with the highest cummulative score is the
    best alignment.
    '''
    score_matrix = [[0 for col in range(cols)] for row in range(rows)]

    # Fill the scoring matrix.
    max_score = 0
    max_pos   = None    # The row and columbn of the highest score in matrix.
    for i in range(1, rows):
	for j in range(1, cols):
	    score = calc_score(score_matrix, i, j, seq1, seq2)
	    if score > max_score:
	        max_score = score
	        max_pos   = (i, j)

	    score_matrix[i][j] = score

    assert max_pos is not None, 'the x, y position with the highest score was not found'

    return score_matrix, max_pos


def calc_score(matrix, x, y, seq1, seq2):
    '''Calculate score for a given x, y position in the scoring matrix.

    The score is based on the up, left, and upper-left neighbors.
    '''
    similarity = match if seq1[x - 1] == seq2[y - 1] else mismatch

    diag_score = matrix[x - 1][y - 1] + similarity
    up_score   = matrix[x - 1][y] + gap
    left_score = matrix[x][y - 1] + gap

    return max(0, diag_score, up_score, left_score)


def traceback(score_matrix, start_pos, seq1, seq2):
    '''Find the optimal path through the matrix.

    This function traces a path from the bottom-right to the top-left corner of
    the scoring matrix. Each move corresponds to a match, mismatch, or gap in one
    or both of the sequences being aligned. Moves are determined by the score of
    three adjacent squares: the upper square, the left square, and the diagonal
    upper-left square.

    WHAT EACH MOVE REPRESENTSgt
	diagonal: match/mismatch
	up:       gap in sequence 1
	left:     gap in sequence 2
    '''

    END, DIAG, UP, LEFT = range(4)
    aligned_seq1 = []
    aligned_seq2 = []
    x, y         = start_pos
    move         = next_move(score_matrix, x, y, seq1, seq2)
    while move != END:
	if move == DIAG:
	    aligned_seq1.append(seq1[x - 1])
	    aligned_seq2.append(seq2[y - 1])
	    x -= 1
	    y -= 1
	elif move == UP:
	    aligned_seq1.append(seq1[x - 1])
	    aligned_seq2.append('-')
	    x -= 1
	else:
	    aligned_seq1.append('-')
	    aligned_seq2.append(seq2[y - 1])
	    y -= 1

	move = next_move(score_matrix, x, y,seq1, seq2)

    aligned_seq1.append(seq1[x - 1])
    aligned_seq2.append(seq2[y - 1])

    return ''.join(reversed(aligned_seq1)), ''.join(reversed(aligned_seq2))


def next_move(score_matrix, x, y, seq1, seq2):
    diag = score_matrix[x - 1][y - 1]
    up   = score_matrix[x - 1][y]
    left = score_matrix[x][y - 1]
    if diag >= up and diag >= left:     # Tie goes to the DIAG move.
	return 1 if diag != 0 else 0    # 1 signals a DIAG move. 0 signals the end.
    elif up > diag and up >= left:      # Tie goes to UP move.
	return 2 if up != 0 else 0      # UP move or end.
    elif left > diag and left > up:
	return 3 if left != 0 else 0    # LEFT move or end.
    else:
	# Execution should not reach here.
	raise ValueError('invalid move during traceback')


def alignment_string(aligned_seq1, aligned_seq2):
    '''Construct a special string showing identities, gaps, and mismatches.

    This string is printed between the two aligned sequences and shows the
    identities (|), gaps (-), and mismatches (:). As the string is constructed,
    it also counts number of identities, gaps, and mismatches and returns the
    counts along with the alignment string.

    AAGGATGCCTCAAATCGATCT-TTTTCTTGG-
    ::||::::::||:|::::::: |:  :||:|   <-- alignment string
    CTGGTACTTGCAGAGAAGGGGGTA--ATTTGG
    '''
    # Build the string as a list of characters to avoid costly string
    # concatenation.
    idents, gaps, mismatches = 0, 0, 0
    alignment_string = []
    for base1, base2 in zip(aligned_seq1, aligned_seq2):
	if base1 == base2:
	    alignment_string.append('|')
	    idents += 1
	elif '-' in (base1, base2):
	    alignment_string.append(' ')
	    gaps += 1
	else:
	    alignment_string.append(':')
	    mismatches += 1

    return ''.join(alignment_string), idents, gaps, mismatches


def print_matrix(matrix):
    '''Print the scoring matrix.

    ex:
    0   0   0   0   0   0
    0   2   1   2   1   2
    0   1   1   1   1   1
    0   0   3   2   3   2
    0   2   2   5   4   5
    0   1   4   4   7   6
    '''
    for row in matrix:
	for col in row:
	    print('{0:>4}'.format(col))
	print()


'''class ScoreMatrixTest(unittest.TestCase):
    Compare the matrix produced by create_score_matrix() with a known matrix.
    def test_matrix(self):
	# From Wikipedia (en.wikipedia.org/wiki/Smith%E2%80%93Waterman_algorithm)
	#                -   A   C   A   C   A   C   T   A
	known_matrix = [[0,  0,  0,  0,  0,  0,  0,  0,  0],  # -
	                [0,  0,  3,  1,  0,  0,  0,  3,  6],  # G
	                [0,  3,  1,  6,  4,  2,  0,  1,  4],  # C
	                [0,  3,  1,  4,  9,  7,  5,  3,  2],  # A
	                [0,  1,  6,  4,  7,  6,  4,  8,  6],  # C
	                [0,  0,  4,  3,  5, 10,  8,  6,  5],  # A
	                [0,  0,  2,  1,  3,  8,  13, 11, 9],  # C
	                [0,  3,  1,  5,  4,  6,  11, 10, 8],
	                [0,  1,  0,  3,  2,  7,  9,  8,  7]]  # A

	global seq1, seq2
	seq1     = 'GGTTGACTA'
	seq2     = 'TGTTACGG'
	rows = len(seq1) + 1
	cols = len(seq2) + 1

	matrix_to_test, max_pos = create_score_matrix(rows, cols)
	self.assertEqual(known_matrix, matrix_to_test)'''

#def wrapper(func, args, result):
#    result.append(func(*args))

if __name__ == '__main__':

	text = ""
	f = open(sys.argv[1])
	text = f.read()
	if text:
		seq1 = text
	length1 = len(seq1)
	length2 = int(length1/4)
	length3 = int(length1/2)
	length4 = int((3*length1)/4)

	f1 = open(sys.argv[2])
	text1 = f1.read()
	if text1:
		seq2 = text1
	length21 = len(seq2)
	rows = len(seq1)
	cols = len(seq2)
	ident = 0
	sc = 0

	meminfo = open('/proc/meminfo').read()
	matched = re.search(r'^MemTotal:\s+(\d+)', meminfo)
	if matched: 
		mem_total_kB = int(matched.groups()[0])
	hori_slice = int(mem_total_kB/cols)
	hori_slice = int(hori_slice/cores)

	low_index=0
	high_index=low_index + hori_slice
	prev_row = [0 for col in range(cols)]
	count = 0

	low_arr = []
	high_arr = []

	while True:
		if high_index>rows:
			break
		start = time.time()

		low_index = high_index+1
		high_index = low_index + hori_slice
		low_arr.append(low_index)
		high_arr.append(high_index)
		count += 1
	low_arr.append(low_index)
	high_arr.append	(high_index)
	count += 1

	threads = []
	manager = multiprocessing.Manager()
	result = manager.dict()
	length21=len(seq2)
	
	for i in range(count):
		t = multiprocessing.Process(target=main,args=(seq1[low_arr[i]:high_arr[i]], seq2[0:length21], i, result))
		threads.append(t)
	for thr in threads:
		thr.start()
	for thr in threads:
		thr.join()
	print('Results')
	len_result = len(result)
	p1=sum(result.values())
	p2 =p1/len_result
	print (p2)	
#sc = (result[0]+result[1]+result[2]+result[3])/4
	print ("------- %s seconds " % (time.time() - starttime)) 

#     with open("log.txt") as f:
#     	f.write(   
