<?php
/**
 * Copyright 2021 Google LLC.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/bigtable/README.md
 */

namespace Google\Cloud\Samples\Bigtable;

// [START bigtable_writes_conditional]
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Mutations;

/**
 * Write data conditionally in a table
 *
 * @param string $projectId The Google Cloud project ID
 * @param string $instanceId The ID of the Bigtable instance
 * @param string $tableId The ID of the table where the data needs to be written
 */
function write_conditionally(
    string $projectId,
    string $instanceId,
    string $tableId = 'mobile-time-series'
): void {
    // Connect to an existing table with an existing instance.
    $dataClient = new BigtableClient([
        'projectId' => $projectId,
    ]);
    $table = $dataClient->table($instanceId, $tableId);

    $timestampMicros = time() * 1000 * 1000;
    $columnFamilyId = 'stats_summary';

    $mutations = (new Mutations())->upsert($columnFamilyId, 'os_name', 'android', $timestampMicros);
    $predicateFilter = Filter::chain()
    ->addFilter(Filter::family()->exactMatch($columnFamilyId))
    ->addFilter(Filter::qualifier()->exactMatch('os_build'))
    ->addFilter(Filter::value()->regex('PQ2A.*'));
    $options = ['predicateFilter' => $predicateFilter, 'trueMutations' => $mutations];

    $table->checkAndMutateRow('phone#4c410523#20190501', $options);

    printf('Successfully updated row\'s os_name' . PHP_EOL);
}
// [END bigtable_writes_conditional]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
