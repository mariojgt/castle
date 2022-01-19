# Castle

This Laravel packages has been design to quickly add 2 steps verifications i am very simple way and very easy to expand.

# Features

-   [ ] Demo with the example flow you need.
-   [ ] 2 steps autentication.
-   [ ] middlewhere protection.
-   [ ] 

### First option via composer

1. composer require mariojgt/castle
2. php artisan install::castle

This will copy the resource assets, run migrations and copy over some config file we need to use;

## How to use

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

2:In order to sync the user you need to first generate the authenticator secret using the helper normally when you register or with a controller method to sync the autenticator

```php
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class myController 
{
    public register () {
	    // Start the class that handle most of the logic
	    $handle = new AutenticatorHandle();
	    // Generate the code 
		$codeInfo =	    $handle->generateCode($userEmail);
		// Sync that code with the user using the trait
		Auth()->user()->syncAutenticator($codeInfo['secret']);
    }
```

3: At this point the authenticator is enabled again that user, now you need to protect the middlewhere here is a example

```php
// Auth Route Example
Route::group([
    'middleware' => ['web', '2fa'], // note you can use (2fa:admin) for admin guard or leave empty for web as default
], function () {
    // Example page required to be login
    Route::get('/castle-try', [HomeContoller::class, 'protected'])->name('castle.try');
});

```

4:Display the user codes, normaly you only display the backup codes once you can use the following example

```
Auth()->user()->getCodes; // this will return the backup codes for that user
```

5:using backup codes see the example

```php
use Mariojgt\Castle\Helpers\AutenticatorHandle;

myclass {

	public myFuction () {
		 // Start the class that handle most of the logic
		$handle = new AutenticatorHandle();
		$handle->useBackupCode($codeYouType, $encryptAutenticatorSecret); // The second parameter is not required
	}

}
```

