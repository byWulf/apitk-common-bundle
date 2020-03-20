# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2020-03-20
### Added
* Support for Symfony 5.0
* PHP quality checker to this project

### Changed
* Doctrine ORM to be an optional dependency
* `$registry` in `EntityAwareParamConverterTrait` is now nullable
* `EntityAwareParamConverterTrait::callRepositoryMethod` may throw an exception when the implementing
  application didn't install `doctrine/orm` or `doctrine/doctrine-bundle` 

### Removed
* __support for symfony < 4.3__

### Fixed


## [1.0.3] - 2019-02-17
Last release without a changelog ;-) 
 
