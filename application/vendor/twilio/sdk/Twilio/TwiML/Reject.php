<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\TwiML;

class Reject extends TwiML {
    /**
     * Reject constructor.
     * 
     * @param array $attributes Optional attributes
     */
    public function __construct($attributes = array()) {
        parent::__construct('Reject', $attributes);
    }

    /**
     * Add Reason attribute.
     * 
     * @param enum:Reason $reason Rejection reason
     * @return TwiML $this.
     */
    public function setReason($reason) {
        return $this->setAttribute('reason', $reason);
    }
}