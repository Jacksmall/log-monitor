<?php

namespace Jack\LogMonitor\Services;

interface LogInterface
{
    public function log($level, $message, array $context = []);
}
