<?php
namespace GitLabApi;

class IssueApi extends AbstractApi{

    /**
     * Get all issues created by authenticed user
     *
     * @param int $page
     * @param int $per_page
     * @return array
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getIssues($page = 1, $per_page = 20) {

        if(!is_int($page))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf('%s/api/v3/issues?private_token=%s&page=%d&per_page=%d', $this->getApiUrl(), $this->getToken(), $page, $per_page);

        return $this->getRequest($url);
    }

    /**
     * Get a list of project issues
     *
     * @param $project_id
     * @param int $page
     * @param int $per_page
     * @return array
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function getProjectIssues($project_id, $page = 1, $per_page = 20) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($page))
            throw new \InvalidArgumentException('Second parameter must be integer');

        if(!is_int($per_page))
            throw new \InvalidArgumentException('Third parameter must be integer');

        $url = sprintf('%s/api/v3/projects/%d/issues?private_token=%s&page=%d&per_page=%d', $this->getApiUrl(), $project_id, $this->getToken(), $page, $per_page);

        return $this->getRequest($url);
    }

    /**
     * Get a single project issue
     *
     * @param $project_id
     * @param $issue_id
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getProjectIssue($project_id, $issue_id) {
        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_int($issue_id))
            throw new \InvalidArgumentException('Second parameter must be integer');

        $url = sprintf('%s/api/v3/projects/%d/issues/%d?private_token=%s', $this->getApiUrl(), $project_id, $issue_id, $this->getToken());

        return $this->getRequest($url);
    }

    /**
     * Create a new project issue
     *
     * @param $project_id
     * @param $title
     * @param null $description
     * @param null $assignee_id
     * @param null $milestone_id
     * @param array $labels
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function createIssue($project_id, $title, $description = null, $assignee_id = null, $milestone_id = null, array $labels = array()) {

        if(!is_int($project_id))
            throw new \InvalidArgumentException('First parameter must be integer');

        if(!is_string($title))
            throw new \InvalidArgumentException('Second parameter must be string');

        if(!is_string($description) && !is_null($description))
            throw new \InvalidArgumentException('Third parameter must be string or null');

        if(!is_int($assignee_id) && !is_null($assignee_id))
            throw new \InvalidArgumentException('Fifth parameter must be integer or null');

        if(!is_int($milestone_id) && !is_null($milestone_id))
            throw new \InvalidArgumentException('Sixth parameter must be integer or null');

        $data = http_build_query(array(
            'project_id'    => $project_id,
            'title'         => $title,
            'description'   => $description,
            'assignee_id'   => $assignee_id,
            'milestone_id'  => $milestone_id,
            'labels'        => implode(',', $labels),
        ));

        $url = sprintf('%s/api/v3/projects/%d/issues?private_token=%s', $this->getApiUrl(), $project_id, $this->getToken());
        $this->postRequest($url, $data);
    }
}