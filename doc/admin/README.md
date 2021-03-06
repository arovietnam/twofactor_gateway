# Admin Documentation

## Gateways

Here you can find the configuration instructors for the currently supported gateways.

### playSMS
Url: https://playsms.org/
Stability: Experimental

Use the Webservices provided by playSMS for sending SMS.

Admin configuration:
```bash
./occ config:app:set twofactor_gateway sms_provider --value "playsms"
./occ config:app:set twofactor_gateway playsms_url --value "playsmswebservicesurl"
./occ config:app:set twofactor_gateway playsms_user --value "yourusername"
./occ config:app:set twofactor_gateway playsms_password --value "yourpassword"
```

### Signal
Url: https://www.signal.org/
Stability: Experimental

Admin configuration:
```bash
./occ config:app:set twofactor_gateway sms_provider --value "signal"
```

### Telegram
Url: https://www.telegram.org/
Stability: Unstable

Uses Telegram messages for sending a 2FA code

Admin configuration:
```bash
./occ config:app:set twofactor_gateway sms_provider --value "telegram"
./occ config:app:set twofactor_gateway telegram_bot_token --value "your telegram bot api token"
./occ config:app:set twofactor_gateway telegram_url --value "https://api.telegram.org/bot"
```

Specific entries in `oc_preferences`:
- userid: your Nextcloud user UID
- appid: ``twofactor_gateway``
- configkey: ``telegram_id``
- configvalue: your telegram id. You can get your telegram id by searching the user <b>What's my Telegram ID?</b> in Telegram and start the conversation.

### websms.de
Url: https://websms.de/
Stability: Stable

Admin configuration:
```bash
./occ config:app:set twofactor_gateway sms_provider --value "websms.de"
./occ config:app:set twofactor_gateway websms_de_user --value "yourusername"
./occ config:app:set twofactor_gateway websms_de_password --value "yourpassword"
```
