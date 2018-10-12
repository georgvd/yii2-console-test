# YII2-console-test

[![Build Status](https://travis-ci.com/georgvd/yii2-console-test.svg?branch=master)](https://travis-ci.com/georgvd/yii2-console-test)

This is just a test project!

## Requirements

You need PHP 7.1+ with SQLite3 support via PDO.

## Installation

1. Clone the project to the project home directory.
2. Run `$ composer install` (from project home directory).

## Console commands

### Add a text line output task to the queue

`$ yii queue/push <text>`, where *&lt;text&gt;* is your text to queue.

Examples:

`$ yii queue/push SomeText`

`$ yii queue/push "Мама мыла раму"`

### Queue management

`$ yii queue/service`

Continuously service tasks from the queue every 5 seconds.

## Testing

Only unit tests are implemented (using PHPUnit and Codeception).

To run tests locally:
1. Go to the project home directory
2. Run in terminal `"./vendor/bin/codecept" run`
