<?php

global $sugar_config;

$call = new ClickToCall();

$options = array(
    'clicktocall_asterisk_ip' => 'setAsteriskIp',
    'clicktocall_asterisk_port' => 'setAsteriskPort'
);

foreach ($options as $option => $setter) {
    if (isset($sugar_config[$option])) {
        $value = $sugar_config[$option];
        $call->$setter($value);
    }
}

$call->setExtension($_POST['ext'])->setNumber($_POST['num']);
$call->call();

class ClickToCall
{
    protected $_asteriskIp;
    protected $_asteriskPort = 8088;

    protected $_timeOut = 5000;

    protected $_number = null;
    protected $_extension = null;

    public function __construct()
    {
        openlog('click-to-call', LOG_NDELAY | LOG_PID, LOG_LOCAL0);
    }

    public function __destruct()
    {
        closelog();
    }

    public function call()
    {
        $asterisk = $this->getAsteriskIp();
        $asteriskPort = $this->getAsteriskPort();
        $extension = $this->getExtension();
        $numberCall = $this->cleanNumber($this->getNumber());

        syslog(LOG_DEBUG, 'Start call');
        syslog(LOG_DEBUG, 'Asterisk: ' . $this->getAsteriskIp());
        syslog(LOG_DEBUG, 'Calling extension: ' . $extension);
        syslog(LOG_DEBUG, 'Number to call: ' . $numberCall);
        $url = urlencode("http://$asterisk:$asteriskPort/makecall?extension=$extension&destination=$numberCall&payload=json");
        syslog(LOG_DEBUG, 'Calling URL: ' . $url);
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // connect time out 2 seconds 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1500); 
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000); 
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        if (!empty($result)) {
            $data = json_decode($result, true);
            if (!empty($data)) {
                syslog(LOG_DEBUG, 'Result: ' . $data['result']);
            } 
        }        
    }

    public function cleanNumber($number)
    {

        $num = trim($number);
        $num = str_replace(array(
            '-',
            ' ',
            '%',
            '+',
            '(',
            ')'
        ), '', $num);

        return $num;

    }

    public function setTimeOut($timeOut)
    {
        $this->_timeOut = $timeOut;
        return $this;
    }

    public function getTimeOut()
    {
        return $this->_timeOut;
    }

    public function setNumber($number)
    {
        $this->_number = $number;
        return $this;
    }

    public function getNumber()
    {
        return $this->_number;
    }

    public function setExtension($extension)
    {
        $this->_extension = $extension;
        return $this;
    }

    public function getExtension()
    {
        return $this->_extension;
    }

    public function setAsteriskIp($asteriskIp)
    {
        $this->_asteriskIp = $asteriskIp;
        return $this;
    }

    public function getAsteriskIp()
    {
        return $this->_asteriskIp;
    }

    public function setAsteriskPort($asteriskPort)
    {
        $this->_asteriskPort = $asteriskPort;
        return $this;
    }

    public function getAsteriskPort()
    {
        return $this->_asteriskPort;
    }

}

