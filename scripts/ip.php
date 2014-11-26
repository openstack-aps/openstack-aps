<?php

require "aps/2/runtime.php";

/**
 * Class IP
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/ipprovider/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class ip extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/ippool")
     * @required
     */
    public $ippool;

    /**
     * @link("http://openstack.parallels.com/ip")
     */
    public $ip;

    public function provision() {
        
    }

    public function configure($new) {
        
    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

}

