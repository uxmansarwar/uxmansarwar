

check_and_install() {
    local package=$1
    if ! command -v $package &>/dev/null; then
        echo "$package is not installed. Installing..."
        sudo apt update && sudo apt install -y $package
    fi
}

is_on_battery() {
    upower -i $(upower -e | grep 'BAT') | grep -q "state:.*discharging"
}