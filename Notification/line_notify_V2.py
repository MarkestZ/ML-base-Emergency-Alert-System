import requests
from colorama import Fore, Style, init

# Initialize colorama
init()
line_token = '4F21lpcx0Vjd7NUKXZsDEi9GN6NtuhGmENwfbTxKUa9'
def send_line_notify(message):
    url = 'https://notify-api.line.me/api/notify'
    headers = {
        'Authorization': f'Bearer {line_token}'
    }
    data = {
        'message': message
    }
    response = requests.post(url, headers=headers, data=data)
    
    if response.status_code == 200:
        print(Fore.GREEN + 'Notification sent successfully!' + Style.RESET_ALL)
    else:
        print(Fore.RED + f'Failed to send notification. Status code: {response.status_code}' + Style.RESET_ALL)

# Example function to send a custom notification based on the place name
def send_emergency_notification(Place_name, Place_location):
    message = f'Emergency situation alert!!!! : Gunshot detected\nin {Place_name}: {Place_location}\nPlease leave that area immediately.\nPolice call : 191'
    send_line_notify(message)
