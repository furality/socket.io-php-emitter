# Furality/socket.io-php-emitter [![Build Status](https://github.com/furality/socket.io-php-emitter/actions/workflows/test.yml/badge.svg)](https://github.com/furality/socket.io-php-emitter/actions/workflows/test.yml)
A PHP implementation of node.js socket.io-emitter.

## Installation

```bash
composer require Furality/socket.io-php-emitter
```

## Usage

### Emit payload message
```php
use Predis\Client;
use Furality\SocketIO\Emitter;
...

$client = new Client();

(new Emitter($client))
    ->of('namespace')->emit('event', 'payload message');
```

### Flags
Possible flags
* json
* volatile
* broadcast

#### To use flags, just call it like in examples bellow
```php
use Predis\Client;
use Furality\SocketIO\Emitter;
...

$client = new Client();

(new Emitter($client))
    ->broadcast->emit('broadcast-event', 'payload message');

(new Emitter($client))
    ->flag('broadcast')->emit('broadcast-event', 'payload message');
```

### Emit an object
```php
use Predis\Client;
use Furality\SocketIO\Emitter;
...

$client = new Client();

(new Emitter($client))
    ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2', ]);
```

### Emit an object in multiple rooms
```php
use Predis\Client;
use Furality\SocketIO\Emitter;
...

$client = new Client();

(new Emitter($client))
    ->in(['room1', 'room2'])
    ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2', ]);
```

## Credits

This library is forked from [shakahl/socket.io-emitter](https://github.com/shakahl/socket.io-emitter) created by Soma Szélpál.

The [shakahl/socket.io-emitter](https://github.com/shakahl/socket.io-emitter) is forked from [exls/socket.io-emitter](https://github.com/exls/socket.io-emitter) created by Anton Pavlov.

