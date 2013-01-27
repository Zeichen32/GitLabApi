<?php
namespace GitLabApi;

use Buzz\Browser;
use Buzz\Message\Response;

abstract class AbstractApi {

    private $token;
    private $api_url;
    private $browser;

    public function __construct(Browser $browser, $token, $api_url) {
        $this->browser = $browser;
        $this->token = $token;
        $this->api_url = $api_url;
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

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * Check if request was successfully
     *
     * @param \Buzz\Message\Response $response
     * @return bool
     * @throws \RuntimeException
     */
    protected function isValidRequest(Response $response) {
        if((int) $response->getStatusCode() == 401)
        {
            throw new \RuntimeException('Invalid Request');
        } elseif((int) $response->getStatusCode() == 200){
            return true;
        } elseif((int) $response->getStatusCode() == 201){
            return true;
        } elseif((int) $response->getStatusCode() == 404){
            throw new \RuntimeException('Page not found!');
        }
        throw new \RuntimeException('Unknown status type:' . $response->getStatusCode());
    }

    /**
     * @param $url
     * @return array
     * @throws \Exception
     */
    protected function getRequest($url) {
        /**
         * @var $response \Buzz\Message\Response
         */
        $response = $this->getBrowser()->get($url);
        $this->isValidRequest($response);
        $content = json_decode($response->getContent(), true);

        if(!is_array($content))
            throw new \Exception('Invalid api response');

        return $content;
    }

    /**
     * @param $url
     * @param $data
     * @return String
     */
    protected function postRequest($url, $data) {
        /**
         * @var $response \Buzz\Message\Response
         */
        $response = $this->getBrowser()->post($url, array(), $data);
        $this->isValidRequest($response);

        return $response->getContent();
    }
}