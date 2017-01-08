<?php

namespace MicroMir\Error;

class ErrorHandler
{
    static private $instance;

    private $c; // используется в __DIR__.'/trace.php'

    private $headerMessages = [];

    private $headerMessagesDefault = [];

    private $traceResult; // используется в __DIR__.'/trace.php'

    private function getErrorName($error) {
        $errors = [
            E_ERROR             => 'ERROR',
            E_WARNING           => 'WARNING',
            E_PARSE             => 'PARSE',
            E_NOTICE            => 'NOTICE',
            E_CORE_ERROR        => 'CORE_ERROR',
            E_CORE_WARNING      => 'CORE_WARNING',
            E_COMPILE_ERROR     => 'COMPILE_ERROR',
            E_COMPILE_WARNING   => 'COMPILE_WARNING',
            E_USER_ERROR        => 'USER_ERROR',
            E_USER_WARNING      => 'USER_WARNING',
            E_USER_NOTICE       => 'USER_NOTICE',
            E_STRICT            => 'STRICT',
            E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
            E_DEPRECATED        => 'DEPRECATED',
            E_USER_DEPRECATED   => 'USER_DEPRECATED',
            3                   => 'not_caught_Exception',
        ];
        if(array_key_exists($error, $errors)){
            return $errors[$error];
        }
    }

    private function __construct()
    {
        set_error_handler([$this, 'error']);

        set_exception_handler([$this, 'exception']);

        register_shutdown_function([$this, 'fatalError']);

        $this->headerMessagesDefault['header']    = '500 Internal Server Error';
        $this->headerMessagesDefault['message'][] = 'Сервер отдыхает. Зайдите позже.';
        $this->headerMessagesDefault['message'][] = "Don't worry! Chip 'n Dale Rescue Rangers";
   }

    static public function instance()
    {
        self::$instance
            ?: self::$instance = new self;
        return self::$instance;
    }

    public function setRoot($c) {
        $this->c = $c;
    }

    public function error()
    {
        $this->traceHandler($debug = debug_backtrace());

        $this->notify(
            $debug[0]['args'][0],                       // code
            $this->getErrorName($debug[0]['args'][0]),  // name
            $debug[0]['args'][1],                       // message
            $debug[0]['args'][1],                       // log message
            $debug[0]['args'][2],                       // file
            $debug[0]['args'][3]                        // line
        );
        return true;
    }

    public function exception()
    {
        $args    = debug_backtrace()[0]['args'][0];
        $code    = $args->getCode();
        $message = $args->getMessage();
        $file    = $args->getFile();
        $line    = $args->getLine();

        if ($args instanceof \ParseError) {
            $code = 4;
            $this->sendHeaderMessage();

        } elseif ($args instanceof \Error) {
            $code = 1;
            $this->sendHeaderMessage();

        } elseif ($args instanceof \Exception && $code == 0) {
            $code = 3;
            $this->sendHeaderMessage();
        }
        $name = $this->getErrorName($code);

        $traceArr = [];
        $traceArr[0]['file'] = $file;
        $traceArr[0]['line'] = $line;

        $this->traceHandler(array_merge($traceArr, $args->getTrace()));

        $this->notify(
            $code,
            $name,
            $message,
            $message,
            $file,
            $line
        );
        return true;
    }


    public function microException($obj, $traceNumber)
    {
        $trace   = $obj->getTrace();
        $message = $obj->getMessage();

        if (is_string($traceNumber)) {
            $arr = explode('::', $traceNumber);
            $file = $arr[0];
            $line = isset($arr[1]) ? $arr[1] : '';
            $traceNumber = 0;

        } elseif (isset($trace[$traceNumber]['file'])) {
            $file = $trace[$traceNumber]['file'];
            $line = $trace[$traceNumber]['line'];
        } else {
            $file = '';
            $line = '<-';
        }
        $this->traceHandler($trace, $traceNumber);

        $this->notify(
            $obj->getCode(),                    // code
            'Micro_Exception',                  // name
            $message['displayError'],           // message
            $message['logError'],               // log message
            $file,
            $line
        );
    }

    public function fatalError()
    {
        if ($error = error_get_last()) {
            ob_end_clean();
            $this->traceHandler(debug_backtrace());

            $this->notify(
                $error['type'],
                $this->getErrorName($error['type']),
                $error['message'],
                $error['message'],
                $error['file'],
                $error['line']
            );
            $this->sendHeaderMessage();
        }
    }


    public function setHeaderMessage($array = null)
    {
        if ($array === null) {
            $this->errorParam('empty parametrs');
            return $this;
        }
        if (!array_key_exists('marker', $array)) {
            $this->errorParam("missing key 'marker'");
            return $this;
        }
        $this->headerMessages[$array['marker']]
            = array_merge($this->headerMessagesDefault, $array);

        return $this;
    }

    private function errorParam($params)
    {
        $deb = debug_backtrace()[1];
        $this->notify(2, 'USER_WARNING', $params, $deb['file'], $deb['line']);
    }

    private function sendHeaderMessage($phrase = '')
    {
        if (defined('MICRO_DEVELOPMENT') && MICRO_DEVELOPMENT === true) return;

        if (isset($GLOBALS['MICRO_ERROR_MARKER'])
            && isset($this->headerMessages[$GLOBALS['MICRO_ERROR_MARKER']])
        ) {
            $arr = $this->headerMessages[$GLOBALS['MICRO_ERROR_MARKER']];
        } else {
            $arr = $this->headerMessagesDefault;
        }

        $statusCode = explode(' ', $arr['header'])[0];
        $message = $arr['message'];

        if (!headers_sent()) {
            header($_SERVER['SERVER_PROTOCOL'].' '.$arr['header']);
        }
        if (defined('MICRO_ERROR_PAGE')) {
            include MICRO_ERROR_PAGE;
        } else {
            include(__DIR__.'/500.php');
        }
    }


    private function notify($code, $name, $message, $logMess, $file, $line)
    {
        include(__DIR__.'/notify.php');
    }


    private function traceHandler($trace, int $traceNumber = 0)
    {
        $thisClass = __CLASS__;

        include(__DIR__.'/trace.php');

    }
}
