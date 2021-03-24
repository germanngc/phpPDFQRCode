# phpPDFQRCode
Create a PDF within a QR Code that redirects to the URL of the PDF

# Requirements

* php 7.4
* mysql 8

## 1. Clone the App

``` zsh
$ git clone https://github.com/germanngc/phpPDFQRCode.git
```

## 2. Create .env file
``` zsh
$ cp .env.example .env
$ vim .env
# Add your local credentials
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=labsal
DB_USERNAME=labsal_usr
DB_PASSWORD=labsal_pss
```

## 3. Test
``` zsh
$ php -S localhost:8000
```

Open a web browser

# Licence

Copyright (c) 2018 - 2021 Nina Code. MIT Licensed, see [LICENSE] for details.

[LICENSE]:https://github.com/germanngc/phpPDFQRCode/blob/main/LICENSE.md
[http://localhost:8000/]:http://localhost:8000/