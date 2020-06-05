<?php

namespace Task1\Model;

interface LoginModelInterface
{
    public function isLoggined(?string $session): bool;

    public function login(array $parameters): array;

    public function countAttempts(array $parameters);

    public function clearAttempts(array $parameters);

    public function checkBanTime(array $parameters): bool;
}