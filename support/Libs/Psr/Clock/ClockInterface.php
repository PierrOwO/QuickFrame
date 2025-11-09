<?php
namespace Psr\Clock;

/**
 * PSR-20 Clock Interface
 */
interface ClockInterface
{
    /**
     * Returns the current time as a DateTimeImmutable object.
     */
    public function now(): \DateTimeImmutable;
}