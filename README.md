# Sistem Informasi SMP Sunan Giri

Website SMP Sunan Giri beserta PPDB Online

## Teams

[Ahmad Ivan Reyhan](https://github.com/IvanReyhan22) as Project Manager
[David Surya](https://github.com/davpyu) as Co-PM
[Titto Mahogany A]() as FrontEnd Developer  
[Alifa Fitriana P.Y]() as FrontEnd Developer  
[M Ghazy Al-Ghifari](https://github.com/Magniplayz) as BackEnd Developer  
[Ferdi Yusuf S](https://github.com/ferdiys) as BackEnd Developer  
[Robet Atiq]() as Database Analyst  
[Ummu Cholifatul Latifah](https://github.com/latifah1105) as Tester  
[Alif Anantomi]() as Product Analyst  
[Shalvina Eka]() as Product Analyst  
[Dimas Riski]() as Product Installer  
[Alvina Yusan P]() as Product Installer  

## Preview

![alt text](https://raw.githubusercontent.com/ferdiys/PKK-SISG/master/Preview/pkk.png)

## Prerequisites

* [XAMPP](https://www.apachefriends.org/download.html) - Server Lokal (Gunakan versi terbaru)
* [Composer](https://getcomposer.org/download/) - PHP Dependency Manager
* [NPM](https://nodejs.org/en/) - JS Package Manager

## Installation

#### Clone the repository

```bash
git clone https://pkk_sisg@bitbucket.org/pkk_sisg/sisg
```

#### Open your project

```bash
cd '\path\to\your\project'
```

#### Installing Laravel Dependencies

```bash
composer install
```

#### Copy .env

Windows
```bash
copy .env.example .env 
```
Linux
```bash
cp .env.example .env 
```

#### Generate key

```bash
php artisan key:generate
```

#### Installing Javascript Dependencies

```bash
npm install && npm run dev
```

#### Update these setting in .env file:

* DB_DATABASE (your local database, i.e. "sisg")
* DB_USERNAME (your local db username, i.e. "root")
* DB_PASSWORD (your local db password, i.e. "")

#### Run your server

Use XAMPP or run these

```bash
php artisan serve
```
and open it on your browser with url localhost:8000 or 127.0.0.1:8000

#### Migrate your database

```bash
php artisan migrate --seed
```

#### Make symlink

```bash
php artisan storage:link
```

## Updating project

#### Pulling latest update

```bash
git pull <remote> master
```

#### Updating composer dependencies

```bash
composer update
```

#### Updating database

```bash
php artisan migrate:refresh --seed
```

## Other Notes

**Laravel Docs:**

[https://laravel.com/docs/6.x](https://laravel.com/docs/6.x)

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
