# SilverStripe RestfulServer Module

[![Build Status](http://img.shields.io/travis/xini/silverstripe-soapserver.svg?style=flat-square)](https://travis-ci.org/xini/silverstripe-soapserver)
[![Code Quality](http://img.shields.io/scrutinizer/g/xini/silverstripe-soapserver.svg?style=flat-square)](https://scrutinizer-ci.com/g/xini/silverstripe-soapserver)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/xini/silverstripe-soapserver.svg?style=flat-square)](https://scrutinizer-ci.com/g/xini/silverstripe-soapserver)
[![Version](http://img.shields.io/packagist/v/innoweb/silverstripe-soapserver.svg?style=flat-square)](https://packagist.org/packages/innoweb/silverstripe-soapserver)
[![License](http://img.shields.io/packagist/l/innoweb/silverstripe-soapserver.svg?style=flat-square)](license.md)

## Overview

SOAP server class which auto-generates a WSDL file to initialize PHPs integrated `SoapServer` functionality.
Extended by `SOAPModelAccess` to scaffold WSDL for a specific class.

**This module is just a wrapper for the "[restfulserver](https://github.com/silverstripe/silverstripe-restfulserver)" module,
internally all SOAP calls are rewritten as RESTful calls**

This module was originally developed as core part of the SilverStripe CMS, but since April 2016 it has been maintained by http://github.com/xini

## Requirements

 * SilverStripe 3.1 or newer
 * "[restfulserver](https://github.com/silverstripe/silverstripe-restfulserver)" module

## Installation
Install the module using composer:
```
composer require innoweb/silverstripe-soapserver dev-master
```
or download or git clone the module into a ‘soapserver’ directory in your webroot.

Then run dev/build.

## License
BSD 3-Clause License, see [License](license.md)

## Documentation
See [Documentation index](docs/en/index.md)
