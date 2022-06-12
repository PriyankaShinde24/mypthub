<?php

namespace App\Listeners;

use App\Events\OrganisationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Organisation;
use App\Mail\OrganisationCreatedEmail;

class SendOrganisationCreatedConfirmationEmail
{
    public $organisation;
    public $user;
    /**
     * Create the event listener.
     *
     * @param Organisation $organisation
     * @param User $user
     */
    public function __construct(Organisation $organisation, User $user)
    {
        $this->organisation = $organisation;
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  OrganisationCreated  $event
     * @return void
     */
    public function handle(OrganisationCreated $event)
    {
        \Mail::to(Auth::user()->email)->send(
            new OrganisationCreatedEmail($event->organisation, $event->user)
        );
    }
}
