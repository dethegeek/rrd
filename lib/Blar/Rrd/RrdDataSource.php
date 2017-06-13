<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

class RrdDataSource {

    const TYPE_GAUGE = 'GAUGE';
    const TYPE_COUNTER = 'COUNTER';
    const TYPE_DCOUNTER = 'DCOUNTER';
    const TYPE_DERIVE = 'DERIVE';
    const TYPE_DDERIVE = 'DDERIVE';
    const TYPE_ABSOLUTE = 'ABSOLUTE';
    const TYPE_COMPUTE = 'COMPUTE';
    const TYPE_DEFAULT = self::TYPE_COUNTER;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string RrdDataSource::TYPE_*
     */
    protected $type = self::TYPE_DEFAULT;

    /**
     * @var int
     */
    protected $heartbeat = 300;

    /**
     * @var Range
     */
    protected $range;

    /**
     * @return string
     */
    public function __toString() {
        return vsprintf('%s:%s:%u:%s:%s', [
            $this->getName(),
            $this->getType(),
            $this->getHeartbeat(),
            $this->getRangeMin(),
            $this->getRangeMax()
        ]);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return RrdDataSource
     */
    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return RrdDataSource
     */
    public function setType(string $type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeartbeat() {
        return $this->heartbeat;
    }

    /**
     * @param int $heartbeat
     *
     * @return RrdDataSource
     */
    public function setHeartbeat(int $heartbeat) {
        $this->heartbeat = $heartbeat;
        return $this;
    }

    /**
     * @return Range
     */
    public function getRange() {
        return $this->range;
    }

    /**
     * @param Range $range
     *
     * @return RrdDataSource
     */
    public function setRange(Range $range) {
        $this->range = $range;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasRange() {
        return !is_null($this->range);
    }

    /**
     * @return string
     */
    public function getRangeMin() {
        if(!$this->hasRange()) {
            return 'U';
        }
        if(!$this->getRange()->hasMin()) {
            return 'U';
        }
        return $this->getRange()->getMin();
    }

    /**
     * @return string
     */
    public function getRangeMax() {
        if(!$this->hasRange()) {
            return 'U';
        }
        if(!$this->getRange()->hasMax()) {
            return 'U';
        }
        return $this->getRange()->getMax();
    }

}
