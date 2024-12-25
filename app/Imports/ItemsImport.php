<?php

namespace App\Imports;

use App\Item;
use App\ItemType;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {

            if (\Auth::user()->category->id == 1)
                $usr = \Auth::user()->id;
            elseif (\Auth::user()->category->id == 6)
                $usr = User::where(['f_name' => $row[22], 'user_category_id' => 1])->first()->id;

            if ($row[9] == null)
                $type = null;
            else {
                $typeStr = preg_replace('/[أ,إ,آ]/ui', 'ا', $row[9]);
                $typeObj = ItemType::where('ar_name', $typeStr)->first();
                if ($typeObj != null)
                    $type = $typeObj->id;
                else {
                    $typeObj = new ItemType();
                    $typeObj->ar_name = $typeStr;
                    $typeObj->save();
                    $type = $typeObj->id;
                }
            }
            $importedItem = new Item([
                'name' => $row[0],
                'barcode' => $row[1],
                'user_id' => $usr,
                'composition' => $row[2],
                'dosage' => $row[3],
                'descr1' => $row[4],
                'descr2' => $row[5],
                'price' => $row[6],
                'customer_price' => $row[7],
                'titer' => $row[8],
                'item_type_id' => $type,
                'item_category_id' => $row[10] ?? null,
                'properties' => $row[11] ?? null,
                'package' => $row[12] ?? null,
                'storage' => $row[13] ?? null,
                'name_en' => $row[14] ?? null,
                'composition_en' => $row[15] ?? null,
                'dosage_en' => $row[16] ?? null,
                'descr1_en' => $row[17] ?? null,
                'descr2_en' => $row[18] ?? null,
                'properties_en' => $row[19] ?? null,
                'package_en' => $row[20] ?? null,
                'storage_en' => $row[21] ?? null,
                'extra' => $row[23] ?? null,
                'extra2' => $row[24] ?? null,
                'extra_en' => $row[25] ?? null,
                'extra2_en' => $row[26] ?? null,
            ]);
            return $importedItem;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
