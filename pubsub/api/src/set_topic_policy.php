<?php
/**
 * Copyright 2016 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/blob/main/pubsub/api/README.md
 */

namespace Google\Cloud\Samples\PubSub;

# [START pubsub_set_topic_policy]
use Google\Cloud\PubSub\PubSubClient;

/**
 * Adds a user to the policy for a Pub/Sub topic.
 *
 * @param string $projectId  The Google project ID.
 * @param string $topicName  The Pub/Sub topic name.
 * @param string $userEmail  The user email to add to the policy.
 */
function set_topic_policy($projectId, $topicName, $userEmail)
{
    $pubsub = new PubSubClient([
        'projectId' => $projectId,
    ]);
    $topic = $pubsub->topic($topicName);
    $policy = $topic->iam()->policy();
    $policy['bindings'][] = [
        'role' => 'roles/pubsub.publisher',
        'members' => ['user:' . $userEmail]
    ];
    $topic->iam()->setPolicy($policy);

    printf(
        'User %s added to policy for %s' . PHP_EOL,
        $userEmail,
        $topicName
    );
}
# [END pubsub_set_topic_policy]
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
