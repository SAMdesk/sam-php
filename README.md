## Overview

This repo contains a node middleware to simplify the usage of the SAM API.

## Installation

Obtain the latest version of the SAM PHP bindings with:

`git clone https://github.com/SAMDesk/sam-php`

## Documentation

Up to date API Documentation can be found [here](https://api.samdesk.io).

## Getting Started

To get started, add the following to your PHP script:

`require_once("/path/to/sam-php/lib/SAM.php");`

Simple usage looks like:

```php
SAM::setAuth(array("api_key" => {API_KEY}));
$account = SAM_Account::retrieve();
echo $account;
```

## Dependencies

This library requires PHP cURL to function. Please make sure you have cURL enabled on your servers.

