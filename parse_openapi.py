import json
import urllib.request
import os

try:
    if os.path.exists("openapi.json"):
        with open("openapi.json", "r", encoding="utf-8") as f:
            data = json.load(f)
        paths = data.get("paths", {}).keys()
        print("Endpoints in openapi.json:")
        for path in paths:
            print(f"- {path}")
    else:
        # Might be fetched from a server instead if they didn't provide a file
        url = "https://bird-edge-api-879683801404.asia-east1.run.app/openapi.json"
        print(f"openapi.json not found locally! Attempting to fetch from {url}...")
        req = urllib.request.urlopen(url)
        data = json.loads(req.read())
        paths = data.get("paths", {}).keys()
        print(f"Endpoints fetched from {url}:")
        for path in paths:
            print(f"- {path}")
except Exception as e:
    print(f"Error parsing OpenAPI file: {e}")
