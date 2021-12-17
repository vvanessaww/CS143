import json
import os

# load data
data = json.load(open("/home/cs143/data/nobel-laureates.json", "r"))
laureates = data["laureates"]

if os.path.exists("laureates.import"):
    os.remove("laureates.import")
    
laureates_import = open("laureates.import", "w")
for index, laureate in enumerate(laureates):
    laureates_import.write(json.dumps(laureate) + "\n")