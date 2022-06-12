<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\User;
use App\Organisation;
use Carbon\Carbon;

class OrganisationCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $organisation;
    public $user;
    public $trialEndDate;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $trialEndDate = Carbon::create($this->organisation->trial_end);
        $trialEnds = $trialEndDate->format('F j, Y, g:i a');
        return $this->markdown('emails.organisation-created',['trialEnds' => $trialEnds]);
    }
}
