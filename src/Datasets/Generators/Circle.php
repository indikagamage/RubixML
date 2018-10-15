<?php

namespace Rubix\ML\Datasets\Generators;

use Rubix\Tensor\Vector;
use Rubix\Tensor\Matrix;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Unlabeled;
use InvalidArgumentException;

/**
 * Circle
 *
 * Create a circle made of sample data points in 2 dimensions.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class Circle implements Generator
{
    const TWO_PI = 2. * M_PI;

    /**
     * The center vector of the circle.
     *
     * @var \Rubix\Tensor\Vector
     */
    protected $center;

    /**
     * The scaling factor of the circle.
     *
     * @var float
     */
    protected $scale;

    /**
     * The amount of gaussian noise to add to the points as a percentage.
     *
     * @var float
     */
    protected $noise;

    /**
     * @param  float  $x
     * @param  float  $y
     * @param  float  $scale
     * @param  float  $noise
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __construct(float $x = 0., float $y = 0., float $scale = 1.0, float $noise = 0.1)
    {
        if ($scale < 0.) {
            throw new InvalidArgumentException('Scaling factor must be greater'
                . ' than 0.');
        }

        if ($noise < 0. or $noise > 1.) {
            throw new InvalidArgumentException('Noise factor must be between'
                . ' 0 and 1.');
        }

        $this->center = Vector::quick([$x, $y]);
        $this->scale = $scale;
        $this->noise = $noise;
    }

    /**
     * Return the dimensionality of the data this generates.
     *
     * @return int
     */
    public function dimensions() : int
    {
        return 2;
    }

    /**
     * Generate n data points.
     *
     * @param  int  $n
     * @return \Rubix\ML\Datasets\Dataset
     */
    public function generate(int $n = 100) : Dataset
    { 
        $r = Vector::rand($n)->multiply(self::TWO_PI);

        $noise = Matrix::gaussian($n, 2)
            ->multiply($this->noise);

        $samples = Matrix::concatenate([$r->cos(), $r->sin()])
            ->add($noise)
            ->multiply($this->scale)
            ->add($this->center)
            ->asArray();

        return Unlabeled::quick($samples);
    }
}
