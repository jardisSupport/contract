# Jardis Contract

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.md)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.2-777BB4.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-brightgreen.svg)](phpstan.neon)
[![PSR-12](https://img.shields.io/badge/Code%20Style-PSR--12-blue.svg)](phpcs.xml)

> Part of **[Jardis](https://jardis.io)** — the Domain-Driven Design platform for PHP. You model your domain; Jardis generates the production-ready hexagonal code (DTOs, Command/Query handlers, repositories, persistence). This package is part of the open-source foundation that generated code runs on.

Consolidated ports and adapters contracts for all Jardis packages — the interface layer that keeps hexagonal architecture honest across the entire ecosystem.

---

## Overview

This package provides all interface contracts for the Jardis ecosystem in a single location. It replaces the previously separate `jardisport/*` packages.

| Namespace | Contracts | Purpose |
|-----------|-----------|---------|
| `Kernel` | 7 | DomainKernel, BoundedContext (deprecated), ContextResponse, DomainResponse, EventScope, ResponseStatus, GeneratedContextInterface (marker) |
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
| `Workflow` | 6 | Workflow engine + orchestration (Workflow, Builder, NodeBuilder, Config, Context, Result) — 7 named transitions: `onSuccess`, `onFail`, `onTimeout`, `onSkip`, `onCancel`, `onEvent`, `onExit` |

**70 contracts** across 15 domains.

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

## Kernel — v2 additions (Kernel-Entkopplung)

Three additions to `Kernel\` that let a generated domain drop its compile-time
dependency on `jardiscore/kernel`'s base classes while keeping the same
runtime vocabulary.

### `ResponseStatus` enum

`JardisSupport\Contract\Kernel\ResponseStatus` — an `int`-backed enum of
domain-neutral response status codes (`Success = 200`, `Created = 201`,
`NoContent = 204`, `ValidationError = 400`, `Unauthorized = 401`,
`Forbidden = 403`, `NotFound = 404`, `Conflict = 409`, `RuleViolation = 422`,
`InternalError = 500`), ported 1:1 from `jardiscore/kernel`'s
`JardisCore\Kernel\Response\ResponseStatus`. Generated domains import it from
here instead of from `jardiscore/kernel`.

### `DomainKernelInterface::eventListenerRegistry()`

The Kernel interface (the "Koffer") gained an 11th accessor:
`eventListenerRegistry(): ?EventListenerRegistryInterface`. It is paired with
`eventDispatcher()` — both are typically backed by the same underlying
provider instance, one side for dispatching (PSR-14), one side for
registering listeners. Generated `{Agg}EventRouter` scaffolds use this
accessor to self-register on the domain facade's constructor. Nullable like
every other service on the interface: without a registry, event routing
simply stays inactive.

### `GeneratedContextInterface` marker

`JardisSupport\Contract\Kernel\GeneratedContextInterface` is an empty marker
interface. Every generated `{Domain}Context` implements it, so the resolve
path recognizes generated context classes via
`is_subclass_of($resolved, GeneratedContextInterface::class)` — independent
of domain boundaries (cross-domain services included) and without requiring
a shared package base class to extend. It replaces the detection role
formerly played by `BoundedContextInterface`, which is now `@deprecated` (not
removed — kept for code still written against the old `jardiscore/kernel`
`BoundedContext` base class).

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

## Documentation

Full documentation, guides, and API reference:

**[docs.jardis.io/en/support/contract](https://docs.jardis.io/en/support/contract)**

---

## License

Jardis is open source under the [MIT License](LICENSE.md).
Free for any purpose — commercial or non-commercial.

---

*Jardis – Development with Passion*
*Built by [Headgent Development](https://headgent.com)*
