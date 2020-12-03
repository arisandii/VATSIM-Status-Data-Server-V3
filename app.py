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

with open("result/general.json", "w+") as f:
    json.dump(general, f)

with open("result/pilots.json", "w+") as f:
    json.dump(pilots, f)

with open("result/controllers.json", "w+") as f:
    json.dump(controllers, f)

with open("result/atis.json", "w+") as f:
    json.dump(atis, f)

with open("result/servers.json", "w+") as f:
    json.dump(servers, f)

with open("result/prefiles.json", "w+") as f:
    json.dump(prefiles, f)

with open("result/facilities.json", "w+") as f:
    json.dump(facilities, f)

with open("result/ratings.json", "w+") as f:
    json.dump(ratings, f)

with open("result/pilot_ratings.json", "w+") as f:
    json.dump(pilot_ratings, f)