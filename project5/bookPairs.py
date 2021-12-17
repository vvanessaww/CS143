
from pyspark import SparkContext
from itertools import combinations
sc = SparkContext("local", "bookPairs")

lines = sc.textFile("/home/cs143/data/goodreads.user.books")
bookIds = lines.map(lambda l: l[l.find(':')+1: ])
splitIds = bookIds.map(lambda l: sorted(l.split(","), key = int))
bookPairs = splitIds.flatMap(lambda ls: combinations(ls, 2))
intPairs = bookPairs.map(lambda pair: (int(pair[0]),int(pair[1])))
keyPairs = intPairs.map(lambda pair: (pair,1))
countPairs = keyPairs.reduceByKey(lambda a,b: a+b)
outputPairs = countPairs.filter(lambda pair: pair[1] >20)
outputPairs.saveAsTextFile("./output")