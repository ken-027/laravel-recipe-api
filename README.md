## Laravel Recipe API

<p>
    <img src="https://i.pinimg.com/originals/c7/94/be/c794be5349bc93ec47a2a17daab1b279.gif" alt="dish animation" />
</p>

#### Overview

> Api Architecture Style

| Branches    | Api Architecture |
| ----------- | ---------------- |
| **rest**    | Rest api         |
| **graphql** | Grapqhl api      |

> Features

- [x] Authentication & Authorization
- [x] `Create`, `Read`, `Update`, and `Delete` for **Recipes**
- [x] `Create`, `Read`, `Update`, and `Delete` for **Instructions**
- [x] `Create`, `Read`, `Update`, and `Delete` for **Ingredients**

#### Commands

```batch
copy .env.example .env && copy .env.testing
```

copy env template to .env and .env.testing and configure variables based on your preferences

```batch
composer install
```

install all composer dependencies

```batch
php artisan key:generate`
```

generate key for the application

```batch
php artisan migrate --seed
```

run migration and seed database

```batch
php artisan serve
```

running the application on port 8000

```url
http://localhost:8000/graphiql
```

for schema documentation

</br>
</br>
<p align="center"><b>Based on Laravel Framework</b></p>

![Laravel Logo](https://assets.stickpng.com/images/62a4c892fdee15d2905007c8.png)
