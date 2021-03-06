# Two Factor Sms
A two-factor auth provider for Nextcloud 14 and up. See [my blog post](http://blog.wuc.me/2016/05/30/adding-two-factor-auth-to-owncloud.html) on more info about Nextcloud's internal 2FA.

[![Build Status](https://travis-ci.org/nextcloud/twofactor_gateway.svg?branch=master)](https://travis-ci.org/nextcloud/twofactor_gateway)
[![Code Coverage](https://scrutinizer-ci.com/g/nextcloud/twofactor_gateway/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/nextcloud/twofactor_gateway/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nextcloud/twofactor_gateway/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nextcloud/twofactor_gateway/?branch=master)

![](https://raw.githubusercontent.com/ChristophWurst/twofactor_gateway/ae08ce30abfa866c7c7a486d850d4be07b83d82d/screenshots/challenge.png)

## Supported Messaging Gateways
This app uses external messaging gateways services for sending the code. The idea is to support multiple providers as different countries have their specific providers.

See the [admin documentation](/doc/admin) on how to configure the specific providers.

## Login with external apps
All modern applications communicating with Nextcloud now use Login flow so you will be able to log in just like you would on the web, including, but not limited to SMS-based authentication.

Absent support for the Login flow, after enabling Two Factor SMS, your legacy applications will accept device passwords.
To manage them, [see more here](https://docs.nextcloud.com/server/14/user_manual/session_management.html#managing-devices)
