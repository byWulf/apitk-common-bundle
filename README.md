# apitk-common-bundle

Contains classes, interfaces and traits that are shared between
apitk-\* bundles, mainly:

## Installation

Install the package via composer:

```
composer require check24/apitk-common-bundle
```

You usually don't have to install it by yourself, because it is only for other apitk-bundles.

## Components

#### Annotation/ParamConverter

Useful traits for your ParamConverter Annotation:

- **EntityAwareAnnotationTrait**  
  Adds `entity`, `entityManager` and `methodName` options
- **RequestParamAwareAnnotationTrait**  
  Adds `requestParam` option

#### Describer/AbstractDescriber

Common logic for changing Swagger/OpenAPI annotations via PHP.

#### ParamConverter

Useful traits for your ParamConverter logic:

ContextAwareParamConverterTrait.php
EntityAwareParamConverterTrait.php

- **ContextAwareParamConverterTrait**  
  Provides `$this->getOption('name', 'default')` convenience methods
  to access annotation options easily.
- **EntityAwareParamConverterTrait**  
  Adds `getEntity()`, `getEntityManager()` and `callRepositoryMethod()`
  convenience to access an entity, its appropriate entity manager and
  repository for the given Annotation options.
- **RequestParamAwareParamConverterTrait**  
  Adds `getRequestParam()` and `getRequestParamValue()` methods to access
  a request param given by Annotation options easily. It's also possible to
  define defaults here.
