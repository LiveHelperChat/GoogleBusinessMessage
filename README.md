# Starting point

Register your project here https://business-communications.cloud.google.com/console/

## Install

### Preparing

* Upload the files to your `lhc_web/extension/googlebusinessmessage` folder
* if your folder contain lower and Upper cases,rename it to `googlebusinessmessage`

### Export `Service account`

* Go to https://business-communications.cloud.google.com/console/
* Click `Create Partner Account` on the `Business Messages`
* Then Fill the necessery details and Click `Create`
* Click `Patrner account settings` on top right corner (Gear Icon)
* Click `Service account`
* Create key and download json file.
* Copy `settings/google_service.json.default.php` to `settings/google_service.json.php`
* Modify file and put json file content in dedicated place in `settings/google_service.json.php` file.

Truncated sample file

![image](https://user-images.githubusercontent.com/1146085/199461664-58fcf6fb-2d63-4cfd-b7a9-486f7baa8c5e.png)


### Instalation

* Execute `extension/googlebusinessmessage/doc/install.sql` or just execute from command line

```
php cron.php -s site_admin -e googlebusinessmessage -c cron/update_structure
```
* Install dependencies using composer
```
cd extension/googlebusinessmessage && composer install
```
* Activate extension in main settings file `lhc_web/settings/settings.ini.php` extension section googlebusinessmessage by Adding lines:
```
'extensions' =>  array (  ,'googlebusinessmessage'  ),
```
* If you don't see this in Module, check your `lhc_web/settings/settings.ini.php` and also click Clean Cache from back office

### Configuration
* Click `Modules` then click `Google Business`
* Then Click `Install/Update` (Colour will change from Red to Green )
* Then Click `Agents` and fill the requred field
  * `Brand ID` and `Agent ID` can be found in your Google Business Communications page
  * Put random string on `Client Token`
  * copy `Callback URL for Google Business Message` value to your clipboard and click save
* Go to your `Google Business Communications page` and click on `Intergration`
* Then Enable `Webhook`
* Put your `Webhook EndPoint URL` and `Client Token`  
* Click Verify




## Hierarchy

* Partner
* Agent
* Service Account export

### Usefull links

* https://github.com/googleapis/google-api-php-client - PHP library
* https://developers.google.com/business-communications/business-messages/guides - main documentation page
* https://github.com/google-business-communications/bm-snippets-curl - code samples with CURL
* https://github.com/google-business-communications/bc-bm-nodejs-command-line-examples - NodeJS samples
