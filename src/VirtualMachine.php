<?php

namespace ServerCalculator;

final class VirtualMachine
{
    private $_cpu;

    private $_ram;

    private $_hdd;

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
}