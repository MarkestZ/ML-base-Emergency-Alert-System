import serial
import re
import subprocess

ser = serial.Serial(port="COM5", baudrate=9600)
cd = 0

# Initialize variables to store predictions
gunsound_value = 0.0
scream_value = 0.0
#noise_value = 0.0

def post_notify():
    subprocess.run(["python","line_notify.py"])

while True:
    value = ser.readline()
    valuestr = str(value, "UTF-8").strip()  # Strip newline and extra spaces
    
    # Use regular expressions to find the values
    gunsound_match = re.search(r'Gunsound:\s([0-9]*\.?[0-9]+)', valuestr)
    scream_match = re.search(r'Scream:\s([0-9]*\.?[0-9]+)', valuestr)
    # noise_match = re.search(r'Noise:\s([0-9]*\.?[0-9]+)', valuestr)
    
    # Update variables if matches are found
    if gunsound_match:
        gunsound_value = float(gunsound_match.group(1))
    if scream_match:
        scream_value = float(scream_match.group(1))  
    #if noise_match:
        #noise_value = float(noise_match.group(1))

    # Print the predictions after reading the line
    print(f"Gunsound: {gunsound_value:.6f}")
    print(f"Scream: {scream_value:.6f}")
    #print(f"Noise: {noise_value:.6f}")
    print(f"")
    print(f"-------------------------------------")
    print(f"")
    
    # Check for threshold and cooldown period
    if cd == 0:
        if gunsound_value >= 0.9:  # Assuming the threshold is 0.5, adjust as needed
            post_notify()
            cd = 360  # Reset cooldown
           
        elif scream_value >= 0.9:
            post_notify()
            cd = 360  # Reset cooldown
           
    else:
        cd -= 1
        print(f"Cooling down: {cd}")
    
    # Sleep for a while if needed to prevent high CPU usage
    # time.sleep(1)
