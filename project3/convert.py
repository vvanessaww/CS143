#!/usr/bin/python
import json

# load data
data = json.load(open("/home/cs143/data/nobel-laureates.json", "r"))

people_dict = {}
org_dict = {}
prizes_dict = {}
aff_dict = []
for x in data["laureates"]:
	id = x["id"]
	if "orgName" not in x:
		if "givenName" in x:
			given_name = "\"" + x["givenName"]["en"] + "\""
		else:
			given_name = "NULL"
		if "familyName" in x:
			family_name = "\"" + x["familyName"]["en"] + "\""
		else:
			family_name = "NULL"
		if "gender" in x:
			gender = x["gender"]
		else:
			gender = "NULL"
		if "birth" in x:
			birth_date = x["birth"]["date"]
			if "city" in x["birth"]["place"]:
				birth_city = x["birth"]["place"]["city"]["en"]
			else:
				birth_city = "NULL"
			if 'country' in x["birth"]["place"]:
				birth_country = x["birth"]["place"]["country"]["en"]
			else:
				birth_country = "NULL"
		else:
			birth_date = "NULL"
			birth_city = "NULL" 
			birth_country = "NULL"
		if given_name == "Satoshi":
			print((id, given_name, family_name, gender, birth_date, birth_city, birth_country))
		people_dict[id] = (id, given_name, family_name, gender, birth_date, birth_city, birth_country)
	elif "orgName" in x:
		org_name = x["orgName"]["en"]
		if "founded" in x:
			if "date" in x["founded"]:
				org_date = x["founded"]["date"]
			else:
				org_date = "NULL"
			if "place" in x["founded"]:
				if "city" in x["founded"]["place"]:
					org_city = x["founded"]["place"]["city"]["en"]
				else:
					org_city = "NULL"
				if "country" in x["founded"]["place"]:
					org_country = x["founded"]["place"]["country"]["en"]
				else:
					org_country = "NULL"
			else:
				org_city = "NULL"
				org_country = "NULL"
		else:
			org_date = "NULL"
			org_city = "NULL"
			org_country = "NULL"
		org_dict[id] = (id, org_name, org_date, org_city, org_country)

	nobels = x["nobelPrizes"]
	for y in nobels:
		award_year = y["awardYear"]
		category = y["category"]["en"]
		sort_order = y["sortOrder"]
		prize_key = award_year + "||" + category + "||" + sort_order
		if prize_key not in prizes_dict:
			prizes_dict[prize_key] = (id, prize_key, award_year, category, sort_order)
		
		if "affiliations" in y:
			affils = y["affiliations"]
			for a in affils:
				name = a["name"]["en"]
				if "city" in a:
					city = a["city"]["en"]
				else:
					city = "NULL"
				if "country" in a:
					country = a["country"]["en"]
				else:
					country = "NULL"
				affil_key = "\"" + name + "||" + city + "||" + country + "\""
				aff_dict.append((prize_key, affil_key, "\"" + name + "\"", "\"" + city + "\"", "\"" + country + "\""))


print("Num of People Prize Winners: " + str(len(people_dict)))
print("Num of Organization Prize Winners: " + str(len(org_dict)))
print("Num of Prizes: " + str(len(prizes_dict)))


people_del = open("People.del", "w")
for x in people_dict:
	line = ""
	for i in people_dict[x]:
		if i == "NULL":
			line += "\\N;"
		else:
			line += i + ";"
	people_del.write(line + "\n")

orgs_del = open("Organizations.del", "w")
for x in org_dict:
	line = ""
	for i in org_dict[x]:
		if i == "NULL":
			line += "\\N;"
		else:
			line += i + ";"
	orgs_del.write(line + "\n")


prizes_del = open("Prizes.del", "w")
for x in prizes_dict:
	line = ""
	for i in prizes_dict[x]:
		if i == "NULL":
			line += "\\N;"
		else:
			line += i + ";"
	prizes_del.write(line + "\n")

affiliations_del = open("Affiliations.del", "w")
for x in aff_dict:
	line = ""
	for i in x:
		if i == "NULL":
			line += "\\N;"
		else:
			line += i + ";"
	affiliations_del.write(line + "\n")	