<?php namespace Fungku;

use Fungku\HubSpot\API\Blog;
use Fungku\HubSpot\API\Contacts;
use Fungku\HubSpot\API\Forms;
use Fungku\HubSpot\API\Keywords;
use Fungku\HubSpot\API\LeadNurturing;
use Fungku\HubSpot\API\Leads;
use Fungku\HubSpot\API\Lists;
use Fungku\HubSpot\API\MarketPlace;
use Fungku\HubSpot\API\Properties;
use Fungku\HubSpot\API\Settings;
use Fungku\HubSpot\API\SocialMedia;
use Fungku\HubSpot\API\Workflows;

class HubSpot {

    /**
     * @var string
     */
    private $hapikey;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @param string $hapikey
     * @param string $userAgent
     */
    function __construct($hapikey = null, $userAgent = "haPiHP default UserAgent")
    {
        $this->hapikey = $hapikey;
        $this->userAgent = $userAgent;

        if (is_null($this->hapikey))
            $this->hapikey = getenv('HUBSPOT_APIKEY');
    }

    public function blog()          { return new Blog($this->hapikey); }

    public function contacts()      { return new Contacts($this->hapikey); }

    public function forms()         { return new Forms($this->hapikey); }

    public function keywords()      { return new Keywords($this->hapikey); }

    public function leadNurturing() { return new LeadNurturing($this->hapikey); }

    public function leads()         { return new Leads($this->hapikey); }

    public function lists()         { return new Lists($this->hapikey); }

    public function marketPlace()   { return new MarketPlace($this->hapikey); }

    public function properties()    { return new Properties($this->hapikey); }

    public function settings()      { return new Settings($this->hapikey); }

    public function socialMedia()   { return new SocialMedia($this->hapikey); }

    public function workflows()     { return new WorkFlows($this->hapikey); }
}
