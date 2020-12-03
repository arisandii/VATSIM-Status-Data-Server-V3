import urllib.request, subprocess, random

# VATSIM Data Link variable
vatsimDataLink = []

req = urllib.request.Request(
    "http://status.vatsim.net/status.txt",
    data=None, 
    headers={
        'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.47 Safari/537.36'
    }
)

# Iterate over data
for line in urllib.request.urlopen(req):
    
    # Decode bytes to string
    # With that splitlines() function
    line = line.decode("utf-8").splitlines()
    
    # Check if json3 exists
    if "json3=" in line[0]:
        # If exists, split data and get the link
        vatsimDataLink.append(line[0].split("=")[1])
    

# Get random link to download
linkToDownload = random.choice(vatsimDataLink)

# Download the file
urllib.request.urlretrieve(linkToDownload, 'vatsim-data.json')