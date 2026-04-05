# Jardis Contract

[![License: PolyForm Shield](https://img.shields.io/badge/License-PolyForm%20Shield-blue.svg)](LICENSE.md)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.2-777BB4.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-brightgreen.svg)](phpstan.neon)
[![PSR-12](https://img.shields.io/badge/Code%20Style-PSR--12-blue.svg)](phpcs.xml)

> Part of the **[Jardis Business Platform](https://jardis.io)** — Enterprise-grade PHP components for Domain-Driven Design

Consolidated contract interfaces for all Jardis packages.

---

## Overview

This package provides all interface contracts for the Jardis ecosystem in a single location. It replaces the previously separate `jardisport/*` packages.

| Namespace | Contracts | Purpose |
|-----------|-----------|---------|
| `Kernel` | 4 | DomainKernel, BoundedContext, ContextResponse, DomainResponse |
| `ClassVersion` | 2 | Versioned class resolution |
| `Connection` | 1 | Generic connection abstraction |
| `Data` | 3 | Hydration, Identity, FieldMapper |
| `DbConnection` | 3 | ConnectionPool, DbConnection, DatabaseConfig |
| `DbQuery` | 17 | Query Builder, Conditions, Joins, Expressions, Results |
| `DbSchema` | 2 | Schema Reader, Schema Exporter |
| `DotEnv` | 1 | Environment variable loading |
| `Messaging` | 10 | Publisher, Consumer, MessageHandler + Exceptions |
| `Repository` | 4 | Generic CRUD, PkStrategy, Exceptions |
| `Secret` | 2 | Secret resolution + Exception |
| `Validation` | 3 | Validator, ValueValidator, ValidationResult |
| `Mailer` | 4 | Mailer, MailMessage, MailTransport + Exception |
| `Filesystem` | 5 | Filesystem (Reader/Writer), FileInfo + Exception |
| `Workflow` | 5 | Workflow orchestration (Builder, Config, Node, Result) |

**66 contracts** across 15 domains.

---

## Installation

```bash
composer require jardissupport/contract
```

---

## Namespace

```
JardisSupport\Contract\
├── Kernel\
├── ClassVersion\
├── Connection\
├── Data\
├── DbConnection\
├── DbQuery\
├── DbSchema\
├── DotEnv\
├── Mailer\
├── Filesystem\
├── Messaging\
│   └── Exception\
├── Repository\
│   ├── Exception\
│   └── PrimaryKey\
├── Secret\
├── Validation\
└── Workflow\
```

---

## Design Principles

- **One package, all contracts** — single dependency for the entire Jardis ecosystem
- **Only PSR standards at the Kernel level** — PSR-3, PSR-11, PSR-14, PSR-16, PSR-18 + PDO
- **No implementation code** — interfaces, enums, value objects and exception classes only
- **Hexagonal Architecture** — contracts define ports, implementations live in adapter/support packages

---

## Migration from jardisport/*

Replace namespace imports:

```php
// Before
use JardisPort\Kernel\DomainKernelInterface;
use JardisPort\DbQuery\DbQueryBuilderInterface;

// After
use JardisSupport\Contract\Kernel\DomainKernelInterface;
use JardisSupport\Contract\DbQuery\DbQueryBuilderInterface;
```

Replace composer dependency:

```json
// Before
"require": {
    "jardisport/kernel": "^1.0",
    "jardisport/dbquery": "^1.0"
}

// After
"require": {
    "jardissupport/contract": "^1.0"
}
```

---

## Related Packages

| Package | Role |
|---------|------|
| `jardiscore/kernel` | Kernel contract implementation |
| `jardiscore/foundation` | Full DDD platform on top of Kernel |
| `jardissupport/*` | Support package implementations |
| `jardisadapter/*` | Adapter implementations for external systems |

---

## License

Jardis is source-available under the [PolyForm Shield License 1.0.0](LICENSE.md).
Free for virtually every purpose — including commercial use.

---

*Jardis – Development with Passion*
*Built by [Headgent Development](https://headgent.com)*
