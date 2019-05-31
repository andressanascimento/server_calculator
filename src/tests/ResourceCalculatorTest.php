<?php

use ServerCalculator\Server;
use ServerCalculator\VirtualMachine;
use ServerCalculator\ResourceCalculator;
use ServerCalculator\Exceptions\VirtualMachineExpected;
use ServerCalculator\Exceptions\NoneVirtualMachines;

class ResourceCalculatorTest extends \PHPUnit_Framework_TestCase
{

    private $_server;

    protected function setUp()
    {
        $server = new Server();
        $server->setCpu(2);
        $server->setHdd(32);
        $server->setRam(100);
        $this->_server = $server;
    }

    public function testEmptyVirtualMachine()
    {
        $calculator = new ResourceCalculator();

        $this->expectException(NoneVirtualMachines::class);
        $calculator->calculate($this->_server, []);
    }

    public function testArrayWithNotVirtualMachine()
    {
        $calculator = new ResourceCalculator();

        $this->expectException(VirtualMachineExpected::class);
        
        $calculator->calculate($this->_server, [["CPU"=> 1, "RAM"=> 16, "HDD"=> 10]]);
    }

    public function testAllocateOneServer()
    {
        $calculator = new ResourceCalculator();

        $virtual_machine = new VirtualMachine();
        $virtual_machine->setCpu(1);
        $virtual_machine->setHdd(32);
        $virtual_machine->setRam(100);

        $num_servers = $calculator->calculate($this->_server, [$virtual_machine]);
        $this->assertSame($num_servers, 1);
    }

    public function testAllocateNextServer()
    {
        $calculator = new ResourceCalculator();

        $virtual_machine = new VirtualMachine();
        $virtual_machine->setCpu(1);
        $virtual_machine->setHdd(32);
        $virtual_machine->setRam(100);

        $virtual_machine2 = new VirtualMachine();
        $virtual_machine2->setCpu(2);
        $virtual_machine2->setHdd(32);
        $virtual_machine2->setRam(100);

        $num_servers = $calculator->calculate($this->_server, [$virtual_machine, $virtual_machine2]);
        $this->assertSame($num_servers, 2);
    }

    public function testAllocateShareServer()
    {
        $calculator = new ResourceCalculator();

        $virtual_machine = new VirtualMachine();
        $virtual_machine->setCpu(1);
        $virtual_machine->setHdd(8);
        $virtual_machine->setRam(25);

        $virtual_machine1 = new VirtualMachine();
        $virtual_machine1->setCpu(1);
        $virtual_machine1->setHdd(8);
        $virtual_machine1->setRam(25);

        $virtual_machine2 = new VirtualMachine();
        $virtual_machine2->setCpu(2);
        $virtual_machine2->setHdd(32);
        $virtual_machine2->setRam(100);

        $num_servers = $calculator->calculate($this->_server, [$virtual_machine, $virtual_machine1, $virtual_machine2]);
        $this->assertSame($num_servers, 2);
    }

    public function testSkipVirtualMachine()
    {
        $calculator = new ResourceCalculator();

        $virtual_machine = new VirtualMachine();
        $virtual_machine->setCpu(1);
        $virtual_machine->setHdd(32);
        $virtual_machine->setRam(100);

        $virtual_machine2 = new VirtualMachine();
        $virtual_machine2->setCpu(7);
        $virtual_machine2->setHdd(32);
        $virtual_machine2->setRam(100);

        $num_servers = $calculator->calculate($this->_server, [$virtual_machine, $virtual_machine2]);
        $this->assertSame($num_servers, 1);
    }
}