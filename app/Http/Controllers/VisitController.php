<?php

namespace App\Http\Controllers;

use App\Http\Response\JsonRpcResponse;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    public function getVisits()
    {
        $visits = Visit::select('id', 'url', 'views', 'updated_at AS last_visit')->orderBy('id')->get();

        return $visits;
    }

    public function store(array $params)
    {
        if ($this->checkValidData($params)) {
            if ($this->existVisit($params)) {
                $visit = Visit::whereUrl($params['url'])->first();
                $visit->views = $visit->views + 1;
            }
            else {
                $visit = new Visit();
                $visit->url = $params['url'];
                $visit->created_at = $params['date'];
            }
            $visit->updated_at = $params['date'];
            $visit->save();
            return $visit;
        }
        $response['error'] = 'Input data is not valid!';
        return $response;
    }

    /**
     * Check if received data is valid
     * @param array $params
     * @return bool
     */
    private function checkValidData(array $params) :bool
    {
        $validator = Validator::make($params, [
            'url' => 'required|url',
            'date' => 'date_format:Y-m-d H:i:s',
        ]);
        return !$validator->fails();
    }

    /**
     * Check if exist visit with this url in database
     * @param array $params
     * @return bool
     */
    private function existVisit(array $params) :bool
    {
        $validator = Validator::make($params, [
            'url' => 'unique:visits,url',
        ]);
        return $validator->fails();
    }
}
