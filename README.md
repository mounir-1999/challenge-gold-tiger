## Setup
- Downlod source code
- Install dependencies
- Copy .env.example values to .env
- Update env variables (database, mail)
- run `php artisan migrate`
- run `php artisan db:seed` for adding some data to the database (10 users)
- Run `php artisan serve` and `php artisan queue:work --tries=3` for running laravel server and queue server
## Notes
- For mail, I used Laravel Blade templates and Mail Facade, as they are built in with laravel and provides many useful features.
- For queues, I used Laravel queues (database connection), as it provides built it queue system, and is very easy to setup and can expand as the project requires (jobs, delaying jobs, failed jobs are saved in database under `failed_jobs`...).
- I setup mail service file, so its easy for me to use it in controller or using CLI command or in later files if needed.
- For queueing mails in mail service, I used the built-in queues in mail facade (without creating jobs and dispatching them), as no logic is required to run with sending the mail, just send the mail using queue system.
- I didn't set the mailtrap env variables in .env.example as the repository will be public.