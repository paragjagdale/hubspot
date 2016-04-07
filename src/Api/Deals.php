<?php

namespace Fungku\HubSpot\Api;

use Fungku\HubSpot\Exceptions\HubSpotException;

class Deals extends Api
{

    /**
     * @param array $deal Array of deal properties.
     * @return mixed
     * @throws HubSpotException
     */
    public function create(array $deal)
    {
        $endpoint = "/deals/v1/deal";

        //added code by vilasb to make properties in name/value pair..
        $properties = array();
        foreach ($deal as $key => $value) {
                array_push($properties, array("name"=>$key,"value"=>$value));
        }
        $options['json'] = array('properties' => $properties);
        //end

        return $this->request('post', $endpoint, $options);
    }

    /**
     * @param int $id The deal id.
     * @param array $deal The deal properties to update.
     * @return mixed
     */
    public function update($id, array $deal)
    {
        $endpoint = "/deals/v1/deal/{$id}";

        //added code by vilasb to make properties in name/value pair..
        $properties = array();
        foreach ($deal as $key => $value) {
                array_push($properties, array("name"=>$key,"value"=>$value));
        }
        $options['json'] = array('properties' => $properties);
        //end

        return $this->request('put', $endpoint, $options);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $endpoint = "/deals/v1/deal/{$id}";

        return $this->request('delete', $endpoint);
    }

    /**
     * @param array $params Optional parameters ['limit', 'offset']
     * @return mixed
     */
    public function getRecentlyModified(array $params = array())
    {
        $endpoint = "/deals/v1/deal/recent/modified";
        $queryString = $this->buildQueryString($params);

        return $this->request('get', $endpoint, array(), $queryString);
    }

    /**
     * @param array $params Optional parameters ['limit', 'offset']
     * @return mixed
     */
    public function getRecentlyCreated(array $params = array())
    {
        $endpoint = "/deals/v1/deal/recent/created";
        $queryString = $this->buildQueryString($params);

        return $this->request('get', $endpoint, array(), $queryString);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $endpoint = "/deals/v1/deal/{$id}";

        return $this->request('get', $endpoint);
    }

    /**
     * @param int $dealId
     * @param int|int[] $companyId
     * @return mixed
     */
    public function associateWithCompany($dealId, $companyId)
    {
        $endpoint = "/deals/v1/deal/{$dealId}/associations/COMPANY";

        $options['query'] = array('id' => $companyId);

        return $this->request('put', $endpoint, $options);
    }

    /**
     * @param int $dealId
     * @param int|int[] $companyId
     * @return mixed
     */
    public function disassociateFromCompany($dealId, $companyId)
    {
        $endpoint = "/deals/v1/deal/{$dealId}/associations/COMPANY";

        $options['query'] = array('id' => $companyId);

        return $this->request('delete', $endpoint, $options);
    }

    /**
     * @param int $dealId
     * @param int|int[] $contactId
     * @return mixed
     */
    public function associateWithContact($dealId, $contactId)
    {
        $endpoint = "/deals/v1/deal/{$dealId}/associations/CONTACT";

        $options['query'] = array('id' => $contactId);

        return $this->request('put', $endpoint, $options);
    }

    /**
     * @param int $dealId
     * @param int|int[] $contactId
     * @return mixed
     */
    public function disassociateFromContact($dealId, $contactId)
    {
        $endpoint = "/deals/v1/deal/{$dealId}/associations/CONTACT";

        $options['query'] = array('id' => $contactId);

        return $this->request('delete', $endpoint, $options);
    }
    
    /**
     * For a given portal, return all pipelines and their stages that have been created in the portal.
     *
     * A paginated list of pipelines will be returned to you, with a maximum of 100 contacts per page.
     *
     * @link http://developers.hubspot.com/docs/methods/deal-pipelines/get-all-deal-pipelines 
     *
     * @return mixed
     */

    public function allPipelines($params){
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
