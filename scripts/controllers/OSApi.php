<?php

require_once 'CurlManager.php';

class OSApi extends CurlManager {

    private $url = null;
    private $user = null;
    private $password = null;
    private $token = null;

    function __construct($url, $user, $password) {
        $this->url = $url;
        $this->user = $user;
        $this->password = $password;
    }

    function isReachable() {
        if (empty($this->url)) {
            return array("status" => false, 'responseData' => 'Empty URL');
        }
        if (empty($this->user) or empty($this->password)) {
            return array("status" => false, 'responseData' => 'Username and password cannot be empty.');
        }
        $token = $this->getToken();
        $return = array(
            'success' => false,
            'responseData' => ""
        );
        if (isset($token->access->token->id)) {
            $return['success'] = true;
        } else {
            if (isset($token->error->message)) {
                $return['responseData'] = (isset($token->error->message)) ? $token->error->message : "Wrong Credentials";
            } else {
                $return['responseData'] = (isset($token)) ? $token : "Unable to generate token, invalid credentials.";
            }
        }
        return $return;
    }

    private function getWithCustomToken($tenant_id, $url, $port, $api, $method, $parameters = array(), $header = null) {

        $token_data = array(
            "auth" => array(
                "tenantId" => $tenant_id,
                "passwordCredentials" => array(
                    "username" => $this->user,
                    "password" => $this->password
                )
            )
        );

        $token = $this->send($this->url, 5000, "v2.0/tokens", "POST", $token_data);
        $headers[] = "X-Auth-Token: " . $token->access->token->id;

        if (!empty($header)) {
            $headers[] = $header;
        }

        return $this->send($url, $port, $api, $method, $parameters, $headers);
    }

    private function sendWithToken($url, $port, $api, $method, $parameters = array(), $header = null) {
		//throw new Exception("FIIINS DEMA");
        $token = $this->getToken();
        $headers[] = "X-Auth-Token: " . $token->access->token->id;
        if (!empty($header)) {
            $headers[] = $header;
        }
        return $this->send($url, $port, $api, $method, $parameters, $headers);
    }

    function getToken() {
        $data = array(
            "auth" => array("tenantName" => $this->user, "passwordCredentials" => array("username" => $this->user, "password" => $this->password))
        );
        return $this->send($this->url, 5000, "v2.0/tokens", "POST", $data);
    }

    /*
     * getSubnets
     * @return JsonResponse
     */

    function getSubnets() {
        return $this->sendWithToken($this->url, 9696, "v2.0/subnets", "GET");
    }

    /*
     * getNetworks
     * @return JsonResponse
     */

    function getNetworks() {
        return $this->sendWithToken($this->url, 9696, "v2.0/networks", "GET");
    }

    /*
     * getNetwork
     * Input $network_id
     * return JsonResponse
     */

    function getNetwork($networkId) {
        return $this->sendWithToken($this->url, 9696, "v2.0/networks/" . $networkId, "GET");
    }

    /*
     * getQuotasStorage
     * Input $admin_tenant_id, $tenand_id
     * return JsonResponse
     */

    function getQuotasStorage($tenant_id) {
        $token = $this->getToken();
        $admin_uuid = $token->access->token->tenant->id;
        return $this->sendWithToken($this->url, 8776, "v2/" . $admin_uuid . "/os-quota-sets/" . $tenant_id, "GET");
    }

    /*
     * getQuotasCompute
     * Input $admin_tenant_id, $tenand_id
     * return JsonResponse
     */

    function getQuotasCompute($tenant_id) {
        $token = $this->getToken();
        $admin_uuid = $token->access->token->tenant->id;
        return $this->sendWithToken($this->url, 8774, "v2/" . $admin_uuid . "/os-quota-sets/" . $tenant_id, "GET");
    }

    /*
     * getQuotasNetwork
     * Input $admin_tenant_id, $tenand_id
     * return JsonResponse
     */

    function getQuotasNetwork($tenant_id) {
        return $this->sendWithToken($this->url, 9696, "v2.0/quotas/" . $tenant_id, "GET");
    }

    /*
     * updateQuotasNetwork
     * Input $tenant_id, $limits => array $key => $value
     * return JsonResponse
     */

    function updateQuotasNetwork($tenant_id, $limits = null) {
        $request_limits = array();
        if (!empty($limits)) {
            $data = array();
            foreach ($limits as $key => $value) {
                $data[$key] = $value;
            }
            if (!empty($data)) {
                $request_limits['quota'] = $data;
            }
        }
        return $this->sendWithToken($this->url, 9696, "v2.0/quotas/" . $tenant_id, "PUT", $request_limits);
    }

    /*
     * updateQuotasCompute
     * Input $tenant_id, $limits => array $key => $value
     * return JsonResponse
     */

    function updateQuotasCompute($tenant_id, $limits = null) {
        $request_limits = array();
        if (!empty($limits)) {
            $data = array();
            foreach ($limits as $key => $value)
                $data[$key] = $value;
            if (!empty($data))
                $request_limits['quota_set'] = $data;
        }
        $token = $this->getToken();
        $admin_uuid = $token->access->token->tenant->id;
        return $this->sendWithToken($this->url, 8774, "v2/" . $admin_uuid . "/os-quota-sets/" . $tenant_id, "PUT", $request_limits);
    }

    /*
     * updateQuotasStorage
     * Input $tenant_id, $limits => array $key => $value
     * return JsonResponse
     */

    function updateQuotasStorage($tenant_id, $limits = null) {
        $request_limits = array();
        if (!empty($limits)) {
            $data = array();
            foreach ($limits as $key => $value)
                $data[$key] = $value;
            if (!empty($data))
                $request_limits['quota_set'] = $data;
        }
        $token = $this->getToken();
        $admin_uuid = $token->access->token->tenant->id;
        return $this->sendWithToken($this->url, 8776, "v2/" . $admin_uuid . "/os-quota-sets/" . $tenant_id, "PUT", $request_limits);
    }

    /*
     * createFloatingIp
     * Input $tenant_id, $floating_network_id
     * return JsonResponse
     */

    function createFloatingIp($tenant_id, $floating_network_id) {
        $data = array();
        if (!empty($tenant_id))
            $data['floatingip']['tenant_id'] = $tenant_id;
        if (!empty($floating_network_id))
            $data['floatingip']['floating_network_id'] = $floating_network_id;
        return $this->sendWithToken($this->url, 9696, "v2.0/floatingips", "POST", $data);
    }

    function deleteFloatingIp($floating_ip_id) {
        return $this->sendwithToken($this->url, 9696, "v2.0/floatingips/" . $floating_ip_id, "DELETE");
    }

    function getPorts($tenant_id) {
        $data = array();
        if (!empty($data))
            $data['tenant_id'] = $tenant_id;
        return $this->sendWithToken($this->url, 9696, "v2.0/ports", "GET", $data);
    }

    function getFloatingIpPools($tenant_id) {
        return $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/os-floating-ip-pools", "GET");
    }

    function allocateFloatingIp($tenant_id, $pool = null) {
        $data = array();
        if (!empty($pool))
            $data['pool'] = $pool;
        return $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/os-floating-ips", "POST", $data);
    }

    function deallocateFloatingIp($tenant_id, $id) {
        return $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/os-floating-ips/" . $id, "DELETE");
    }

    function addFloatingIp($tenant_id, $server_id, $pool) {
        $data['pool'] = $pool;
        return $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/servers/" . $server_id . "/action", "POST", $data);
    }

    function removeFloatingIp($tenant_id, $server_id, $pool) {
        $data['address'] = $pool;
        $data['removeFloatingIp'] = "removeFloatingIp";
        return $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/servers/" . $server_id . "/action", "POST", $data);
    }

    function getAllUsages() {
        $token = $this->getToken();
        $admin_uuid = $token->access->token->tenant->id;
        return $this->sendWithToken($this->url, 8774, "v2/" . $admin_uuid . "/os-hypervisors/statistics", "GET");
    }

    function getMeterStatistics($meter_name, $query = null, $groupby = null, $period = null) {
        $data = array();
        if (!empty($query))
            $data['q'] = $query;
        if (!empty($groupby))
            $data['groupby'] = $groupby;
        if (!empty($period))
            $data['period'] = $period;
        $response = $this->sendWithToken($this->url, 8777, "v2/meters/" . $meter_name . "/statistics", "GET", $data);
        error_log($meter_name . " " . print_r($response, true), 3, '/var/www/html/openstack/controllers/retrieve.txt');
        
        if (is_array($response) and count($response) > 0) {
            $suma = 0;
            for ($i = 0; $i < count($response); ++$i)
                $suma += $response[$i]->avg;
            return $suma;
        } else
            return 0;
        
        
    }

    function listExtensions(){
    	$response = $this->sendWithToken($this->url, 5000, "v2.0/extensions", "GET");
    	return $response;
    }
    
    function getServerDiagnostics($tenant_id, $server_id){
    	
    	
    	
    	$response = $this->sendWithToken($this->url, 8774, "v2/" . $tenant_id . "/servers/" . $server_id . "/diagnostics", "GET");
    	return $response;
    	
    	
    	
    }
    
    function getAdminLimits($admin_tenant_id, $tenant_id){
    	
    	echo $this->url . ":8774/" . "v2/" . $admin_tenant_id . "/limits/" . $tenant_id;    	
    	$response = $this->sendWithToken($this->url, 8774, "v2/" . $admin_tenant_id . "/limits?tenant_id=" . $tenant_id, "GET");
    	return $response;
    	
    }
    
    function getLimits($tenant_id){
    	 
    	echo $this->url . ":8774/" . "v2/" . $tenant_id . "/limits";
    	$response = $this->getWithCustomToken($tenant_id, $this->url, 8774, "v2/" . $tenant_id . "/limits", "GET");
    	
    	return $response;
    	 
    }
        

    /*
     * Meters
     */

    function getMeters($query = null) {
        $data = array();
        if (!empty($query))
            foreach ($query as $key => $value)
                $data['q'][$key] = $value;
        $response = $this->sendWithToken($this->url, 8777, "v2/meters", "GET");
        return $response;
    }
    

    function getMeter($meter_name, $query = null, $limit = null) {
        $data = array();
        if (!empty($query))
            $data['q'] = $query;
        if (!empty($limit))
            $data['limit'] = $limit;
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        $response = $this->sendWithToken($this->url, 8777, "v2/meters/" . $meter_name, "GET", $data);
        return $response;
    }

    function createMeter($meter_name, $samples = null) {
        $data = array();
        if (!empty($samples))
            $data['samples'] = $samples;
        try {
            $response = $this->send($this->url, 8777, "v2/meters/" . $meter_name, "POST", $data);
            return $response;
        } catch (Exception $e) {
            date_default_timezone_set("Europe/Madrid");
            $error = new stdClass;
            $error->date = date("Y/m/d H:i:s", strtotime("now"));
            $error->message = $e->getMessage();
            $error->code = $e->getCode();
            return $error;
        }
    }

    /*
     * ROLES
     */

    function getRoles() {
        return $this->sendWithToken($this->url, 5000, "v3/roles", "GET");
    }

    function createRole($name) {
        $role = array();
        if (!empty($name))
            $role['role']['name'];
        return $this->sendWithToken($this->url, 9292, "v3/roles", "POST", $role);
    }

    function grantRoleToDomainUser($domain_id, $user_id, $role_id) {
        if (empty($domain_id) || empty($user_id) || empty($role_id))
            return null;
        return $this->send($this->url, 5000, "v3/domains/" . $domain_id . "/users/" . $user_id . "/roles/" . $roles_id, "PUT");
    }

    function checkRoleForDomainUser($domain_id, $user_id, $role_id) {
        if (empty($domain_id) || empty($user_id) || empty($role_id))
            return null;
        return $this->send($this->url, 5000, "v3/domains/" . $domain_id . "/users/" . $user_id . "/roles/" . $roles_id, "HEAD");
    }

    function revokeRoleFromDomainUser($domain_id, $user_id, $role_id) {
        if (empty($domain_id) || empty($user_id) || empty($role_id))
            return null;
        return $this->send($this->url, 5000, "v3/domains/" . $domain_id . "/users/" . $user_id . "/roles/" . $roles_id, "DELETE");
    }

    function listRoleAssignments($group_id, $role_id, $domain_id, $project_id, $user_id, $effective) {
        $query = array();
        if (!empty($group_id))
            $query['group.id'] = $group_id;
        if (!empty($role_id))
            $query['role.id'] = $role_id;
        if (!empty($domain_id))
            $query['scope.domain.id'] = $domain_id;
        if (!empty($project_id))
            $query['scope.project.id'] = $project_id;
        if (!empty($user_id))
            $query['user.id'] = $user_id;
        if (!empty($effective))
            $query['effective'] = $effective;
        return $this->send($this->url, 5000, "v3/role_assignments", "GET", $query);
    }

    /*
     * Projects
     */

    function checkProjectExits($project_id) {
        try {
            $result = $this->sendWithToken($this->url, 5000, "v3/projects/" . $project_id, "GET");
            if (isset($result->error)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function getProjects() {
        return $this->sendWithToken($this->url, 5000, "v3/projects", "GET");
    }

    function createProject($description, $domain_id, $enabled, $name) {
        $project = array();
        if (!empty($description))
            $project['project']['description'] = $description;
        if (!empty($domain_id))
            $project['project']['domain_id'] = $domain_id;
        if (!empty($enabled))
            $project['project']['enabled'] = $enabled;
        if (!empty($name))
            $project['project']['name'] = $name;
        return $this->sendWithToken($this->url, 5000, "v3/projects", "POST", $project);
    }

    function deleteProject($id) {
        if (empty($id))
            return null;
        return $this->sendWithToken($this->url, 9292, "v3/projects/" . $id, "DELETE");
    }

    function getRolesForProjectUser($project_id, $user_id) {
        return $this->sendWithToken($this->url, 5000, "v3/projects/" . $project_id . "/users/" . $user_id . "/roles", "GET");
    }

    function grantRoleToProjectUser($project_id, $user_id, $role_id) {
        return $this->sendwithToken($this->url, 5000, "v3/projects/" . $project_id . "/users/" . $user_id . "/roles/" . $role_id, "PUT");
    }

    function revokeRoleToProjectUser($project_id, $user_id, $role_id) {
        return $this->sendwithToken($this->url, 5000, "v3/projects/" . $project_id . "/users/" . $user_id . "/roles/" . $role_id, "DELETE");
    }

    /*
     * Domains
     */

    function getDomains() {
        return $this->sendWithToken($this->url, 5000, "v3/domains", "GET");
    }

    function createDomain($name, $description = null, $enabled = true) {
        $domain = array();
        if (!empty($name))
            $domain['domain']['name'] = $name;
        if (!empty($enabled))
            $domain['domain']['enabled'] = $enabled;
        if (!empty($description))
            $domain['domain']['description'] = $description;
        return $this->sendWithToken($this->url, 5000, "v3/domains", "POST", $domain);
    }

    function updateDomain($id = null, $description = null, $enabled = false, $name = null) {
        if (empty($id))
            return null;
        $domain = array();
        if (!empty($name))
            $domain['domain']['name'] = $name;
        if (!empty($enabled))
            $domain['domain']['enabled'] = false;
        if (!empty($description))
            $domain['domain']['description'] = $description;
        return $this->sendWithToken($this->url, 5000, "v3/domains/" . $id, "PATCH", $domain);
    }

    function deleteDomain($id) {
        if (empty($id))
            return null;
        return $this->sendWithToken($this->url, 5000, "v3/domains/" . $id, "DELETE");
    }

    
    /*
     * Users
     */
    function getUsers() {
        return $this->sendWithToken($this->url, 5000, "v3/users", "GET");
    }

    function createUsers($default_project_id, $description, $domain_id = null, $email, $name, $password = null) {
        $user = array();
        if (empty($default_project_id) or empty($description) or empty($email) or empty($name))
            return null;
        if (!empty($default_project_id))
            $user['user']['default_project_id'] = $default_project_id;
        if (!empty($description))
            $user['user']['description'] = $description;
        if (!empty($domain_id))
            $user['user']['domain_id'] = $domain_id;
        if (!empty($email))
            $user['user']['email'] = $email;
        if (!empty($name))
            $user['user']['name'] = $name;
        if (!empty($password))
            $user['user']['password'] = $password;
        return $this->sendWithToken($this->url, 5000, "v3/users", "POST", $user);
    }
    
    

    function getUserDetails($id) {
        if (empty($id)) return null;
        return $this->sendWithToken($this->url, 5000, "v3/users/" . $id, "GET");
    }

    function checkUserExists($name) {
        return $this->sendWithToken($this->url, 5000, "v3/users/?name=" . $name, "GET");
    }

    
    function changePassword($user, $password){
    	$data = array();
    	if(!empty($password)) $data['user']['password'] = $password;
    	return $this->sendWithToken($this->url, 5000, "v3/users/" . $user, "PATCH", $data);
    }
    
    
    function updateUser($id, $default_project_id, $description, $email, $enabled) {
        $user = array();
        if (empty($id))
            return null;
        if (!empty($default_project_id))
            $user['user']['default_project_id'] = $default_project_id;
        if (!empty($description))
            $user['user']['description'] = $description;
        if (!empty($email))
            $user['user']['email'] = $email;
        if (!empty($enabled))
            $user['user']['enabled'] = $enabled;
        return $this->sendWithToken($this->url, 5000, "v3/users/" . $id, "POST", $user);
    }

    function deleteUser($id) {
        if (empty($id))
            return null;
        return $this->sendWithToken($this->url, 5000, "v3/users/" . $id, "DELETE");
    }

    /*
     * Tenants
     */

    function getTenants() {
        return $this->sendWithToken($this->url, 5000, "v2.0/tenants", "GET");
    }

    function createTenant($name = null, $description = null, $enabled = true) {
        $data = array();
        if (!empty($name))
            $data['tenant']['name'] = $name;
        if (!empty($description))
            $data['tenant']['description'] = $description;
        if (!empty($enabled))
            $data['tenant']['enabled'] = $enabled;
        try {
            $response = $this->sendWithToken($this->url, 35357, "v2.0/tenants", "POST", $data);
            error_log("--------------create tenant--------------" . "\r\n", 3, '/var/www/html/openstack/controllers/provision.txt');
            error_log("--------------" . print_r($response, true) . "--------------" . "\r\n", 3, '/var/www/html/openstack/controllers/provision.txt');
            error_log("-------------end create tenant------------" . "\r\n", 3, '/var/www/html/openstack/controllers/provision.txt');
            return $response;
        } catch (Exception $e) {
            throw new Exception("Failed to create tenant :" . $e->getMessage());
        }
    }

    function updateTenant($id, $name = null, $description = null, $enabled = true) {
        $data = array();
        if (empty($id))
            return null;
        if (!empty($name))
            $data['tenant']['name'] = $name;
        if (!empty($description))
            $data['tenant']['description'] = $description;
        if (!empty($enabled))
            $data['tenant']['enabled'] = $enabled;
        return $this->sendWithToken($this->url, 5000, "v2.0/tenants/" . $id, "POST", $data);
    }

    function deleteTenant($id) {
        if (empty($id))
            return null;
        return $this->sendWithToken($this->url, 5000, "v2.0/tenants/" . $id, "DELETE");
    }

    function createImage($name, $location = null, $id = null, $visibility = null, $tags = null) {
        $data = array('name' => $name);
        if (!empty($id)) {
            $data['id'] = $id;
        }
        if (!empty($visibility)) {
            $data['visibility'] = $visibility;
        }
        if (!empty($tags)) {
            $data['tags'] = $tags;
        }
        return $this->sendWithToken($this->url, 9292, "/v2/images", "POST", $data, "Location:$location;");
    }

    function listImages() {
        return $this->sendWithToken($this->url, 9292, "/v2/images", "GET");
    }
    function getImageDetails($image_id) {
        return $this->sendWithToken($this->url, 9292, "/v2/images/" . $image_id, "GET");
    }

// function updateImage($image_id) {
// $data = array("tags" => array('test1', 'test2'));
// return $this->send($this->url, 9292, "/v2/images/".$image_id, "PATCH");
// }
    function deleteImage($image_id) {
        return $this->sendWithToken($this->url, 9292, "/v2/images" . $image_id, "DELETE");
    }

    /*
     * 
     * Server related functions
     * 
     * 
     */

    function listServers($tenant_id, $server_info = null) {

        $data = array();

        if (!empty($server_info)) {
            $optional_fields = array('changes-since', 'image', 'flavour', 'name', 'marker', 'limit', 'status', 'host');
            foreach ($optional_fields as $field)
                if (!empty($server_info[$field]))
                    $data[$field] = $server_info[$field];
        }

        $call = "v2/" . $tenant_id . "/servers";
        return $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "GET", $data);
    }
  	function getServersUsage(){
  		
  		
  		$call = '/v2/​{tenant_id}​/os-simple-tenant-usage/​{tenant_id}​';
  	}
    function listServerDetails($tenant_id, $server_id) {

        $call = "v2/" . $tenant_id . "/servers/" . $server_id;
        return $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "GET");
    }
    function listServerDiagnostics($tenant_id, $server_id) {
    
    	$call = "v2/" . $tenant_id . "/servers/" . $server_id . "/diagnostics";
    	return $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "GET");
    }
    function deleteServer($tenant_id, $server_id) {
        $call = "v2/" . $tenant_id . "/servers/" . $server_id;
        $response = $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "DELETE");
        return $response;
    }

    function serverActions($tenant_id, $server_id, $action) {

        $data = array();
        if (!empty($action)) {
        	if ($action == "reboot") {
                $data = array("reboot" => array("type" => "SOFT"));
            } else if ($action == "stop") {
                $data = array("os-stop" => null);
            } else if ($action == "start") {
                $data = array("os-start" => null);
            }
        }

        $call = "v2/" . $tenant_id . "/servers/" . $server_id . "/action";
        $response = $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "POST", $data);
        
        if (isset($response->conflictingRequest)) {
            throw new Exception($response->conflictingRequest->message);
        } else {
            return $response;
        }
        
        
    }
    
    
    
    function getTenantUsageReports($tenant_id) {

    	$call = 'v2/​'. $tenant_id .'/os-simple-tenant-usage/​'. $tenant_id;
    	return $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "GET");
    	
    }
    
    function getMeterStatisticsVM($meter_name, $query = null, $groupby = null, $period = null) {

    	$data = array();
    	if (!empty($query)) $data['q'] = $query;
    	if (!empty($groupby)) $data['groupby'] = $groupby;
    	if (!empty($period)) $data['period'] = $period;
    	
    	try{
    		$response = $this->sendWithToken($this->url, 8774, "v2/meters/" . $meter_name . "/statistics", "GET", $data);
    		return $response;
    	}catch(Exception $e){
    		return 0;
    	}
    }
    
    
    function getFlavoursVM($tenant_id, $flavour_id){
    	$call = 'v2/​flavors/​' . $flavour_id;
    	$response = $this->getWithCustomToken($tenant_id, $this->url, 8774, $call, "GET");
    }
    
    

}
