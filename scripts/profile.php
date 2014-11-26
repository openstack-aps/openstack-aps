<?php

require "aps/2/runtime.php";

/**
 * Class HeatTemplate
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/profile/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class profile extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/dc/2.1")
     * @required
     */
    public $dc;
    /**
     * @link("http://openstack.parallels.com/heatstack[]")
     */
    public $heatstack;

    public function provision() {

    }

    public function configure($new) {

    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

}

