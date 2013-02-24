<?php
namespace GitLab;

interface ClientInterface {
    function getApiUrl();
    function getBrowser();
    function getToken();
    function api($name);
}