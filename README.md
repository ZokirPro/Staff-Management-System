### Configuration

Make sure that this project has proper file permissions.
To run this project, you will need to set up a database and a smtp server for password reset and add it to your .env file

For npm packages, run:

```console
composer install
```

For application to have unique key, run
```console
php artisan key:generate
```

After that, you run migration to get it running.

```console
php artisan migrate
```

And link public folder to storage for file uploads

```console
php artisan storage:link
```

To get initial test data in database

```console
php artisan db:seed
```
