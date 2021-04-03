import urllib.request, subprocess, random, json

# VATSIM Data Link variable
vatsimDataLink = []
rawData = None

urllib.request.urlretrieve('https://status.vatsim.net/status.json', 'status.json')

with open("status.json", "r", errors="ignore") as jData:
    rawData = json.load(jData)

datav3 = rawData["data"]["v3"]

# Get random link to download
linkToDownload = random.choice(datav3)

# Download the file
urllib.request.urlretrieve(linkToDownload, 'vatsim-data.json')