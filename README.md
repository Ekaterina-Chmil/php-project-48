### Hexlet tests and linter status:
[![Actions Status](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Ekaterina-Chmil/php-project-48/actions)

## Описание проекта

**Gendiff** — это консольная PHP-утилита для сравнения двух конфигурационных файлов.  
Поддерживает форматы **JSON** и **YAML**, а также несколько видов вывода:  
`stylish`, `plain` и `json`.

## Установка

```bash
git clone https://github.com/Ekaterina-Chmil/php-project-48.git
cd php-project-48
make install
```

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
### Пример работы пакета — Плоский формат (Plain)
[![asciicast](https://asciinema.org/a/zygeE4MfPfQanFMHQLd4dKZ2z.svg)](https://asciinema.org/a/zygeE4MfPfQanFMHQLd4dKZ2z)

Команда:

```bash
php bin/gendiff --format plain tests/fixtures/file1.json tests/fixtures/file2.json
```

Вывод:

```text
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
```
### Пример работы пакета — JSON формат
[![asciicast](https://asciinema.org/a/BPNATROcOrMqhXwgu8y621ltK.svg)](https://asciinema.org/a/BPNATROcOrMqhXwgu8y621ltK)

Команда:

```bash
php bin/gendiff --format json tests/fixtures/file1.json tests/fixtures/file2.json
```

Вывод:

```text
[
  {
    "key": "common",
    "status": "nested",
    "children": [
      {
        "key": "follow",
        "status": "added",
        "value": false
      },
      ...
    ]
  }
]
```

### CI / Coverage
[![PHP CI](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/main.yml/badge.svg)](https://github.com/Ekaterina-Chmil/php-project-48/actions/workflows/main.yml)

[![SonarCloud Status](https://sonarcloud.io/api/project_badges/measure?project=Ekaterina-Chmil_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Ekaterina-Chmil_php-project-48)
