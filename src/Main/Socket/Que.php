<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/21/14
 * Time: 4:08 PM
 */

namespace Main\Socket;


use Main\CTL\CallCTL;
use Main\CTL\HideCTL;
use Main\CTL\HideManyCTL;
use Main\CTL\InitCTL;
use Main\CTL\RemarkCTL;
use Main\CTL\ShowCTL;
use Main\CTL\SkipCTL;
use Main\Helper\GeneralHelper;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Que implements MessageComponentInterface {
    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    /**
     * @var \SplObjectStorage[] $subscribe
     */
    protected $clients, $subscribe = array();

    public function __construct(){
        $this->clients = new \SplObjectStorage();
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "Connection {$conn->resourceId} has connected\n";
        flush();
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        foreach($this->subscribe as $value){
            $value->detach($conn);
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
        unset($conn);

        flush();
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        flush();

        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $json = json_decode($msg, true);

        if(isset($json['action'])) {
            $action = explode("/", $json['action']['name']);
            $param = isset($json['action']['param'])? $json['action']['param']: null;
            $res = GeneralHelper::curl_post(
                GeneralHelper::base_url()."/api.php?".http_build_query(array('ctl'=> $action[0], 'method'=> $action[1])),
                $param
            );
            $from->send(json_encode(array('action'=> array('name'=> $json['action']['name'], 'data'=> $res))));
            unset($res);
        }
        if(isset($json['subscribe'])){
            foreach($json['subscribe'] as $value){
                $this->getSubscribe($value)->attach($from);

                echo "subscribe ".$value."\n";
            }
        }
        if(isset($json['publish'])){
            $subs = $this->getSubscribe($json['publish']['name']);
            $subs->rewind();
            while($subs->valid()) {
                $sub = $subs->current();
                $sub->send(json_encode(array(
                    "publish"=> array(
                        "name"=> $json['publish']['name'],
                        "data"=> $json['publish']['data']
                    )
                )));

                var_dump($sub);

                echo "publish ".$json['publish']['name']."\n";

                $subs->next();
            }
        }

        echo memory_get_usage().','.memory_get_usage(true)."\n";
    }

    function getSubscribe($name){
        if(!isset($this->subscribe[$name])){
            $this->subscribe[$name] = new \SplObjectStorage();
        }
        return $this->subscribe[$name];
    }
}