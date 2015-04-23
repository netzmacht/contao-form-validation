Contao form validation extension
================================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-form-validation/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-form-validation)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-form-validation.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-validation)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-form-validation.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-validation)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-form-validation.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-form-validation)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)


This extension provides extended form validations like client side form validation for the Contao forms.

Features
--------

 * Client side form validation using [http://formvalidation.io/](http://formvalidation.io/). This is an commercial
   library supporting well known frameworks like Bootstrap, foundation. It is **NOT** included in this extension and has
   to be purchased and installed by its own.

Following features are planned:
 * Support default Contao 3.4 form syntax
 * Provide extended [validators](http://formvalidation.io/validators/) for client and server side.
 

Install
-------

You can install this extension using composer:

```
$ php composer.phar require netzmacht/contao-form-validation:~1.0
```

After installing, do following steps:
 1. Set the assets path to the [http://formvalidation.io/](http://formvalidation.io/) library in 
    *System settings -> form validation*
 2. Create a form validation config in the form generator.
 3. Edit the form setting and activate client side validation. Select the configuration here.
 4. Edit the form fields and customize the client side validation config.
 