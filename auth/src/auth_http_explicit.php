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

# [START auth_http_explicit]
namespace Google\Cloud\Samples\Auth;

# Imports Auth libraries and Guzzle HTTP libraries.
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

/**
 * Authenticate to a cloud API with HTTP using a service account explicitly.
 *
 * @param string $projectId           The Google project ID.
 * @param string $serviceAccountPath  Path to service account credentials JSON.
 */
function auth_http_explicit($projectId, $serviceAccountPath)
{
    # Construct service account credentials using the service account key file
    # and Google Auth library's ServiceAccountCredentials class.
    $serviceAccountCredentials = new ServiceAccountCredentials(
        'https://www.googleapis.com/auth/cloud-platform',
        $serviceAccountPath);
    $middleware = new AuthTokenMiddleware($serviceAccountCredentials);
    $stack = HandlerStack::create();
    $stack->push($middleware);

    # Create an HTTP Client using Guzzle and pass in the credentials.
    $http_client = new Client([
        'handler' => $stack,
        'base_uri' => 'https://www.googleapis.com/storage/v1/',
        'auth' => 'google_auth'
    ]);

    # Make an authenticated API request (listing storage buckets)
    $query = ['project' => $projectId];
    $response = $http_client->request('GET', 'b', [
        'query' => $query
    ]);
    $body_content = json_decode((string) $response->getBody());
    foreach ($body_content->items as $item) {
        $bucket = $item->id;
        printf('Bucket: %s' . PHP_EOL, $bucket);
    }
}
# [END auth_http_explicit]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
