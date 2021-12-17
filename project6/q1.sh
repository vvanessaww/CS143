file=/home/cs143/data/googlebooks-eng-all-1gram-20120701-s.gz
zcat $file | awk '$3 >= $4*1000' | cut -f 1,2