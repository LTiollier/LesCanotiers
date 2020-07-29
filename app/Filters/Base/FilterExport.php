<?php

namespace App\Filters\Base;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilterExport implements FromCollection, WithHeadings
{
    /** @var LengthAwarePaginator<mixed>|Collection<mixed> */
    protected $collection;

    /** @var array<string> */
    protected $headers;

    /**
     * @param LengthAwarePaginator<mixed>|Collection<mixed> $collection
     * @param array<string> $headers
     */
    public function __construct($collection, array $headers)
    {
        $this->collection = $collection;
        $this->headers = $headers;
    }

    /**
     * @return LengthAwarePaginator<mixed>|Collection<mixed>
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @return array<string>
     */
    public function headings(): array
    {
        return $this->headers;
    }
}
