file=/home/cs143/data/googlebooks-eng-all-1gram-20120701-s.gz
zcat $file |  awk '$2 >= 1900'  | datamash --sort --full groupby 2 max 3 | cut -f 1,2,3