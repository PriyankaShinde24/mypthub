<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use App\User;
use League\Fractal\TransformerAbstract;
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
    

    
    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        $trialEndDate = Carbon::create($organisation['trial_end']);
        return [
            'id' => $organisation->id,
            'name' => $organisation->name,
            'trial_end' => ($organisation->subscribed == TRUE) ? 'Subscribed' : $trialEndDate->format('F j, Y, g:i a'),
            'owner' => $organisation->owner,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Organisation $organisation)
    {
        // $owner = $organisation->user;
        // return $this->item($owner , new UserTransformer);
        return $this->item($organisation->owner, new UserTransformer);
    }
}
