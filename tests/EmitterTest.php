<?php

namespace Tests;

use Furality\SocketIO\Emitter;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class EmitterTest extends TestCase
{
    /**
     * @var MockInterface|Client
     */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = Mockery::spy(Client::class);
    }

    protected function tearDown(): void
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
        
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_should_use_flag()
    {
        (new Emitter($this->mockClient))
            ->flag(Emitter::FLAG_BROADCAST)->emit('broadcast-event', 'payload message');
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
            $this->assertTrue(true);
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
            $this->assertTrue(true);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_should_throw_exception_with_invalid_flag()
    {
        $this->expectException(\InvalidArgumentException::class);
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
        $this->assertTrue(true);
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
        $this->assertTrue(true);
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
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_should_emit_an_object_in_binary_type()
    {
        (new Emitter($this->mockClient))
            ->type(Emitter::EVENT_TYPE_BINARY)
            ->emit('broadcast-event', ['param1' => 'value1', 'param2' => 'value2',]);
        $this->mockClient->shouldHaveReceived('publish')
            ->once();
        $this->assertTrue(true);
    }
}
