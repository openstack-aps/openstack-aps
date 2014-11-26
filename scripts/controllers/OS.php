<?php

require_once "OSApi.php";

/**
 * Description of OSController
 *
 * @author Jepi Humet
 */
class OS extends OSApi {

    function getExternalSubnets() {
        $subnets = $this->getSubnets();

        $externalSubnets = array();
        foreach ($subnets->subnets as $subnet) {
            $network = $this->getNetwork($subnet->network_id);
            if ($network->network->{"router:external"} == 1) {
                $externalSubnets[] = $subnet;
            }
        }
        return $externalSubnets;
    }

}
