<?php

declare(strict_types=1);

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\User;
use App\Organisation;
use Carbon\Carbon;
use DateTime;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    //protected $defaultIncludes = [
        // 'user'
    // ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    //protected $availableIncludes = [
        //
    //];
    
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        $trialEndDate = Carbon::create($organisation->trial_end);
        return [
            'id'        => $organisation->id,
            'name'      => $organisation->name,
            'trial_end' => ($organisation->subscribed == TRUE) ? 'Subscribed' : $trialEndDate->format('F j, Y, g:i a'),
            'user'      => $organisation->owner,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Organisation $organisation)
    {
        $user = $organisation->owner;
        return $this->item($user, new UserTransformer, ['user']);
    }
}
