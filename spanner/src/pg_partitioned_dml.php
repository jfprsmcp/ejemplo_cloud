<?php
/**
 * Copyright 2022 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/spanner/README.md
 */

namespace Google\Cloud\Samples\Spanner;

// [START spanner_postgresql_partitioned_dml]
use Google\Cloud\Spanner\SpannerClient;

/**
 * Execute Partitioned DML on a Spanner PostgreSQL database.
 * See also https://cloud.google.com/spanner/docs/dml-partitioned.
 *
 * @param string $instanceId The Spanner instance ID.
 * @param string $databaseId The Spanner database ID.
 */
function pg_partitioned_dml(string $instanceId, string $databaseId): void
{
    $spanner = new SpannerClient();
    $instance = $spanner->instance($instanceId);
    $database = $instance->database($databaseId);

    // Spanner PostgreSQL has the same transaction limits as normal Spanner. This includes a
    // maximum of 20,000 mutations in a single read/write transaction. Large update operations can
    // be executed using Partitioned DML. This is also supported on Spanner PostgreSQL.
    // See https://cloud.google.com/spanner/docs/dml-partitioned for more information.
    $count = $database->executePartitionedUpdate('DELETE FROM users WHERE active = false');

    printf('Deleted %s inactive user(s).' . PHP_EOL, $count);
}
// [END spanner_postgresql_partitioned_dml]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
