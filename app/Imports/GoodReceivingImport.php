<?php

namespace App\Imports;

use App\Models\GoodReceiving;
use App\Models\Item;
use App\Models\ShopStock;
use App\Models\WarehouseStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;

class GoodReceivingImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        if (empty($row['itemname'])) {
            return null; // skip empty rows
        }

        $duplicate = Item::where('item_code', $row['itemcode'] ?? null)
            ->orWhere('product_code', $row['partnumber1'] ?? null)
            ->orWhere('part_number', $row['partnumber2'] ?? null)
            ->first();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'item_code' => "Duplicate entry found: Item Code {$row['itemcode']} or Part Number1 {$row['partnumber1']} Part Number2 {$row['partnumber2']} already exists.",
            ]);
        }
        return Item::create([
            'item_name'      => $row['itemname'] ?? null,
            'category'       => $row['category'] ?? null,
            'shelf'          => $row['shelf'] ?? null,
            'unit'           => $row['unit'] ?? null,
            'product_code'   => $row['partnumber1'] ?? null,
            'part_number'    => $row['partnumber2'] ?? null,
            'item_code'      => $row['itemcode'] ?? null,
            'bar_code'       => $row['batchno'] ?? null,
            'brand'          => $row['brand'] ?? null,
            'selling_price1' => $row['price1'] ?? 0,
            'selling_price2' => $row['price2'] ?? 0,
            'reorder'        => $row['reorder'] ?? 0,
        ]);
    }
}
