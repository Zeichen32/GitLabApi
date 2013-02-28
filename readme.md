GitLabApi
---------------

PHP Library for easy access to the gitlab api.

This library is currently in development, so no stable release is available.

If you are looking for stable library, you should take a look at:
https://github.com/m4tthumphrey/php-gitlab-api

Usage
---------------

```php
    $browser = new \Buzz\Browser();
    $client = new \GitLab\Client($browser, 'your-key', 'http://your-gitlab-server.com');

    // Api calls
    var_dump($client->api('user')->getUsers());
    var_dump($client->api('issues')->getIssues());


    // The Alternative way
    $issue_api = new \GitLab\Api\IssueApi($client);
    var_dump($issue_api->getIssues());
```