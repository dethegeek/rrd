<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Rrd;

use DateTimeInterface;
use RuntimeException;

/**
 * Class RrdCreator
 *
 * @package Blar\Rrd
 */
class RrdCreator {

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var DateTimeInterface
     */
    private $start;

    /**
     * @var int
     */
    private $step = 0;

    /**
     * @var array
     */
    private $dataSources = [];

    /**
     * @var array
     */
    private $archives = [];

    /**
     * @return mixed
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     *
     * @return RrdCreator
     */
    public function setFileName(string $fileName) {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param DateTimeInterface $start
     *
     * @return RrdCreator
     */
    public function setStart(DateTimeInterface $start) {
        $this->start = $start;
        return $this;
    }

    /**
     * @return int Seconds
     */
    public function getStep() {
        return $this->step;
    }

    /**
     * @param int $step Seconds
     *
     * @return RrdCreator
     */
    public function setStep(int $step) {
        $this->step = $step;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataSources() {
        return $this->dataSources;
    }

    /**
     * @param RrdDataSource $source
     *
     * @return RrdCreator
     */
    public function addDataSource(RrdDataSource $source) {
        $this->dataSources[] = $source;
        return $this;
    }

    /**
     * @return array
     */
    public function getArchives() {
        return $this->archives;
    }

    /**
     * @param RrdArchive $archive
     *
     * @return RrdCreator
     */
    public function addArchive(RrdArchive $archive) {
        $this->archives[] = $archive;
        return $this;
    }

    public function save() {
        $options = [
            '--start' => $this->getStart()->getTimestamp(),
            '--step' => $this->getStep()
        ];
        foreach($this->getDataSources() as $dataSource) {
            $options[] = sprintf('DS:%s', $dataSource);
        }
        foreach($this->getArchives() as $archive) {
            $options[] = sprintf('RRA:%s', $archive);
        }
        $status = rrd_create($this->getFileName(), $this->convertOptions($options));
        if(!$status) {
            throw new RuntimeException(rrd_error());
        }
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function convertOptions(array $options) {
        $result = [];
        foreach($options as $key => $value) {
            if(!is_numeric($key)) {
                $result[] = $key;
            }
            $result[] = $value;
        }
        return $result;
    }


}