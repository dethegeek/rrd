<?php

namespace Dethegeek\Rrd;

class RrdData {

   private $datetime;

   private $values = [];

   /**
    *
    * @param unknown $datetime
    *
    * @return Blar\Rrd\RrdData
    */
   public function setDatetime(\DateTimeInterface $datetime) {
      $this->datetime = $datetime;
      return $this;
   }

   /**
    * gets timestamp of first data or 'N' for now
    *
    * @return string|int
    */
   public function getDatetime() {
      if ($this->datetime === null) {
         return 'N';
      }
      return $this->datetime->getTimestamp();
   }

   public function addValue($value) {
      $this->values[] = $value;
      return $this;
   }

   public function getValues() {
      return implode(':', $this->values);
   }

   public function __toString() {
      return vsprintf('%s:%s', [
             $this->getDatetime(),
             $this->getValues()
      ]);
   }
}