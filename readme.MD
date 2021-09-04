
# SDMN CC Checker Bot [Heroku]

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
    - You can customize the time in ```ENVIRONMENT_VARIABLES`` on Heroku

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

### Hosting on Heroku
    
 [![Deploy To Heroku](https://www.herokucdn.com/deploy/button.svg)](https://dashboard.heroku.com/new?template=https%3A%2F%2Fgithub.com%2Fiam-NVN%2FSDMN_CheckerBot%2Fblob%2Fheroku-version)
 - Star and Fork this Repo
 - Click on the Above Shown ```Deploy To Heroku``` Button
 - Get Free Database from [Here](https://freesqldatabase.com)
 - Login to [WebPHPmyAdmin](http://www.phpmyadmin.co) with DB Credentials
 - Import checkerbot.sql file into your Database through PHPmyAdmin
 - Enter the Vars asked whilst Deploying the App
 - Set Webhook to main.php in your Heroku app
   - https://api.telegram.org/bot[BOTTOKEN]/setWebhook?url=https://[HEROKUAPPNAME].herokuapp.com/main.php   <br />
    Open the URL Replacing ```[BOTTOKEN]``` With your BotToken and ```[HEROKUAPPNAME]``` with your Heroku App Name
 <br />


## 🎯 Author

- [@iam-NVN](https://www.github.com/octokatherine)

## 💸 Donations 
If you're feeling generous and want to support this project, you can donate 

<a href="https://www.blockchain.com/btc/address/33Kya1FcwLBUfPwfH6GTkyZswH9RZjPr51">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2WR24fnzSsiHf1TmpIWQn_E3qgJTLBcsK5w&usqp=CAU" alt="Bitcoin" height="25" style="margin-left: 15px;"/>
</a> - Donate through Bitcoin


  
  
