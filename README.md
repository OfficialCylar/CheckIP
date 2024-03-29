# CheckIP Class

## Overview
The `CheckIP` class is a PHP utility designed for educational purposes. It allows you to check a user's IP address against Tor nodes and a VPN blacklist. This is particularly useful for gaining insights into network security and user anonymity practices.

## Features
- **IP Validation**: Determines if a user's IP address is part of Tor exit nodes or a VPN blacklist.
- **Dynamic List Retrieval**: Fetches updated Tor and VPN blacklists directly from specified URLs.
- **IP Display**: Conveniently displays the user's current IP address.

## Usage
To utilize the `CheckIP` class in your project, follow these steps:

```php
include 'CheckIP.php'; // Ensure this path points to your CheckIP class file

// Create an instance of the CheckIP class
$checkIP = new CheckIP();

// Retrieve and display updated Tor and VPN blacklists
$torListURL = 'https://check.torproject.org/torbulkexitlist'; // Tor list URL
$vpnListURL = 'https://raw.githubusercontent.com/X4BNet/lists_vpn/main/ipv4.txt'; // VPN list URL
$torBlacklistArray = CheckIP::get_updated_tor_nodes($torListURL);
$vpnBlacklistArray = CheckIP::get_vpn_list($vpnListURL);
$checkIP->ArrayOutput($torBlacklistArray);
$checkIP->ArrayOutput($vpnBlacklistArray);

// Display the user's IP address
echo "Your IP is: " . $checkIP->whatsMyip() . "<br>";

// Check if the user's IP address is on either blacklist
if ($checkIP->_checkblacklist($torBlacklistArray) || $checkIP->_checkblacklist($vpnBlacklistArray)) {
    echo 'Using VPN or Tor is prohibited!' . '<br>';
    header('Location: 404.php'); // Redirect to a custom error page
    exit;
}
