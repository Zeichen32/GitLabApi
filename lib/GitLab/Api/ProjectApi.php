<?php
namespace GitLab\Api;


class ProjectApi extends AbstractApi {

    public function getProjects($page = 1, $per_page = 20) {
        if(!is_int($page))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects?private_token=%s&page=%d&per_page=%d',

            $this->getClient()->getApiUrl(),
            urlencode($this->getClient()->getToken()),
            $page,
            $per_page
        );

        return $this->getRequest($url);
    }

    public function getProject($id) {
        if(!is_int($id))
            throw new \InvalidArgumentException('First parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects/%d?private_token=%s',

            $this->getClient()->getApiUrl(),
            $id,
            urlencode($this->getClient()->getToken())
        );

        return $this->getRequest($url);
    }

    public function createProject($name, $description = null, $default_branch = null, $issues_enabled = true,
                                  $wall_enabled = true, $merge_requests_enabled = true, $wiki_enabled = true) {

        if(!is_string($name))
            throw new \InvalidArgumentException('Name must be a string.');

        if(!is_string($description) && !is_null($description))
            throw new \InvalidArgumentException('Description must be a string or null.');

        if(!is_string($default_branch) && !is_string($default_branch))
            throw new \InvalidArgumentException('Default branch must be a string or null.');

        if(!is_bool($issues_enabled))
            throw new \InvalidArgumentException('Issue enabled must be boolean');

        if(!is_bool($wall_enabled))
            throw new \InvalidArgumentException('Wall enabled must be boolean');

        if(!is_bool($merge_requests_enabled))
            throw new \InvalidArgumentException('Merge request enabled must be boolean');

        if(!is_bool($wiki_enabled))
            throw new \InvalidArgumentException('Wiki enabled must be boolean');

        $data = http_build_query(array(
            'name'                      => $name,
            'description'               => $description,
            'default_branch'            => $default_branch,
            'issues_enabled'            => $issues_enabled,
            'wall_enabled'              => $wall_enabled,
            'merge_requests_enabled'    => $merge_requests_enabled,
            'wiki_enabled'              => $wiki_enabled,
        ));

        $url = sprintf(
            '%s/api/v3/projects?private_token=%s',

            $this->getClient()->getApiUrl(),
            urlencode($this->getClient()->getToken())
        );

        $request = $this->postRequest($url, $data);

        return $request;
    }

    public function getProjectTeamMembers($project_id, $page = 1, $per_page = 20) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be a integer.');

        if(!is_int($page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Third parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects/%d/members?private_token=%s&page=%d&per_page=%d',

            $this->getClient()->getApiUrl(),
            $project_id,
            urlencode($this->getClient()->getToken()),
            $page,
            $per_page
        );

        return $this->getRequest($url);
    }

    public function getProjectTeamMember($project_id, $user_id) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be a integer.');

        if(!is_int($user_id))
            throw new \InvalidArgumentException('Second parameter must be a integer.');

        $url = sprintf(
            '%s/api/v3/projects/%d/members/%d?private_token=%s',

            $this->getClient()->getApiUrl(),
            $project_id,
            $user_id,
            urlencode($this->getClient()->getToken())
        );

        return $this->getRequest($url);
    }

    public function removeProjectTeamMember($project_id, $user_id) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($user_id))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects/%d/members/%d?private_token=%s',

            $this->getClient()->getApiUrl(),
            $project_id,
            $user_id,
            urlencode($this->getClient()->getToken())
        );

        return $this->deleteRequest($url);
    }

    public function getProjectHooks($project_id, $page = 1, $per_page = 20) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Third parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects/%d/hooks?private_token=%s&page=%d&per_page=%d',

            $this->getClient()->getApiUrl(),
            $project_id,
            urlencode($this->getClient()->getToken()),
            $page,
            $per_page
        );

        return $this->getRequest($url);
    }

    public function getProjectHook($project_id, $hook_id) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($hook_id))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf(
            '%s/api/v3/projects/%d/hooks/%d?private_token=%s',

            $this->getClient()->getApiUrl(),
            $project_id,
            $hook_id,
            urlencode($this->getClient()->getToken())
        );

        return $this->getRequest($url);
    }

    public function createProjectHook($project_id, $url) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('Project id must be integer');

        if(!is_string($url))
            throw new \InvalidArgumentException('Url must be string');

        $data = http_build_query(array(
            'url' => $url,
        ));

        $url = sprintf(
            '%s/api/v3/projects/%s/hooks?private_token=%s',

            $this->getClient()->getApiUrl(),
            $project_id,
            urlencode($this->getClient()->getToken())
        );

        $request = $this->postRequest($url, $data);

        return $request;
    }

}