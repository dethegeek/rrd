<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Dethegeek\Rrd;

/**
 * Class RrdArchive
 *
 * @package Blar\Rrd
 */
class RrdArchive {

    const CONSOLIDATION_AVERAGE = 'AVERAGE';

    const CONSOLIDATION_MIN = 'MIN';

    const CONSOLIDATION_MAX = 'MAX';

    const CONSOLIDATION_LAST = 'LAST';

    const CONSOLIDATION_DEFAULT = self::CONSOLIDATION_AVERAGE;

    private $consolidation = self::CONSOLIDATION_DEFAULT;

    /**
     * @var int
     */
    private $steps;

    /**
     * @var int
     */
    private $rows;

    /**
     * @return string
     */
    public function __toString() {
        return vsprintf('%s:%.1F:%u:%u', [
            $this->getConsolidation(),
            0.5,
            $this->getSteps(),
            $this->getRows()
        ]);
    }

    /**
     * @return string
     */
    public function getConsolidation() {
        return $this->consolidation;
    }

    /**
     * @param string $consolidation
     *
     * @return RrdArchive;
     */
    public function setConsolidation(string $consolidation) {
        $this->consolidation = $consolidation;
        return $this;
    }

    /**
     * @return int
     */
    public function getSteps() {
        return $this->steps;
    }

    /**
     * @param int $steps
     *
     * @return RrdArchive;
     */
    public function setSteps(int $steps) {
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return int
     */
    public function getRows() {
        return $this->rows;
    }

    /**
     * @param int $rows
     *
     * @return RrdArchive;
     */
    public function setRows(int $rows) {
        $this->rows = $rows;
        return $this;
    }

}
