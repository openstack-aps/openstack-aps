<?php

require "aps/2/runtime.php";

/**
 * Class HeatStack
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/heatstack/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class heatstack extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/organization")
     * @required
     */
    public $organization;
    /**
     * @link("http://openstack.parallels.com/profile")
     * @required
     */
    public $profile;
    /**
     * @link("http://openstack.parallels.com/ipassigned[]")
     */
    public $ipassigned;

    public function provision() {

    }

    public function configure($new) {

    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

}

