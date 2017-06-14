<?php

namespace Dethegeek\Rrd;

use RuntimeException;

class RrdUpdater {

   /**
    * @var string
    */
   private $filename;

   private $templates = [];

   private $skipPastUpdates = false;

   private $daemon;

   private $data = [];

   /**
    * sets the database filename
    *
    * @param string $filename
    *
    * @return \Blar\Rrd\rrdUpdater
    */
   public function setFilename($filename) {
      $this->filename = $filename;
      return $this;
   }

   /**
    * add a datasource name to the template
    *
    * @param unknown $template
    *
    * @return \Blar\Rrd\rrdUpdater
    */
   public function addTemplate($template) {
      $this->templates[] = $template;
      return $this;
   }

   public function getTempalte() {
      return implode(':', $this->templates);
   }

   /**
    * set Skip past updates flag
    *
    * @param bool $skipPastUpdates
    *
    * @return \Blar\Rrd\rrdUpdater
    */
   public function setSkipPastUpdates($skipPastUpdates) {
      $this->skipPastUpdates = ($skipPastUpdates === true);
      return $this;
   }

   public function getSkipPastUpdates() {
      return $this->skipPastUpdates;
   }

   /**
    * sets daemon flag
    *
    * @param unknown $daemon
    *
    * @return \Blar\Rrd\rrdUpdater
    */
   public function setDaemon($daemon) {
      $this->daemon = ($daemon ===  true);
      return $this;
   }

   public function getDaemon() {
      return $this->daemon;
   }

   /**
    *
    * @param RrdData $data
    *
    * @return \Blar\Rrd\RrdUpdater
    */
   public function addData(RrdData $data) {
      $this->data[] = $data;
      return $this;
   }

   public function update() {
      $options = [];
      if (count($this->template) > 0) {
         $options['--template'] = $this->getTemplate();
      }
      if ($this->skipPastUpdates) {
         $options[] = '--skip-past-updates';
      }
      if ($this->daemon) {
         $options['--daemon'] = $this->daemon;
      }
      foreach ($this->data as $data) {
         $options[] = (string) $data;
      }
      if (!rrd_update($this->filename, $this->convertOptions($options))) {
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