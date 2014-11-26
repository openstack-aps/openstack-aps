<?php

require "aps/2/runtime.php";

class allocation_pools {

    /**
     * @type("string")
     * @title("Start")
     */
    public $start;

    /**
     * @type("string")
     * @title("End")
     */
    public $end;

}

/**
 * Class IPPool
 * @author("The Mamau Agency")
 * @type("http://openstack.parallels.com/ippool/1.3")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class ippool extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/dc/2.1")
     * @required
     */
    public $dc;

    /**
     * @link("http://openstack.parallels.com/ip[]")
     */
    public $ip;

    /**
     * @type("string")
     * @title("ID")
     */
    public $id;

    /**
     * @type("string")
     * @title("Ippool name")
     */
    public $name;

    /**
     * @type("string")
     * @title("cidr")
     */
    public $cidr;
    
    /**
     * @type("string")
     * @title("OS status")
     */
    public $os_status = "enabled";

    /**
     * @type("allocation_pools[]")
     * @title("Ippool name")
     */
    public $allocation_pools;

    /**
     * @type("string")
     * @title("Gateway IP")
     */
    public $gateway_ip;

    public function provision() {
        
    }

    public function configure($new) {
        
    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

}
