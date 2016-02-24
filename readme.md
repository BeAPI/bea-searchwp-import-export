# BEA SearchWP Import Export #

## Description ##

This enhance SWP admin. Instead of copy/paste json export/import data in textarea, just export/import json files

## Important to know ##

To get this work, use composer :

```
git clone https://github.com/bea/bea-swp-import-export && cd bea-swp-import-export
composer dump-autoload
```

Then go to tools > SWP Import Export page to import or export your settings

In case you want to include this small plugin to your project running composer you can add this line to your composer.json :

```
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/BeAPI/bea-searchwp-import-export"
    }
  ]
```

then run the command :

```
composer require bea/bea-swp-import-export dev-master
```

## Changelog ##

### 0.1
* 24 Feb 2016
* initial
