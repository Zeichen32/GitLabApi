<?php
namespace GitLab\Api;

use Buzz\Message\Response;
use GitLab\ClientInterface;

abstract class AbstractApi {

    private $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
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
        $response = $this->getClient()->getBrowser()->get($url);
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
        $response = $this->getClient()->getBrowser()->post($url, array(), $data);
        $this->isValidRequest($response);

        return $response->getContent();
    }

    /**
     * @param $url
     * @return String
     */
    protected function deleteRequest($url) {
        /**
         * @var $response \Buzz\Message\Response
         */
        $response = $this->getClient()->getBrowser()->delete($url);
        $this->isValidRequest($response);

        return $response->getContent();
    }
}