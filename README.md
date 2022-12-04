
![Logo](https://raw.githubusercontent.com/mariojgt/castle/main/Publish/Art/logo.png)


# Castle

This Laravel package help you quickly add 2fa authentication in you existing application, simular to google authentication.


## Features

- Demo with the example application flow you need.
- 2 steps autentication.
- middleware protection.


## Badges

Add badges from somewhere like: [shields.io](https://shields.io/)

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
[![version](https://img.shields.io/packagist/v/mariojgt/castle?style=for-the-badge)](http://www.gnu.org/licenses/agpl-3.0)


## Installation

Install my-project with composer

```bash
  composer require mariojgt/castle
  php artisan install::castle
```
    
## Usage/Examples

1: You need to assign the trait to you user model table in order to use the 2steps verification and have access to the backup codes.

```php
use Mariojgt\Castle\Trait\Castle;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Castle;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
```
this will insure you have access to the backup codes

2: In order to sync the user you need to first generate the authenticator secret using the helper normally when you register or with a controller method to sync the authenticator
```php
use Mariojgt\Castle\Helpers\AuthenticatorHandle;

class myController
{
    public register () {
	    // Start the class that handle most of the logic
	    $handle = new AuthenticatorHandle();
	    // Generate the code
		$codeInfo =	    $handle->generateCode($userEmail);
		// Sync that code with the user using the trait
		Auth()->user()->syncAuthenticator($codeInfo['secret']);
    }
```

3: At this point the authenticator is enabled against that user, now you need to protect the middleware here is a example

```php
// Auth Route Example
Route::group([
    'middleware' => ['web', '2fa'], // note you can use (2fa:admin) for admin guard or leave empty for web as default
], function () {
    // Example page required to be login
    Route::get('/castle-try', [HomeContoller::class, 'protected'])->name('castle.try');
});
```
4: Display the user codes, normaly you only display the backup codes once you can use the following example

```php
Auth()->user()->getCodes; // this will return the backup codes for that user
```
5: using backup codes see the example

```php
use Mariojgt\Castle\Helpers\AuthenticatorHandle;

myclass {

	public myFunction () {
		 // Start the class that handle most of the logic
		$handle = new AuthenticatorHandle();
		// the encryption is using the normal laravel encrypt fuction // example encrypt('user_secret')
		$handle->useBackupCode($codeYouType, $encryptauthenticatorSecret); // The second parameter is not required
	}

}
```
## Tech Stack

**Client:** TailwindCSS, vuejs, blade

**Server:** 2fa, Laravel

