<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/auth/README.md
 */

# [START auth_api_explicit_compute]
namespace Google\Cloud\Samples\Auth;

use Google\Auth\Credentials\GCECredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

use Google\Client as GoogleClient;
use Google\Service\Storage;

/**
 * Authenticate to a cloud API using Compute credentials explicitly.
 *
 * @param string $projectId           The Google project ID.
 */
function auth_api_explicit_compute($projectId)
{
    $gceCredentials = new GCECredentials();
    $middleware = new AuthTokenMiddleware($gceCredentials);
    $stack = HandlerStack::create();
    $stack->push($middleware);
    $http_client = new Client([
        'handler' => $stack,
        'base_uri' => 'https://www.googleapis.com/auth/cloud-platform',
        'auth' => 'google_auth'
    ]);

    $client = new GoogleClient();
    $client->setHttpClient($http_client);

    $storage = new Storage($client);

    # Make an authenticated API request (listing storage buckets)
    $buckets = $storage->buckets->listBuckets($projectId);

    foreach ($buckets['items'] as $bucket) {
        printf('Bucket: %s' . PHP_EOL, $bucket->getName());
    }
}
# [END auth_api_explicit_compute]
