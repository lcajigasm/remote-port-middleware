# Changelog

All notable changes to this project will be documented in this file.

## [2.0.0] - 2025-08-10
### Added
- PSR-15 `process()` implementation (Slim 4+, generic PSR-15 frameworks).
- Backwards compatibility layer via legacy `__invoke()` for Slim 3.
- Support for `psr/http-message` ^2.0 while keeping ^1.0.
- Added `psr/http-server-middleware` and `psr/http-server-handler` dependencies.
- Expanded README with English documentation, usage examples for Slim 4 & Slim 3, edge cases, contributing section.
- Added `suggest` entry for `slim/slim` in `composer.json`.

### Changed
- Minimum supported PHP version is now `>=8.0` (previously unbounded, effectively allowing older PHP versions). This is a breaking change for consumers on PHP < 8.0.
- Composer autoload path normalized (`src/`).
- Class now explicitly implements `MiddlewareInterface`.

### Deprecated
- None.

### Removed
- Implicit support for PHP < 8.0 (breaking change).

### Security
- No security related changes.

## [1.0.1] - 2019-??-??
### Fixed
- Minor improvements (historical tag; original changelog not recorded).

## [1.0.0] - 2019-??-??
- Initial release.

[2.0.0]: https://github.com/luisinder/remote-port-middleware/releases/tag/2.0.0
