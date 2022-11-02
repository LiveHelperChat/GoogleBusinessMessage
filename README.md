# Starting point

Register your project here https://business-communications.cloud.google.com/console/

## Install

### Install database

Execute `extension/googlebusinessmessage/doc/install.sql` or just execute from command line

```
php cron.php -s site_admin -e googlebusinessmessage -c cron/update_structure
```

### Export `Service account`

* Go to https://business-communications.cloud.google.com/console/
* Click `Parner account settings`
* Click `Service account`
* Create key and download json file.
* Copy `settings/google_service.json.default.php` to `settings/google_service.json.php`
* Modify file and put json file content in dedicated place in `settings/google_service.json.php` file.

Truncated sample file
![image](https://user-images.githubusercontent.com/1146085/199461664-58fcf6fb-2d63-4cfd-b7a9-486f7baa8c5e.png)

## Hierarchy

* Partner
* Agent
* Service Account export

### Usefull links

* https://github.com/googleapis/google-api-php-client - PHP library
* https://developers.google.com/business-communications/business-messages/guides - main documentation page
* https://github.com/google-business-communications/bm-snippets-curl - code samples with CURL
* https://github.com/google-business-communications/bc-bm-nodejs-command-line-examples - NodeJS samples
