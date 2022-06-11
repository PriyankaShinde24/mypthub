<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use App\Transformers\OrganisationTransformer;
use Illuminate\Database\Eloquent\Collection;

use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as Collections;
use League\Fractal\Resource\Item as Item;
use File;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(OrganisationService $service): JsonResponse
    {
        try {
            $validateArr = array(
                'name' => 'required',
                'owner' => 'required:organisations,owner_user_id',
            );
            $validator = Validator::make($this->request->all(),$validateArr);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], '400');
            } 
            $organisation = $service->createOrganisation($this->request->all());
            return $this->transformItem('organisation', $organisation, ['user'])->respond();

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], '400');
        }
    }

    public function listAll(OrganisationService $service): JsonResponse
    {
        $fractal = new Manager();
        if (isset($_GET['include'])) {
            $fractal->parseIncludes($_GET['include']);
        }
        // $organisation = $service->listOrganisation($this->request->all());
        // $resource = new Fractal\Resource\Item($organisation, new OrganisationTransformer);
        // return $fractal->createData( $resource )->parseIncludes('owner')->toJson();

        $organisation = $service->listOrganisation($this->request->all());
        return $this->transformCollection('organisation', $organisation, ['user'])->respond();
    }
}
