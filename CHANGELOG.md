# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

* Register the RouteVoter by default

### Removed

* Removed support for Symfony 2.3 components (which are unmaintained already), to get the RequestStack support.

### Deprecated

* Deprecated the "knp_menu.matcher.configure" callback in favor of extending the "knp_menu.matcher" service.

## [1.0.1] - 2017-08-22

### Fixed

* Fixed the registration of the builtin template path for Twig

## 1.0.0 - 2017-08-22

Initial release extracting the service provider from KnpMenu 2.2

[Unreleased]: https://github.com/KnpLabs/KnpMenuSilexProvider/compare/v1.0.1...HEAD
[1.0.1]: https://github.com/KnpLabs/KnpMenuSilexProvider/compare/v1.0.0...v1.0.1
