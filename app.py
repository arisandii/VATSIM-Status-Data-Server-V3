import json

rawData = None

with open("vatsim-data.json", "r", errors="ignore") as jData:
    rawData = json.load(jData)

general = rawData["general"]
pilots = rawData["pilots"]
controllers = rawData["controllers"]
atis = rawData["atis"]
servers = rawData["servers"]
prefiles = rawData["prefiles"]
facilities = rawData["facilities"]
ratings = rawData["ratings"]
pilot_ratings = rawData["pilot_ratings"]

with open("result/public_html/general.json", "w+") as f:
    json.dump(general, f)

with open("result/public_html/pilots.json", "w+") as f:
    json.dump(pilots, f)

with open("result/public_html/controllers.json", "w+") as f:
    json.dump(controllers, f)

with open("result/public_html/atis.json", "w+") as f:
    json.dump(atis, f)

with open("result/public_html/servers.json", "w+") as f:
    json.dump(servers, f)

with open("result/public_html/prefiles.json", "w+") as f:
    json.dump(prefiles, f)

with open("result/public_html/facilities.json", "w+") as f:
    json.dump(facilities, f)

with open("result/public_html/ratings.json", "w+") as f:
    json.dump(ratings, f)

with open("result/public_html/pilot_ratings.json", "w+") as f:
    json.dump(pilot_ratings, f)