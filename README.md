goez/socket.io-php-emitter
=====================

A PHP implementation of node.js socket.io-emitter (0.1.2).

## Installation

```bash
composer require goez/socket.io-php-emitter
```

## Usage

### Emit payload message
```php
use Predis;
use Goez\SocketIO;
...

$client = new Predis\Client();

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
use Predis;
use Goez\SocketIO;
...

$client = new Predis\Client();

(new Emitter($client))
    ->broadcast->emit('broadcast-event', 'payload message');

(new Emitter($client))
    ->flag('broadcast')->emit('broadcast-event', 'payload message');
```

### Emit an object
```php
use Predis;
use Goez\SocketIO;
...

$client = new Predis\Client();

(new Emitter($client))
    ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2', ]);
```

### Emit an object in a rooms
```php
use Predis;
use Goez\SocketIO;
...

$client = new Predis\Client();

(new Emitter($client))
    ->in(['room1', 'room2'])
    ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2', ]);
```

## Credits

This library is forked from [shakahl/socket.io-emitter](https://github.com/shakahl/socket.io-emitter) created by Soma Szélpál. And [shakahl/socket.io-emitter](https://github.com/shakahl/socket.io-emitter) is forked from [exls/socket.io-emitter](https://github.com/exls/socket.io-emitter) created by Anton Pavlov.

