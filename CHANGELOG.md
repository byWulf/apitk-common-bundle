# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.3.0] - 2021-08-30

### Added

- Support for sensio/framework-extra-bundle 6.x

## [2.2.0] - 2021-06-28

### Added

- PHP 8.0 support

## [2.0.2] - 2020-11-19

### Added

- Added myclabs/enum support

## [2.0.1] - 2020-07-27

### Changed

- Bump symfony/http-foundation from 5.0.5 to 5.0.7

### Fixed

- Deprecation introduced with Symfony 5.1: Autowiring ContainerInterface will be dropped in 6.x

## [2.0.0] - 2020-03-20

### Added

- Support for Symfony 5.0
- PHP quality checker to this project

### Changed

- Doctrine ORM to be an optional dependency
- `$registry` in `EntityAwareParamConverterTrait` is now nullable
- `EntityAwareParamConverterTrait::callRepositoryMethod` may throw an exception when the implementing
  application didn't install `doctrine/orm` or `doctrine/doctrine-bundle`

### Removed

- support for symfony < 4.3

### Fixed

## [1.0.3] - 2019-02-17

Last release without a changelog ;-)

[unreleased]: https://github.com/byWulf/apitk-common-bundle/compare/2.0.2...HEAD
[2.0.2]: https://github.com/byWulf/apitk-common-bundle/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/byWulf/apitk-common-bundle/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/byWulf/apitk-common-bundle/compare/1.0.3...2.0.0
[1.0.5]: https://github.com/byWulf/apitk-common-bundle/compare/1.0.2...1.0.3
