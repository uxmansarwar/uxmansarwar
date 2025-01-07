

check_and_install() {
    local package=$1
    if ! command -v $package &>/dev/null; then
        echo "$package is not installed. Installing..."
        sudo apt update && sudo apt install -y $package
    fi
}