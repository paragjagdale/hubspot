<?php

namespace Fungku\HubSpot\Api;

use Fungku\HubSpot\Exceptions\HubSpotException;

class Deals extends Api
{
    
    /**
     * For a given portal, return all pipelines and their stages that have been created in the portal.
     *
     * A paginated list of pipelines will be returned to you, with a maximum of 100 contacts per page.
     *
     * @link http://developers.hubspot.com/docs/methods/deal-pipelines/get-all-deal-pipelines 
     *
     * @return mixed
     */

    public function all($params)
    {
        $endpoint = "/deals/v1/pipelines";

        if (isset($params['property']) && is_array($params['property'])) {
            $queryString = $this->generateBatchQuery('property', $params['property']);
            unset($params['property']);
        } else {
            $queryString = null;
        }

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options, $queryString);
    }



    /**
     * Get contact property group.
     *
     * Returns all of the contact property groups for a given portal.
     *
     * @param bool $includeProperties Include the properties in the response?
     *
     * @link http://developers.hubspot.com/docs/methods/contacts/v2/get_contact_property_groups
     *
     * @return mixed
     */
    public function getGroups($includeProperties = false)
    {
        $endpoint = "/deals/v1/groups";

        if (isset($params['property']) && is_array($params['property'])) {
            $queryString = $this->generateBatchQuery('property', $params['property']);
            unset($params['property']);
        } else {
            $queryString = null;
        }
        if($includeProperties){
         $queryString = $queryString. "&includeProperties=".$includeProperties;
        }

        $options['query'] = array('includeProperties' => $includeProperties);

        return $this->request('get', $endpoint, $options, $queryString);
    }
}
