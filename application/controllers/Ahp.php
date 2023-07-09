<?php

// Define the criteria and alternatives
$criteria = ['Price', 'Quality', 'Delivery'];
$alternatives = ['Product A', 'Product B', 'Product C'];

// Define the pairwise comparison matrix for each criterion
$priceMatrix = [
    [1, 1/3, 1/5],
    [3, 1, 1/3],
    [5, 3, 1],
];

$qualityMatrix = [
    [1, 5, 3],
    [1/5, 1, 1/3],
    [1/3, 3, 1],
];

$deliveryMatrix = [
    [1, 1/3, 5],
    [3, 1, 7],
    [1/5, 1/7, 1],
];

// Calculate the weight for each criterion
$weights = calculateWeights([$priceMatrix, $qualityMatrix, $deliveryMatrix]);

// Calculate the weighted score for each alternative
$scores = calculateScores($alternatives, $criteria, $weights);

// Print the results
echo "Weights for each criterion:\n";
foreach ($criteria as $index => $criterion) {
    echo $criterion . ': ' . $weights[$index] . "\n";
}

echo "\nWeighted scores for each alternative:\n";
foreach ($scores as $alternative => $score) {
    echo $alternative . ': ' . $score . "\n";
}

/**
 * Calculates the weights based on pairwise comparison matrices using the AHP method.
 *
 * @param array $matrices Array of pairwise comparison matrices
 * @return array Array of weights for each criterion
 */
function calculateWeights(array $matrices)
{
    $numCriteria = count($matrices);
    $numAlternatives = count($matrices[0]);

    // Calculate the normalized matrix for each criterion
    $normalizedMatrices = [];
    foreach ($matrices as $matrix) {
        $normalizedMatrix = [];
        for ($i = 0; $i < $numAlternatives; $i++) {
            $rowSum = array_sum($matrix[$i]);
            $normalizedRow = array_map(function ($value) use ($rowSum) {
                return $value / $rowSum;
            }, $matrix[$i]);
            $normalizedMatrix[] = $normalizedRow;
        }
        $normalizedMatrices[] = $normalizedMatrix;
    }

    // Calculate the average matrix
    $averageMatrix = [];
    for ($i = 0; $i < $numAlternatives; $i++) {
        $averageRow = [];
        for ($j = 0; $j < $numAlternatives; $j++) {
            $sum = 0;
            for ($k = 0; $k < $numCriteria; $k++) {
                $sum += $normalizedMatrices[$k][$i][$j];
            }
            $averageRow[] = $sum / $numCriteria;
        }
        $averageMatrix[] = $averageRow;
    }

    // Calculate the weights
    $weights = [];
    for ($i = 0; $i < $numAlternatives; $i++) {
        $weights[] = array_sum($averageMatrix[$i]) / $numAlternatives;
    }

    // Normalize the weights
    $sumWeights = array_sum($weights);
    $weights = array_map(function ($value) use ($sumWeights) {
        return $value / $sumWeights;
    }, $weights);

    return $weights;
}

/**
 * Calculates the weighted scores for each alternative based on the criteria weights.
 *
 * @param array $alternatives Array of alternative names
 * @param array $criteria Array of criteria names
 * @param array $weights Array of weights for each criterion
 * @return array Array of weighted scores for each alternative
 */
function calculateScores(array $alternatives, array $criteria, array $weights)
{
    $numAlternatives = count($alternatives);
    $numCriteria = count($criteria);

    $scores = [];
    for ($i = 0; $i < $numAlternatives; $i++) {
        $score = 0;
        for ($j = 0; $j < $numCriteria; $j++) {
            // Assume the scores for each criterion are pre-defined
            $criterionScore = getCriterionScore($alternatives[$i], $criteria[$j]);
            $score += $weights[$j] * $criterionScore;
        }
        $scores[$alternatives[$i]] = $score;
    }

    return $scores;
}

/**
 * Retrieves the score for the given alternative and criterion.
 * This function needs to be implemented based on your specific scoring criteria.
 *
 * @param string $alternative Alternative name
 * @param string $criterion Criterion name
 * @return float Score for the alternative and criterion
 */
function getCriterionScore($alternative, $criterion)
{
    // Implement your own scoring mechanism based on the alternative and criterion
    // For example, you might have a database query to retrieve the scores for each alternative and criterion
    // Here, we return dummy scores for demonstration purposes
    $dummyScores = [
        'Product A' => [
            'Price' => 8,
            'Quality' => 7,
            'Delivery' => 6,
        ],
        'Product B' => [
            'Price' => 6,
            'Quality' => 9,
            'Delivery' => 8,
        ],
        'Product C' => [
            'Price' => 7,
            'Quality' => 8,
            'Delivery' => 9,
        ],
    ];

    return $dummyScores[$alternative][$criterion];
}
