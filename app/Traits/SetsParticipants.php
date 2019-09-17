<?php

namespace App\Traits;

trait SetsParticipants
{
    protected $from;
    protected $to;
    protected $user;

    /**
     * Sets user.
     *
     * @param object $user
     *
     * @return $this
     */
    public function for($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Sets user.
     *
     * @param object $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set Sender.
     *
     * @param int $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = is_object($from) ? $from->getKey() : $from;

        return $this;
    }

    public function to($recipient)
    {
        $this->to = $recipient;

        return $this;
    }
}
