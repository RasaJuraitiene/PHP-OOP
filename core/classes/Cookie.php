<?php


namespace Core;


class Cookie extends \Core\Abstracts\Cookie
{

    /**
     * @inheritDoc
     */
    public function __construct(string $name)
    {

        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function exists(): bool
    {
        if(isset($this->name)){
            return true;
        }
    }

    /**
     * @inheritDoc
     */
    public function read(): array
    {
        $cookie_array =[];
        if(isset($_COOKIE[$this->name])){
            return $json_array = json_decode($_COOKIE[$this->name], true);
        }else{
            return $cookie_array;
        }
    }

    /**
     * @inheritDoc
     */
    public function save(array $data, int $expires_in = 3600): void
    {
        // TODO: Implement save() method.
        $cookie_string = json_encode($data);
        setcookie($this->name, $cookie_string, $expires_in, "/");
    }

    /**
     * @inheritDoc
     */
    public function delete(): void
    {
        setcookie($this->name, null, -1, "/");
    }
}