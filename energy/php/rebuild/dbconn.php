<?php

class DBConn {
  const server = "localhost";
  const user = "igor";
  const password = "UqYfh7dM";
  const database = "energy_test";
  public $averageTables = 
    array(
      array(
        'name' => 'aggr_data_1min',
        'interval_size' => 60,
      ),
      array(
        'name' => 'aggr_data_1hour',
        'interval_size' => 3600,
      ),
      array(
        'name' => 'aggr_data_1day',
        'interval_size' => 86400,
      ),
    );

  function getAllSensors() {
    $query = "SELECT DISTINCT id FROM raw_data";
    $result = mysql_query($query);
    $retval = array();

    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $retval[$line['id']] = $line['id'];
    }

    return $retval;
  }

  function getAveragedTimeData($id, $from, $to, $interval_size) {
    $table_name = null;
    foreach ($this->averageTables as $table) {
      if ($interval_size == $table['interval_size']) {
        $table_name = $table['name'];
      }
    }
    if (!$table_name) {
      return null;
    }
    $query = "SELECT time, value FROM $table_name ".
      "WHERE id='$id' AND ".
      "time BETWEEN '$from' AND '$to' ".
      "ORDER BY time";
    $result = mysql_query($query);
    if (!$result) {
      throw new Exception("Query failed: $query\n");
    }
    $retval = array();

    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $retval[] = $line;
    }

    return $retval;
  }

  function getTimeData($id, $from, $to) {
    $query = "SELECT time, value FROM raw_data ".
      "WHERE id='$id' AND ".
      "time BETWEEN '$from' AND '$to' ".
      "ORDER BY time";
    $result = mysql_query($query);
    if (!$result) {
      throw new Exception("Query failed: $query\n");
    }
    $retval = array();

    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $retval[] = $line;
    }

    return $retval;
  }

  private function rebuild($sensor, $start, $table_name, $interval_size) {
    if (!$start) {
      $query = "SELECT MIN(time) FROM raw_data WHERE id=$sensor";
      $min = mysql_query($query);
      if (!$min) {
        throw new Exception("Query failed: $query");
      }
      $min = mysql_fetch_row($min);
      if (!$min) {
        throw new Exception("mysql_fetch_row failed after: $query");
      }
      $start = intval($min[0]/$interval_size) * $interval_size;
    }

    $end = 0;
    for ( ; ; $start = $end) {
      // we operate with only max one day worth of data
      $end = $start + intval(86400 / $interval_size) * $interval_size;

      echo "Building $table_name from $start to $end on sensor $sensor<br>";

      $data = $this->getTimeData($sensor, $start, $end - 1);
      if (empty($data)) {
        echo "...done<br>";
        break;
      }

      echo "...got ".count($data)." records <br>";

      $to_be_inserted = array();

      // make sure to insert the last interval
      $data[] = array('time' => PHP_INT_MAX, 'value' => 0);

      for ($begin_interval = $start, $i = 0; $i+1 < count($data); $begin_interval += $interval_size) {
        $n = 0;
        $sum = 0.0;

        for ( ; $i < count($data); ++$i) {
          $time = intval($data[$i]['time']);
          $value = floatval($data[$i]['value']);

          if ($time >= $begin_interval + $interval_size) {
            break;
          } else {
            ++$n;
            $sum += $value;
          }
        }

        if ($n) $to_be_inserted[$begin_interval] = $sum / $n;
      }

      $to_be_inserted_chunks = array_chunk($to_be_inserted, 500, true);
      foreach ($to_be_inserted_chunks as $insert_array) {
        $query = "INSERT INTO $table_name (id, time, value) VALUES ";
        foreach ($insert_array as $time => $value) {
          $query .= "('$sensor', '$time', '$value'), ";
        }

        $query = substr($query, 0, strlen($query) - 2);
        if (!mysql_query($query)) {
          throw new Exception("Insert query failed: $query\n");
        }
      }
    }
  }

  public function rebuildAverageTables() {
    try {
      $sensors = $this->getAllSensors();

      foreach ($this->averageTables as $table) {
        foreach ($sensors as $sensor) {
          // get max
          $query = "SELECT MAX(time) FROM {$table['name']} WHERE id=$sensor";
          $result = mysql_query("$query");
          if (!$result) {
            throw new Exception("Query failed: $query");
          }

          $result = mysql_fetch_row($result);
          $max = 0;
          if ($result && $result[0]) {
            $max = $result[0];
          } 

          // we do this because we're not sure if the last entry 
          // is complete average of all available values
          $query = "DELETE FROM {$table['name']} WHERE id=$sensor AND time=$max";
          if (!mysql_query($query)) {
            throw new Exception("Query failed: $query");
          }

          $this->rebuild($sensor, $max, $table['name'], $table['interval_size']);
        }
      }
      echo "Done... All is OK.\n";
    } catch (Exception $ex) {
      echo "Something went wrong: ".$ex->getMessage();
    }
  }

  function __construct() {
    $this->link = mysql_connect(self::server, self::user, self::password);
    if (!$this->link) {
      throw new Exception("Connection to DB failed\n");
    }
    mysql_select_db(self::database);
  }

  function __destruct() {
    mysql_close($this->link);
  }

}

?>
