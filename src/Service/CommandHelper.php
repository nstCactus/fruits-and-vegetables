<?php

namespace App\Service;

use InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;

class CommandHelper
{
    /**
     * Get a string argument from InputInterface.
     * @throws InvalidArgumentException If the argument is not a string.
     */
    public function getStringArgument(InputInterface $input, string $name): string
    {
        $value = $input->getArgument($name);

        if (!is_string($value)) {
            throw new InvalidArgumentException(sprintf(
                'Expected argument "%s" to be a string, got "%s".',
                $name,
                gettype($value)
            ));
        }

        return $value;
    }
}
