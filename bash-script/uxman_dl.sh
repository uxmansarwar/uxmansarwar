#!/bin/bash

set -e

# Get the directory of the current script
script_dir=$(dirname "$(realpath "$0")")

# Source the functions file using its absolute path
source "$script_dir/functions.sh"


# Display usage
usage() {
    echo "Usage: $0 [-o <output_path>] <url>"
    exit 1
}

# Parse arguments
path="~/Downloads"  # Default output path
while getopts "o:" opt; do
    case $opt in
        o) path=$OPTARG ;;
        *) usage ;;
    esac
done

shift $((OPTIND - 1))

# URL is the last argument
url=$1

if [ -z "$url" ]; then
    usage
fi

# Expand default output path if needed
path=${path/#\~/$HOME}

# Create output directory if it doesn't exist
if [ ! -d "$path" ]; then
    echo "Output path does not exist. Creating directories..."
    mkdir -p "$path"
fi

# Check and install required tools
check_and_install ffmpeg
check_and_install yt-dlp

# Fetch available formats and store output
yt-dlp -F "$url"

# Prompt user for input format
echo -n "Enter the format code to download (e.g., 137+bestaudio): "
read -r format

# If no input is provided, set the default format
if [ -z "$format" ]; then
    format="137+bestaudio"
    echo "No format provided. Using default format: $format"
fi


# Validate the format input
# if ! echo "$format" | grep -Eq "^[0-9]+(\+[a-zA-Z0-9]+)?$"; then
#     echo "Invalid format code. Please use a format like '137' or '137+bestaudio'."
#     exit 1
# fi



echo "Path is   > $path"
echo "URL is    > $url"
echo "Format is > $format"



# Run the download command
echo "Downloading the video..."
yt-dlp -f "$format" -o "$path/%(title)s.%(ext)s" "$url"

# Display completion message
echo "Download completed. File saved to: $path"
