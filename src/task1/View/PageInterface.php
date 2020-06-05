<?php

namespace Task1\View;

interface PageInterface
{
    public static function view(array $data): string;
}