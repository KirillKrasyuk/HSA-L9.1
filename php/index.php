<?php

class Connection
{
    private static array $connections = [
        'redis' => null
    ];

    protected function __construct() {}

    public static function getRedisConnection(): Redis
    {
        if (!self::$connections['redis']) {
            self::$connections['redis'] = new Redis();
            self::$connections['redis']->connect('redis-master', 6379);
        }

        return self::$connections['redis'];
    }
}

class Server
{
    const ITEMS_COUNT = 10000000;
    const DATA_TTL = 600;

    public function __construct(
        private Redis $cache
    ) {
    }

    public function initData()
    {
        for ($i = 0; $i < self::ITEMS_COUNT; $i++) {
            $this->cache->set(sprintf('key_%s', $i), $this->genUuid(), self::DATA_TTL);
        }

        echo 'Init done' . PHP_EOL;
    }

    public function selectData()
    {
        $itemsCount = 0;

        for ($i = 0; $i < self::ITEMS_COUNT; $i++) {
            if ($item = $this->cache->get(sprintf('key_%s', $i))) {
                $itemsCount++;
            }
        }

        echo sprintf('Count: %s', $itemsCount) . PHP_EOL;
    }

    private function genUuid(): string {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

$server = new Server(
    Connection::getRedisConnection()
);

$server->initData();
$server->selectData();