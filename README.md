# 24Sessions test assignment

## Installation

1. Clone repo

```
git clone https://github.com/dimichspb/sessions
```

2. Change directory

```
cd sessions
```

3. Install dependenies

```
composer install
```

## Configuration

1. Define db connection settings

Development and testing:
```
config\dev.php
```

Production:
```
config\prod.php
```

2. Setup apache configuration

```
<VirtualHost *:80>
    DocumentRoot "C:/Projects/PHP/sessions/web"
    ServerName sessions.localhost
    <Directory "C:/Projects/PHP/sessions/web">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all Granted
    </Directory>
</VirtualHost>
```

3. Restart apache service

```
apachectl restart
```

4. Apply migrations

Development and testing:
```
php bin\console_test migrate-up
```

Production:
```
php bin\console migrate-up
```

## Usage

1. Web GUI

```
http://sessions.localhost
```

## Tests

```
vendor\bin\phpunit
```