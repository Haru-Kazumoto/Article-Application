
# ArticleNest

a nest of articles from the latest technology information news that is currently developing


## Features

- List of articles
- Read article
- Filtering by title and slugs
- Back office management (not enough time, access at /office path)


## Deployment

Setup the project:

install laravel packages (laravel 11, require php 8+)
```bash
  composer install
```
install Frontend packages (require node 20.19.0)
```bash
  npm install
```
Get the app key (also setup your database at .env)
```bash
  php artisan key:generate
```

Run the seeder and factory
```bash
  php artisan db:seed
```

Run the project (use seperate terminal for dual server) :
```bash
  php artisan serve
```
```bash
  npm run dev
```
## Feedback

The projects is not full enough yet due to not enough time
