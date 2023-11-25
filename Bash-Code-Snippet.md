### Bash Code Snippet



### Add SSH key for user
```
cat ~/.ssh/id_rsa.pub | ssh root@127.0.0.1 "mkdir -p ~/.ssh && touch ~/.ssh/authorized_keys && chmod -R go= ~/.ssh && cat >> ~/.ssh/authorized_keys"
```


### Add SSH key for root
```
cat ~/.ssh/id_rsa.pub | ssh root@127.0.0.1 "mkdir -p /root/.ssh && touch /root/.ssh/authorized_keys && chmod -R go= /root/.ssh && cat >> /root/.ssh/authorized_keys"
```