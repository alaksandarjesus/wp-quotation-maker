<?php

namespace Plugin\Core;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;

class Log
{

   
    private $path;

    private $name;

    public function __construct($name = 'quomak', $path = NULL)
    {
   
        if(empty($path)){
            
            $path = QUOMAK_PLUGIN_DIR.'./logs/'.$name.'.log';

        }

        $this->path = $path;

        $this->name = $name;

        

    }

    public  function logger($level){

        $logger = new Logger($this->name);

        $logger->setTimezone(new \DateTimeZone('ASIA/KOLKATA'));

        $handler = new StreamHandler($this->path, $level);

        $dateFormat = "d-m-Y H:i:s";

        $handler->setFormatter(new LineFormatter(NULL, $dateFormat, false, true));

        $logger->pushHandler($handler);

        return $logger;

    }

    public function info($log){

        $logger = $this->logger(Level::Info);

        $logger->info($log);

        return;

    }

    public function debug($log){

        $logger = $this->logger(Level::Debug);

        $logger->debug($log);

        return;

    }

    public function error($log){

        $logger = $this->logger(Level::Error);

        $logger->error($log);

        return;

    }

    public function warning($log){

        $logger = $this->logger(Level::Warning);

        $logger->warning($log);

        return;
    }

    public function notice($log){

        $logger = $this->logger(Level::Notice);

        $logger->notice($log);

        return;

    }


    public function critical($log){

        $logger = $this->logger(Level::Critical);

        $logger->critical($log);

        return;

    }

    public function alert($log){

        $logger = $this->logger(Level::Alert);

        $logger->alert($log);

        return;

    }

    public function emergency($log){

        $logger = $this->logger(Level::Emergency);

        $logger->emergency($log);

        return;

    }

}
