file=/home/cs143/data/googlebooks-eng-all-1gram-20120701-s.gz
zcat $file | awk '$4 >= 10000' |sort -k 2,2n | cut -f 2 | head -1
