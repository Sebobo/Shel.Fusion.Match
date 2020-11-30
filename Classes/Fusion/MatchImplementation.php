<?php
declare(strict_types=1);

namespace Shel\Fusion\Match\Fusion;

/*                                                                        *
 * This script belongs to the package "Shel.Fusion.Match".                *
 *                                                                        */

use Neos\Fusion\Exception as FusionException;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Implementation class for embedding svgs in fusion
 */
class MatchImplementation extends AbstractFusionObject
{

    /**
     * Evaluate this Fusion object and return the result
     * @return mixed
     * @throws FusionException
     */
    public function evaluate()
    {
        $subject = $this->getSubject();
        $result = $this->fusionValue($subject);

        if ($result !== null) {
            return $result;
        }

        $default = $this->getDefault();
        if ($default !== null) {
            return $default;
        }

        throw new FusionException('Unhandled match', 1606730107);
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return (string)($this->fusionValue('__meta/subject') ?? '');
    }

    /**
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->fusionValue('__meta/default');
    }
}
