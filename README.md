# Server Calculator

It calculates the number of servers (which have the same configuration) needed to host a specified
amount of virtual machines. 
All servers have the same type. This type defines the hardware resources each server provides: CPU, RAM, HDD.
Each virtual machine is defined by the virtual hardware resources it needs (on a server): CPU, RAM, HDD.

The algorithm for the virtual machine distribution implement a 'first fit' strategy. 
This means there is no resource optimization or 'look back'.
Virtual machines are always allocated on the current or the next server (in case of limited resources).

If a virtual machine is too 'big' for a server, it' skipped.
If the collection of virtual machines is empty, an exception is thrown.

## Installation

Use the composer (https://getcomposer.org/) to install voucher_pool.

```bash
composer install
```

### How to use
When a offer is created this route also generate the vouchers to all recipients.

```php

use ServerCalculator\Server;
use ServerCalculator\VirtualMachine;
use ServerCalculator\ResourceCalculator;

$server = new Server();
$server->setCpu(2);
$server->setHdd(32);
$server->setRam(100);

$virtual_machine = new VirtualMachine();
$virtual_machine->setCpu(1);
$virtual_machine->setHdd(32);
$virtual_machine->setRam(100);

$calculator = new ResourceCalculator();
$num_servers = $calculator->calculate($server, [$virtual_machine]);

```
