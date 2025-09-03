<?php

namespace App\Imports;

use App\Models\GoodReceiving;
use App\Models\Item;
use App\Models\ShopStock;
use App\Models\WarehouseStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GoodReceivingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔹 First save into GoodReceiving (history table)
        $goodReceiving = new GoodReceiving([
            'item_name'      => $row['item_name'] ?? null,
            'category'       => $row['category'] ?? null,
            'receiving_date' => isset($row['receiving_date'])
                ? (is_numeric($row['receiving_date'])
                    ? Date::excelToDateTimeObject($row['receiving_date'])
                    : $row['receiving_date'])
                : null,
            'invoice_no'     => $row['invoice_no'] ?? null,
            'location_name'  => $row['location_name'] ?? null,
            'shelves_id'     => $row['shelves_id'] ?? null,
            'unit'           => $row['unit'] ?? null,
            'quantity'       => $row['quantity'] ?? 0,
            'product_code'   => $row['product_code'] ?? null,
            'part_number'    => $row['part_number'] ?? null,
            'item_code'      => $row['item_code'] ?? null,
            'bar_code'       => $row['bar_code'] ?? null,
            'brand'          => $row['brand'] ?? null,
            'cost_price'     => $row['cost_price'] ?? null,
            'selling_price1' => $row['selling_price1'] ?? null,
            'selling_price2' => $row['selling_price2'] ?? null,
            'image'          => $row['image'] ?? null,
            'image2'         => $row['image2'] ?? null,
            'status'         => $row['status'] ?? 'Active',
            'description'    => $row['description'] ?? null,
            'reorder'        => $row['reorder'] ?? null,
        ]);

        // 🔹 Also handle ShopStock update or insert
        $quantity = (int) ($row['quantity'] ?? 0);
        $location =$row['location_name'] ?? null;
         $item = Item::where('item_name', $row['item_name'] ?? null)
            ->where('product_code', $row['product_code'] ?? null)
            ->where('part_number', $row['part_number'] ?? null)
            ->where('bar_code', $row['bar_code'] ?? null)
            ->first();

             if ($item) {
            // Update: add quantities
            $item->update([
                'quantity' => (int) $item->quantity + $quantity,
            ]);
        }

if($location == "Store 1"){
 $stock = WarehouseStock::where('item_name', $row['item_name'] ?? null)
            ->where('product_code', $row['product_code'] ?? null)
            ->where('part_number', $row['part_number'] ?? null)
            ->where('bar_code', $row['bar_code'] ?? null)
            ->first();

        if ($stock) {
            // Update: add quantities
            $stock->update([
                'quantity' => (int) $stock->quantity + $quantity,
                'location_name' => $location ?? $stock->location_name,
            ]);
        } else {
            // Insert new shop stock
            WarehouseStock::create([
                'item_name'     => $row['item_name'] ?? null,
                'quantity'      => $quantity,
                'product_code'  => $row['product_code'] ?? null,
                'part_number'   => $row['part_number'] ?? null,
                'bar_code'      => $row['bar_code'] ?? null,
                'location_name' => $location ?? null,
            ]);
        }
}else{
 $stock = ShopStock::where('item_name', $row['item_name'] ?? null)
            ->where('product_code', $row['product_code'] ?? null)
            ->where('part_number', $row['part_number'] ?? null)
            ->where('bar_code', $row['bar_code'] ?? null)
            ->first();

        if ($stock) {
            // Update: add quantities
            $stock->update([
                'quantity' => (int) $stock->quantity + $quantity,
                'location_name' => $row['location_name'] ?? $stock->location_name,
            ]);
        } else {
            // Insert new shop stock
            ShopStock::create([
                'item_name'     => $row['item_name'] ?? null,
                'quantity'      => $quantity,
                'product_code'  => $row['product_code'] ?? null,
                'part_number'   => $row['part_number'] ?? null,
                'bar_code'      => $row['bar_code'] ?? null,
                'location_name' => $row['location_name'] ?? null,
            ]);
        }
}




        return $goodReceiving; // keep inserting into GoodReceiving
    }
}
