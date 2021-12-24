
# SDMN CC Checker Bot

A Telegram CC Checker Bot with hella lotta features.


## 🚀 Features

- **Admin Panel**
    - Ban a user
    - Unban a user
    - Mute a user
    - Unmute a user
    - Check Global bot stats
    - Check CC Checker stats of a user

- **Anti-Spam System**
    - Users have to wait a certain amount of time before performing the next task
    - You can customize the time in config/config.php

- **Checker Stats System**
    - Number of Live and Dead CC Checked by a User, and All users will be Visible
     
    ```` 
    ≡ User Stats

    - Total Cards Checked: 25
    - Total CVV Cards: 4
    - Total CCN Cards: 2

    ≡ Global Checker Stats

    - Total Cards Checked: 30
    - Total CVV Cards: 8
    - Total CCN Cards: 7
    ```` 
- **Stripe Merchant [User]**
    - Users can add their own SK Key and check CCs with the added SK Key

## 🛠 Commands
- **💳 CC Checker**
    ```
    /ss | !ss - Stripe [Auth]
    /sm | !sm - Stripe [Merchant]
    /schk | !schk - User Stripe Merchant [Needs SK]

    /apikey sk_live_xxx - Add SK Key for /schk gate
    /myapikey | !myapikey - View the added SK Key for /schk gate
    ```

- **📡 Other Commands**
    ```
    /me | !me - User's Info
    /stats | !stats - Checker Stats
    /key | !key - SK Key Checker
    /bin | !bin - Bin Lookup
    /iban | !iban - IBAN Checker
    ```

  
## ⚙️ Deployment

### Hosting on Server [MySQL DB Required]

 - Download the Files from [Here](https://github.com/iam-NVN/SDMN_CheckerBot/archive/refs/heads/main.zip)
 - Upload it to your Server and Extract it
 - Edit config/config.php file and set Admin ID, Logs ID, DB Credentials and SK Keys
 - Import checkerbot.sql file into your Database through PHPmyAdmin
 - Set Webhook to main.php in root folder of bot 

### Hosting on Heroku
**[Click Here to go to Heroku Version](https://github.com/iam-NVN/SDMN_CheckerBot/tree/heroku-version)**


## 🎯 Author

- [@iam-NVN](https://www.github.com/octokatherine)

## 💸 Donations 
If you're feeling generous and want to support this project, you can donate 

<a href="https://www.blockchain.com/btc/address/1BNdZDEMfwaFfKULKucMkytXVqoWp4dfij">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2WR24fnzSsiHf1TmpIWQn_E3qgJTLBcsK5w&usqp=CAU" alt="Bitcoin" height="25" style="margin-left: 15px;"/>
</a> - Donate through Bitcoin


  
  
