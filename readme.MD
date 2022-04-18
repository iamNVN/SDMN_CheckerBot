
  
## ⚙️ Deployment

### Hosting on Heroku
    
 [![Deploy To Heroku](https://www.herokucdn.com/deploy/button.svg)](https://github.com/LanaTPG/lanachecker/tree/heroku-version)
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
