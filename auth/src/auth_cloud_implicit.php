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

namespace Google\Cloud\Samples\Auth;

# [START auth_cloud_implicit]
// Imports the Cloud Storage client library.
use Google\Cloud\Storage\StorageClient;

/**
 * Authenticate to a cloud client library using a service account implicitly.
 *
 * @param string $projectId The Google project ID.
 */
function auth_cloud_implicit($projectId)
{
    $config = [
        'projectId' => $projectId,
    ];

    # If you don't specify credentials when constructing the client, the
    # client library will look for credentials in the environment.
    $storage = new StorageClient($config);

    # Make an authenticated API request (listing storage buckets)
    foreach ($storage->buckets() as $bucket) {
        printf('Bucket: %s' . PHP_EOL, $bucket->name());
    }
}
# [END auth_cloud_implicit]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
