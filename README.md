## Start the stack with docker compose

```bash
$ ./run.sh
```

## Stop the stack with docker compose

```bash
$ ./stop.sh
```

```bash
$ ./test.sh
```

### Config redis

```text
cluster-enabled yes

masterauth admin

# 1Mb
maxmemory 1048576

# volatile-lru -> Evict using approximated LRU among the keys with an expire set.
# allkeys-lru -> Evict any key using approximated LRU.
# volatile-lfu -> Evict using approximated LFU among the keys with an expire set.
# allkeys-lfu -> Evict any key using approximated LFU.
# volatile-random -> Remove a random key among the ones with an expire set.
# allkeys-random -> Remove a random key, any key.
# volatile-ttl -> Remove the key with the nearest expire time (minor TTL)
# noeviction -> Don't evict anything, just return an error on write operations.

maxmemory-policy volatile-random


```