<?php

namespace Rubix\ML;

use Rubix\ML\Datasets\Dataset;

interface Estimator
{
    const CLASSIFIER = 1;
    const REGRESSOR = 2;
    const CLUSTERER = 3;
    const DETECTOR = 4;
    const EMBEDDER = 5;

    const TYPES = [
        self::CLASSIFIER => 'classifier',
        self::REGRESSOR => 'regressor',
        self::CLUSTERER => 'clusterer',
        self::DETECTOR => 'anomaly detector',
        self::EMBEDDER => 'embedder',
    ];

    const EPSILON = 1e-8;

    /**
     * Return the integer encoded estimator type.
     *
     * @return int
     */
    public function type() : int;

    /**
     * Return the data types that this estimator is compatible with.
     *
     * @return int[]
     */
    public function compatibility() : array;

    /**
     * Make predictions from a dataset.
     *
     * @param \Rubix\ML\Datasets\Dataset $dataset
     * @return array
     */
    public function predict(Dataset $dataset) : array;
}
