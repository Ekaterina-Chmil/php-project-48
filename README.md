### Hexlet tests and linter status:
[![Actions Status](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Ekaterina-Chmil/php-project-48/actions)

### Пример работы пакета с JSON
[![asciicast](https://asciinema.org/a/AfwJIUHZqfiKabkb0pQ8BZHTg.svg)](https://asciinema.org/a/AfwJIUHZqfiKabkb0pQ8BZHTg)

Команда:

```bash
php bin/gendiff tests/fixtures/file1.json tests/fixtures/file2.json
```
Вывод:

```text
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
```
### Пример работы пакета с YAML
[![asciicast](https://asciinema.org/a/OU2ASVN2hxvhfWI0QP5i10x4O.svg)](https://asciinema.org/a/OU2ASVN2hxvhfWI0QP5i10x4O)

Команда:

```bash
php bin/gendiff tests/fixtures/file1.yml tests/fixtures/file2.yml
```
Вывод:

```text
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
```
### Пример рекурсивного сравнения
[![asciicast](https://asciinema.org/a/XGTOerq0yqmzHYzI5698WrtnH.svg)](https://asciinema.org/a/XGTOerq0yqmzHYzI5698WrtnH)

Команда:

```bash
php bin/gendiff tests/fixtures/file1.json tests/fixtures/file2.json
```

Сокращённый вывод:

```text
{
  common: {
    + follow: false
      setting1: Value 1
    - setting2: 200
    - setting3: true
    + setting3: null
  }
  group1: {
    - baz: bas
    + baz: bars
      foo: bar
  }
  - group2: {...}
  + group3: {...}
}
```

### CI / Coverage
[![PHP CI](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/main.yml/badge.svg)](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/main.yml)

[![SonarCloud Status](https://sonarcloud.io/api/project_badges/measure?project=Ekaterina-Chmil_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Ekaterina-Chmil_php-project-48)
