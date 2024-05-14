# NVM instructions Linux(Ubuntu)

## Before Installation
```bash
sudo apt update && sudo apt upgrade
```

## Fetch installation script and pass it to BASH
```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash
```

## Add script to your source
```bash
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
```

## Check Version
```bash
nvm --version
```


## Install nodejs lts(Long-Term Support)
```bash
nvm install --lts
```
