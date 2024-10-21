import requests
from colorama import Fore, Style, init

# Initialize colorama
init()

def send_line_notify(message, token):
    url = 'https://notify-api.line.me/api/notify'
    headers = {
        'Authorization': f'Bearer {token}'
    }
    data = {
        'message': message
    }
    response = requests.post(url, headers=headers, data=data)
    
    if response.status_code == 200:
        print(Fore.GREEN + 'Notification sent successfully!' + Style.RESET_ALL)
    else:
        print(Fore.RED + f'Failed to send notification. Status code: {response.status_code}' + Style.RESET_ALL)

# Your access token and updated message with a line break
line_token = '4F21lpcx0Vjd7NUKXZsDEi9GN6NtuhGmENwfbTxKUa9'
message = 'Emergency situation alert!!!! : Gunshot detected\nin this area : https://maps.app.goo.gl/YEwFfvHY1o3Agchx8\nPlease leave that area immediately.\nPolice call : 191'

# Send the notification
send_line_notify(message, line_token)

