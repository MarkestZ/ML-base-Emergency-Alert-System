import serial
import re
import pymysql
import time
import line_notify_V2
import subprocess
ser = serial.Serial(port="COM5", baudrate=9600)
cd = 0

# Initialize variables to store predictions
gunsound_value = 0.0
scream_value = 0.0
Place_ID = 3  # you can change a location by change the value of this variable
Place_name = ""
Place_location = ""
danger_start_time = None  # To track when "Danger" status starts
danger_duration = 60  # (60 seconds) in seconds for danger duration

# MySQL database connection
db = pymysql.connect(
    host="localhost",
    user="root",
    password="maki43499",
    database="EAS"
)

cursor = db.cursor()

#LINE NOTIFY
def post_notify(Place_name,Place_location):
    line_notify_V2.send_emergency_notification(Place_name,Place_location)
#Post tweet on X
def post_tweet():
    subprocess.run(["node", "post_tweet.js"])
#Change Place's Status
def change_place_stat(stat, place_id):
    try:
        # Update the 'Place_Stat' in the database for the given place
        sql = "UPDATE Place SET Place_Stat = %s WHERE Place_ID = %s"
        cursor.execute(sql, (stat, place_id))
        db.commit()
        print(f"\033[92mPlace {place_id} status changed to {stat}\033[0m")  # Green for success
    except Exception as e:
        print(f"\033[91mError updating place status: {e}\033[0m")  # Red for failure
        db.rollback()
sql = "SELECT Location_Name, Location_where FROM location WHERE Location_ID = %s"
cursor.execute(sql, (Place_ID,))
result = cursor.fetchone()
if result:
    Place_name, Place_location = result


# Main loop to read data from the serial port
while True:
    value = ser.readline()
    valuestr = str(value, "UTF-8").strip()  # Strip newline and extra spaces
    
    # Use regular expressions to find the values
    gunsound_match = re.search(r'Gunsound:\s([0-9]*\.?[0-9]+)', valuestr)
    scream_match = re.search(r'Scream:\s([0-9]*\.?[0-9]+)', valuestr)
    
    # Update variables if matches are found
    if gunsound_match:
        gunsound_value = float(gunsound_match.group(1))
    if scream_match:
        scream_value = float(scream_match.group(1))
    
    # Print the predictions after reading the line
    print(f"Gunsound: {gunsound_value:.6f}")
    print(f"Scream: {scream_value:.6f}")
    print(f"-------------------------------------")
    
    # Check for threshold and cooldown period
    if cd == 0:
        if gunsound_value >= 0.9 or scream_value >= 0.9:  # Threshold for detection
            post_notify(Place_name,Place_location)  # Send notification (line_notify)
            post_tweet()
            change_place_stat("Danger", Place_ID)  # Update place status to "Danger"
            danger_start_time = time.time()  # Start tracking time when danger was detected
            cd = 600  # Reset cooldown to avoid multiple alerts

    else:
        cd -= 1
        print(f"Cooling down: {cd}")
    
    # Check if the place has been in "Danger" for more than 1 minute
    if danger_start_time:
        elapsed_time = time.time() - danger_start_time
        if elapsed_time > danger_duration:
            change_place_stat("Peaceful", Place_ID)  # Change place status back to "Peaceful"
            danger_start_time = None  # Reset danger start time
    
