<?php

namespace App\Imports;

use App\Jobs\ImportProductRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;


class ProductsImport implements OnEachRow, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    use Importable;
    use RegistersEventListeners;

    /**
     * @param array $row
     *
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function onRow(Row $row)
    {
        try {
            $rowArray = $row->toArray();
            ImportProductRow::dispatch($rowArray);
        } catch (\Exception $e) {
            Log::error('Queueing product import error: ' . $e->getMessage());
        }
    }


    public function batchSize(): int
    {
        return 500; // số lượng bản ghi trong mỗi lần nhập liệu (batch)
    }

    public function chunkSize(): int
    {
        return 500; // số lượng bản ghi trong mỗi đoạn (chunk)
    }

}


