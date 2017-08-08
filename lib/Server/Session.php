<?php

namespace Spell\Server;

/**
 * Description of Session
 *
 * @author moysesoliveira
 */
class Session {

    /**
     * 
     * @param string $name
     * @param int $timeoutMinutes
     * @throws \Exception
     */
    public function start(string $name, int $timeoutMinutes = 0)
    {
        if(session_status() !== PHP_SESSION_NONE)
            throw new \Exception('Session already started.');

        session_name(md5($name));
        if($timeoutMinutes)
            session_set_cookie_params($timeoutMinutes * 60);

        session_start();
    }

    /**
     * Session get param
     * 
     * @param string $key
     * @return string, array
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Session set param
     * 
     * @param string $key
     * @param * $value
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Session set params
     * 
     * @param array $params
     */
    public function setParams($params)
    {
        foreach($params as $key => $value)
            $this->set($key, $value);
    }

    /**
     * Session unset param
     * 
     * @param string $key
     * @param * $value
     */
    public function removeParam(string $key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Session destroy
     * 
     */
    public function destroy()
    {
        session_destroy();
    }

}
