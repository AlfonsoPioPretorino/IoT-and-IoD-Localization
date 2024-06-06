import requests
import time
import json
j = {
    "positions": [
      {"latitude": 41.1199, "longitude": 16.8682},
      {"latitude": 41.1209, "longitude": 16.8682},
      {"latitude": 41.1219, "longitude": 16.8682},
      {"latitude": 41.1229, "longitude": 16.8682},
      {"latitude": 41.1239, "longitude": 16.8682},
      {"latitude": 41.1249, "longitude": 16.8682},
      {"latitude": 41.1259, "longitude": 16.8682},
      {"latitude": 41.1269, "longitude": 16.8682},
      {"latitude": 41.1279, "longitude": 16.8682},
      {"latitude": 41.1289, "longitude": 16.8682}
    ]
  }
# Define the URL to which you want to send the POST request
url = "http://178.62.210.227/api/save-packet"
temp = json.dumps(j)
# Define a function to send the POST request
def send_post_request(js):
    response = requests.post(url, js)
    print(i, "POST request sent. Response: ", response.text)

# Loop indefinitely, sending a POST request every 10 seconds
for i in range(3):
    temp = json.dumps(j['positions'][i])
    send_post_request(temp)
    print("Waiting 10 seconds")
    time.sleep(3)  # Wait for 10 seconds before sending the next request