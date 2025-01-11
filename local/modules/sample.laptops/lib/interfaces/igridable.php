<?php

namespace Sample\Laptops\Interfaces;

interface IGridable
{
    public function getGridHeaders(): array;

    public function getGridRows(int $limit, int $offset): array;

    public function getRecordsCount(): int;
}
