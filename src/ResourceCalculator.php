<?php

namespace ServerCalculator;

use ServerCalculator\ServerType;
use ServerCalculator\VirtualMachine;
use ServerCalculator\Exceptions\VirtualMachineExpected;
use ServerCalculator\Exceptions\NoneVirtualMachines;

final class ResourceCalculator
{
    
    public function calculate(ServerType $server, array $virtual_machines): int
    {
        if (empty($virtual_machines)) {
            throw new NoneVirtualMachines();
        }

        foreach ($virtual_machines as $virtual_machine) {
            if (!$virtual_machine instanceof VirtualMachine) {
                throw new VirtualMachineExpected();
            }

            if (!$server->isPossibleAllocate($virtual_machine)) {
                continue;
            }

            $server->allocate($virtual_machine);
        }

        return $server->getInstances();
    }
}