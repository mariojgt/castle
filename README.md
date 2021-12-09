# Castle

This Laravel packages has been design to quickly add 2 steps verifications i am very simple way and very easy to expand.

# Features

-   [ ] Demo with the example flow you need.
-   [ ] 2 steps autentication.
-   [ ] middlewhere protection.

### First option via composer

1. composer require mariojgt/castle
2. php artisan install::castle

This will copy the resource assets, run migrations and copy over some config file we need to use;

## How to use

The way it works is you request to the server the code generation based on the email you type, that will return a qr code in svg format and you secret used to the authentication in the authentication, work with any authenticator 2fas, after you display that qrcode and the user sync with his phone you can use that secret to link his account to the secrete and automatic generate encrypted backup codes that can be use to recover the account, more information checkout the demo.

