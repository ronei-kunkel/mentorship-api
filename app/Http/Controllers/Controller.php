<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Check if data of new and old values are equal
    *
    * @param array $newData
    * @param array $oldData
    * @return bool
    */
    public function haveChanges(array $newData, array $oldData)
    {
        $haveChanges = false;
        foreach($newData as $index => $dataNew) {
            if($dataNew === $oldData[$index]) continue;
            $haveChanges = true;
        }
        return $haveChanges;
    }


    public function missingValues($requiredValues, $receivedValues)
    {
        $return = [];

        foreach($requiredValues as $value) {
            if (!isset($receivedValues[$value])) {
                array_push($return, $value);
            }
        }

        return $return;
    }
}
