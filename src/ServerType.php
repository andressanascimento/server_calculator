<?php

namespace ServerCalculator;

interface ServerType 
{

    public function isPossibleAllocate(VirtualMachine $virtual_machine) : bool;

    public function allocate(VirtualMachine $virtual_machine);

    public function getInstances();
}