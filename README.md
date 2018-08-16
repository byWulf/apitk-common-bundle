# apitk-common-bundle

Contains classes, interfaces and traits that are shared between
apitk-* bundles, mainly:

## Components

#### Annotation/ParamConverter

Useful traits for your ParamConverter Annotation:

* __EntityAwareAnnotationTrait__   
  Adds `entity`, `entityManager` and `methodName` options
  
* __RequestParamAwareAnnotationTrait__  
  Adds `requestParam` option


#### Describer/AbstractDescriber

Common logic for changing Swagger/OpenAPI annotations via PHP.

#### ParamConverter

Useful traits for your ParamConverter logic:

ContextAwareParamConverterTrait.php
EntityAwareParamConverterTrait.php

* __ContextAwareParamConverterTrait__   
  Provides `$this->getOption('name', 'default')` convenience methods
  to access annotation options easily.
  
* __EntityAwareParamConverterTrait__  
  Adds `getEntity()`, `getEntityManager()` and `callRepositoryMethod()`
  convenience to access an entity, its appropriate entity manager and
  repository for the given Annotation options.
  
* __RequestParamAwareParamConverterTrait__  
  Adds `getRequestParam()` and `getRequestParamValue()` methods to access
  a request param given by Annotation options easily. It's also possible to
  define defaults here.
  
  

