<?php

namespace ServerCalculator;
use ServerCalculator\ServerType;

final class Server implements ServerType
{
    private $_cpu;

    private $_ram;

    private $_hdd;

    private $_instances;

    private $_virtual_machines;

    private $_current;

    public function __construct()
    {
        $this->_instances = 1;
        $this->_virtual_machines = [];
        $this->_current = 1;
    }

    public function getCpu() : int
    {
        return $this->_cpu;
    }

    public function getRam() : int
    {
        return $this->_ram;
    }
    public function getHdd() : int
    {
        return $this->_hdd;
    }

    public function getInstances() : int
    {
        return $this->_instances;
    }

    public function setCpu(int $cpu)
    {
        $this->_cpu = $cpu;
    }

    public function setRam(int $ram)
    {
        $this->_ram = $ram;
    }

    public function setHdd(int $hdd)
    {
        $this->_hdd = $hdd;
    }

    public function nextInstance()
    {
        $this->_instances += 1;
        $this->_current += 1;
    }

    public function isPossibleAllocate(VirtualMachine $virtual_machine) : bool
    {
        if ($virtual_machine->getRam() >  $this->_ram) {
            return false;
        }

        if ($virtual_machine->getHdd() >  $this->_hdd) {
            return false;
        }

        if ($virtual_machine->getCpu() >  $this->_cpu) {
            return false;
        }
        return true;
    }

    public function allocate(VirtualMachine $virtual_machine)
    {
        
        if (!$this->canAllocateCurrentServer($virtual_machine)) {
            $this->nextInstance();
        }

        $this->_virtual_machines[$this->_current][] = $virtual_machine;    
    }

    private function totalAllocateResource(string $resource) : int
    {
        $sum = 0;
        if (!empty($this->_virtual_machines)) {
            $machines = $this->_virtual_machines[$this->_current];
            foreach($machines as $virtual_machine) {
                $method_name = 'get'.ucfirst($resource);
                $sum += $virtual_machine->$method_name();
            }

        }
        return $sum;
    }

    private function canAllocateCurrentServer(VirtualMachine $virtual_machine) : bool
    {
        if (!$this->canAllocateResource('ram', $virtual_machine->getRam())) {
            return false;
        }
        
        if (!$this->canAllocateResource('hdd', $virtual_machine->getHdd())) {
            return false;
        }
        
        if (!$this->canAllocateResource('cpu', $virtual_machine->getCpu())) {
            return false;
        }
        return true;
    }

    private function canAllocateResource(string $resource, int $new_resource_value) : bool
    {
        $total_allocate = $this->totalAllocateResource($resource);
        $method_name = 'get'.ucfirst($resource);
        $server_resource = $this->$method_name();
        return ($total_allocate + $new_resource_value) <= $server_resource;
    }
}