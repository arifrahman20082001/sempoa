<?php

class AntColonyOptimization
{
    private $pheromoneMatrix;
    private $distanceMatrix;
    private $pheromoneDecay;
    private $pheromoneDeposit;
    private $alpha;
    private $beta;
    private $numAnts;
    private $numIterations;
    private $numCities;

    public function __construct($distanceMatrix, $numAnts = 2, $numIterations = 100, $pheromoneDecay = 0.5, $pheromoneDeposit = 1.0, $alpha = 1, $beta = 2)
    {
    //   print_r($distanceMatrix);
    //   exit();
        $this->distanceMatrix = $distanceMatrix;
        $this->numCities = count($distanceMatrix);
        $this->numAnts = $numAnts;
        $this->numIterations = $numIterations;
        $this->pheromoneDecay = $pheromoneDecay;
        $this->pheromoneDeposit = $pheromoneDeposit;
        $this->alpha = $alpha;
        $this->beta = $beta;

        $this->initializePheromoneMatrix();
    }

    private function initializePheromoneMatrix()
    {
        $this->pheromoneMatrix = [];
        $initialPheromone = 1 / $this->numCities;

        for ($i = 0; $i < $this->numCities; $i++) {
            for ($j = 0; $j < $this->numCities; $j++) {
                $this->pheromoneMatrix[$i][$j] = $initialPheromone;
            }
        }
    }

    public function run()
    {
        // $bestTour = null;
        $bestTour = [];
        $bestTourLength = PHP_INT_MAX;

        for ($iteration = 0; $iteration < $this->numIterations; $iteration++) {
            $antTours = [];

            for ($ant = 0; $ant < $this->numAnts; $ant++) {
                $tour = $this->constructTour($ant);
                $tourLength = $this->calculateTourLength($tour);

                if ($tourLength < $bestTourLength) {
                    $bestTourLength = $tourLength;
                    $bestTour[] = $tour;
                }

                $antTours[$ant] = [
                    'tour' => $tour,
                    'tourLength' => $tourLength
                ];
            }

            $this->updatePheromoneMatrix($antTours);
        }
        return $bestTour;

    }

    private function constructTour($ant)
    {
        $startCity = random_int(0, $this->numCities - 1);
        $unvisitedCities = range(0, $this->numCities - 1);
        unset($unvisitedCities[$startCity]);

        $tour = [$startCity];

        while (count($unvisitedCities) > 0) {
            $nextCity = $this->selectNextCity($tour, $unvisitedCities);
            $tour[] = $nextCity;
            unset($unvisitedCities[$nextCity]);
        }

        return $tour;
    }

    private function selectNextCity($tour, $unvisitedCities)
    {
        $currentCity = end($tour);
        $probabilities = [];

        foreach ($unvisitedCities as $city) {
            $pheromoneLevel = $this->pheromoneMatrix[$currentCity][$city];
            $distance = $this->distanceMatrix[$currentCity][$city];
            $probability = pow($pheromoneLevel, $this->alpha) * pow(1 / $distance, $this->beta);
            $probabilities[$city] = $probability;
        }

        $totalProbability = array_sum($probabilities);
        $cumulativeProbability = 0;

        foreach ($probabilities as $city => $probability) {
            $probabilities[$city] = $probability / $totalProbability;
            $cumulativeProbability += $probabilities[$city];
            $probabilities[$city] = $cumulativeProbability;
        }

        $randomNumber = mt_rand() / mt_getrandmax();
        $selectedCity = null;

        foreach ($probabilities as $city => $probability) {
            if ($randomNumber <= $probability) {
                $selectedCity = $city;
                break;
            }
        }

        return $selectedCity;
    }

    private function calculateTourLength($tour)
    {
        $tourLength = 0;
        $numCities = count($tour);

        for ($i = 0; $i < $numCities - 1; $i++) {
            $cityA = $tour[$i];
            $cityB = $tour[$i + 1];
            $tourLength += $this->distanceMatrix[$cityA][$cityB];
        }

        // Add distance from the last city back to the start city
        $tourLength += $this->distanceMatrix[end($tour)][$tour[0]];

        return $tourLength;
    }

    private function updatePheromoneMatrix($antTours)
    {
        for ($i = 0; $i < $this->numCities; $i++) {
            for ($j = 0; $j < $this->numCities; $j++) {
                $this->pheromoneMatrix[$i][$j] *= $this->pheromoneDecay;
            }
        }

        foreach ($antTours as $antTour) {
            $tour = $antTour['tour'];
            $tourLength = $antTour['tourLength'];

            for ($i = 0; $i < count($tour) - 1; $i++) {
                $cityA = $tour[$i];
                $cityB = $tour[$i + 1];
                $this->pheromoneMatrix[$cityA][$cityB] += $this->pheromoneDeposit / $tourLength;
                $this->pheromoneMatrix[$cityB][$cityA] += $this->pheromoneDeposit / $tourLength;
            }
        }
    }
}

// Example usage:
// $distanceMatrix = [  
//     [0, 600, 400, 650,3850],
//     [400, 0, 1000, 250, 3850],
//     [600, 1000, 0, 1250, 3350],
//     [650, 1250, 250, 0, 7350],
//     [3850, 3350, 3850, 7350, 0],
// ];

// $aco = new AntColonyOptimization($distanceMatrix);
// $bestTour = $aco->run();

// echo "Best tour: " . implode(" -> ", $bestTour) . PHP_EOL;
// exit();
