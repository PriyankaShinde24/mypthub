<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * Create Organisation
     * 
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();

        $organisation->name = $attributes['name'];
        $organisation->owner()->associate(Auth::user()->id);
        $organisation->trial_end = Carbon::now()->addDays(30);
        $organisation->subscribed = false;
        $organisation->save();

        return $organisation;
    }

    /**
     * List All Organisations
     *
     * @param array $attributes
     * @return Collection
     */
    public function listOrganisation(array $attributes): Collection
    {
        if (isset ($attributes['filter'])) {
            
            $filter = $attributes['filter'];
            switch ($filter) {
                case 'subbed': 
                    $organisation = Organisation::where('subscribed', true)->orderBy('id', 'DESC')->get();
                    break;
                case 'trial': 
                    $organisation = Organisation::whereDate('trial_end', '>', Carbon::now())->orderBy('id', 'DESC')->get();
                    break;
                case 'all':
                default: 
                    $organisation = Organisation::orderBy('id', 'DESC')->get();
                    break;
            }

        } else {

            $organisation = Organisation::orderBy('id', 'DESC')->get();
            
        }
        return $organisation;
    }
}
