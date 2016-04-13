# SilverStripe RestfulServer Module

## Overview

SOAP server class which auto-generates a WSDL file to initialize PHPs integrated `SoapServer` functionality.
Extended by `SOAPModelAccess` to scaffold WSDL for a specific class.

**This module is just a wrapper for the "[restfulserver](https://github.com/silverstripe/silverstripe-restfulserver)" module,
internally all SOAP calls are rewritten as RESTful calls**

This module was originally developed as core part of the SilverStripe CMS, but since April 2106 is has been maintained by http://github.com/xini

## Requirements

 * SilverStripe 3.0 or newer
 * "[restfulserver](https://github.com/silverstripe/silverstripe-restfulserver)" module

## Configuration

Example DataObject with simple api access, giving full access to all object properties and relations,
unless explicitly controlled through model permissions.

	class Article extends DataObject {
		static $db = array('Title'=>'Text','Published'=>'Boolean');
		static $api_access = true;
	}

## Usage

Getting a record:

	$c = new SoapClient('http://mysite.com/soap/v1/wsdl');
	echo $c->getXML("MyClassName", 99); // gets record #99 as xml

Updating a record:

	$c = new SoapClient('http://mysite.com/soap/v1/wsdl');
	$data = array('MyProperty' => 'MyUpdatedValue');
	echo $c->putXML("MyClassName", 99, null, $data);

Creating a record:

	$c = new SoapClient('http://mysite.com/soap/v1/wsdl');
	$data = array('MyProperty' => 'MyValue');
	echo $c->putXML("MyClassName", null, null, $data);

Creating a record:

	$c = new SoapClient('http://mysite.com/soap/v1/wsdl');
	echo $c->deleteXML("MyClassName");
