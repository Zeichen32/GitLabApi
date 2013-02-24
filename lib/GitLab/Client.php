<?php
namespace GitLab;

use Buzz\Browser;
use GitLab\Api\IssueApi;
use GitLab\Api\UserApi;

class Client implements ClientInterface {

    /**
     * @var \Buzz\Browser
     */
    protected $browser;

    /**
     * @var
     */
    protected $token;

    /**
     * @var
     */
    protected $api_url;

    /**
     * @var array
     */
    protected $api = array();

    /**
     * @param \Buzz\Browser $browser
     * @param $token
     * @param $api_url
     */
    public function __construct(Browser $browser, $token, $api_url)
    {
        $this->browser = $browser;
        $this->token = $token;
        $this->api_url = $api_url;
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * @return \Buzz\Browser
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    public function api($name)
    {
        switch ($name) {
            case 'users':
            case 'user':
                return (isset($this->api['user']) ?
                    $this->api['user'] : $this->api['user'] = new UserApi($this));

            case 'issues':
            case 'issue':
                return (isset($this->api['issue']) ?
                    $this->api['issue'] : $this->api['issue'] = new IssueApi($this));

            default:
                throw new \InvalidArgumentException('Unknown api call');
        }
    }
}