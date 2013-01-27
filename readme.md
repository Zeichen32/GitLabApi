GitLabApi
---------------

PHP Library for easy access to the gitlab api.

This library is currently in development, so no stable release is available.


Usage
---------------

```php
    $browser = new \Buzz\Browser();
    $api = new \GitLabApi\GitLabIssueApi($browser, 'your-key', 'http://your-gitlab-server.com');

    // API Calls
    var_dump($api->getIssues());
```