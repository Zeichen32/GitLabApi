<?php
namespace GitLabApi;

class UserApi extends AbstractApi{

    /**
     * Get a list of users.
     *
     * @param int $page
     * @param int $per_page
     * @return array
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getUsers($page = 1, $per_page = 20) {

        if(!is_int($page))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf('%s/api/v3/users?private_token=%s&page=%d&per_page=%d', $this->getApiUrl(), $this->getToken(), $page, $per_page);

        return $this->getRequest($url);
    }

    /**
     * Get a single user.
     *
     * @param $id
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getUser($id) {
        if(!is_int($id))
            throw new \InvalidArgumentException('First parameter must be integer');

        $url = sprintf('%s/api/v3/users/%d?private_token=%s', $this->getApiUrl(), $id, $this->getToken());

        return $this->getRequest($url);
    }

    /**
     * Get currently authenticated user.
     *
     * @return array
     */
    public function getCurrentUser() {
        $url = sprintf('%s/api/v3/user?private_token=%s', $this->getApiUrl(), $this->getToken());
        return $this->getRequest($url);
    }

    /**
     * Create user. Available only for admin
     *
     * @param $email
     * @param $password
     * @param $username
     * @param $name
     * @param null $projects_limit
     * @param null $skype
     * @param null $linkedin
     * @param null $twitter
     * @return String
     * @throws \InvalidArgumentException
     */
    public function createUser($email, $password, $username, $name, $projects_limit = null, $skype = null, $linkedin = null, $twitter = null) {

        if(!is_string($email))
            throw new \InvalidArgumentException('E-Mail must be a string');

        if(!is_string($password))
            throw new \InvalidArgumentException('Password must be a string');

        if(!is_string($username))
            throw new \InvalidArgumentException('Username must be a string');

        if(!is_string($name))
            throw new \InvalidArgumentException('Name must be a string');

        if(!is_int($projects_limit) && !is_null($projects_limit))
            throw new \InvalidArgumentException('Project limit must be integer or null');

        if(!is_string($skype) && !is_null($skype))
            throw new \InvalidArgumentException('Skype must be string or null');

        if(!is_string($linkedin) && !is_null($linkedin))
            throw new \InvalidArgumentException('Linkedin must be a string or null');

        if(!is_string($twitter) && !is_null($twitter))
            throw new \InvalidArgumentException('Twitter must be a string or null');

        $data = http_build_query(array(
            'email'     => $email,
            'password'  => $password,
            'username'  => $username,
            'name'      => $name,
            'skype'     => $skype,
            'linkedin'  => $linkedin,
            'twitter'   => $twitter,
            'projects_limit'  => $projects_limit,
        ));

        $url = sprintf('%s/api/v3/users?private_token=%s', $this->getApiUrl(), $this->getToken());
        $request = $this->postRequest($url, $data);

        return $request;
    }

    /**
     * Get a list of currently authenticated user's SSH keys.
     *
     * @return array
     */
    public function getKeys() {
        $url = sprintf('%s/api/v3/user/keys?private_token=%s', $this->getApiUrl(), $this->getToken());
        return $this->getRequest($url);
    }

    /**
     * Get a single key
     *
     * @param $id
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getKey($id) {
        if(!is_int($id))
            throw new \InvalidArgumentException('First parameter must be integer');

        $url = sprintf('%s/api/v3/user/keys/%d?private_token=%s', $this->getApiUrl(), $id, $this->getToken());
        return $this->getRequest($url);
    }

    /**
     * Delete key owned by currently authenticated user
     *
     * @param $id
     * @return String
     * @throws \InvalidArgumentException
     */
    public function removeKey($id) {
        if(!is_int($id))
            throw new \InvalidArgumentException('First parameter must be integer');

        $url = sprintf('%s/api/v3/user/keys/%d?private_token=%s', $this->getApiUrl(), $id, $this->getToken());
        return $this->deleteRequest($url);
    }

    /**
     * Create new key owned by currently authenticated user
     *
     * @param $title
     * @param $key
     * @return String
     * @throws \InvalidArgumentException
     */
    public function createKey($title, $key) {
        if(!is_string($title))
            throw new \InvalidArgumentException('Title must be a string');

        if(!is_string($key))
            throw new \InvalidArgumentException('Key must be a string');

        $data = http_build_query(array(
            'title'=> $title,
            'key'  => $key,
        ));

        $url = sprintf('%s/api/v3/user/keys/%d?private_token=%s', $this->getApiUrl(), $id, $this->getToken());
        return $this->postRequest($url, $data);
    }

}