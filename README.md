# Bot IP Block with ASN
Bot IP Blocker with ASN via MMDB and PHP maxmind-db/reader.

## Install the maxmind-db/reader with composer

Open a SSH terminal on the server.

// check version
```
composer --version
```

// make dir
```
public/
└── mmdbbotblock/
    └── composer/
```
// load and save the composer folder and files
```
cd path-to-your/public/mmdbbotblock/composer
```
```
composer require maxmind-db/reader
```
result:
```
mmdbbotblock/
    └── composer/
    ├── composer.json
    ├── composer.lock
    └── vendor/
        ├── composer
            └── ...
        ├── maxmind-db
            └── reader/
                └── ...
        └── autoload.php
```

## Save the Bot IP Blocker files on the server
```
mmdbbotblock/
    ├── mmdbASNarray.php
    ├── mmdbASNreader.php
    └── composer/
```

You can edit and expand the Bot IP Blacklist to append new ASN (names) in the file `mmdbASNarray.php`

It is case insensitive, because the strings are compared in lower case.    
It works also with substrings.   

## DP-IP IP to ASN Lite database

download: https://db-ip.com/db/download/ip-to-asn-lite

Save it in the folder `path-to-your/public/mmdbbotblock/database/`

unzip
```
gzip -d dbip-asn-lite-2026-07.mmdb.gz
```
or
```
gunzip dbip-asn-lite-2026-07.mmdb.gz
```

## Use it in your website
Put the PHP code on the top of your website.
(above headers and above `<!DOCTYPE html>`)
```
<?php
// MMDB IP to ASN Blocker
include '/path-to-your/mmdbbotblock/mmdbASNreader.php';
?>
```

