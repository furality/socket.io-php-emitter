<?php

namespace Tests;

use Goez\SocketIO\Constants\Emitter\Flag;
use Goez\SocketIO\Constants\Emitter\Type;
use Goez\SocketIO\Emitter;
use Mockery;
use Mockery\MockInterface;
use Predis\Client;

class EmitterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface|Client
     */
    private $mockClient;

    protected function setUp()
    {
        $this->mockClient = Mockery::spy(Client::class);
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function it_should_emit_payload_message()
    {
        (new Emitter($this->mockClient))
            ->of('namespace')->emit('event', 'payload message');
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }

    /**
     * @test
     */
    public function it_should_use_flag()
    {
        (new Emitter($this->mockClient))
            ->flag(Flag::BROADCAST)->emit('broadcast-event', 'payload message');
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }

    /**
     * @test
     */
    public function it_should_use_flag_by_magic_getter()
    {
        (new Emitter($this->mockClient))
            ->broadcast->emit('broadcast-event', 'payload message');
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_should_throw_exception_with_invalid_flag()
    {
        (new Emitter($this->mockClient))
            ->flag('wtf')->emit('broadcast-event', 'payload message');
    }

    /**
     * @test
     */
    public function it_should_emit_an_object()
    {
        (new Emitter($this->mockClient))
            ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2',]);
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }

    /**
     * @test
     */
    public function it_should_emit_an_object_to_a_room()
    {
        (new Emitter($this->mockClient))
            ->to('room1')
            ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2',]);
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }

    /**
     * @test
     */
    public function it_should_emit_an_object_in_rooms()
    {
        (new Emitter($this->mockClient))
            ->in(['room1', 'room2'])
            ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2',]);
        $this->mockClient->shouldHaveReceived('publish')
            ->twice();
    }

    /**
     * @test
     */
    public function it_should_emit_an_object_in_binary_type()
    {
        (new Emitter($this->mockClient))
            ->type(Type::BINARY_EVENT)
            ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2',]);
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
    }
}
