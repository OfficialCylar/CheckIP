<?php 



class CheckIP
{
    public string $IPAddress;
    public static string $vpn_blacklist;
    public static string $TorList;
    public function __construct()
    {
        $this->IPAddress = $_SERVER['REMOTE_ADDR'];
    }

    public function _checkblacklist(array $list): bool
    {
        return in_array($this->IPAddress, $list);

    }

    public function whatsMyip(): string
    {
        return $this->IPAddress;
    }

    public static function get_updated_tor_nodes(string $list): array
    {
        self::$TorList = $list;
        $link = file_get_contents(self::$TorList);
        return explode("\n", trim($link));

    }

    public static function get_vpn_list(string $vpnlist): array 
    {
        self::$vpn_blacklist = $vpnlist; 
        $link = file_get_contents(self::$vpn_blacklist);
        return explode("\n", trim($link));
    }
    // Just because cba writing it every damn time.
    public function ArrayOutput(array $arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

// retreive tor blacklist and vpn blacklist
$torblacklist_array = CheckIP::get_updated_tor_nodes('https://check.torproject.org/torbulkexitlist');
$vpnblacklist_array = CheckIP::get_vpn_list('https://raw.githubusercontent.com/X4BNet/lists_vpn/main/ipv4.txt');
// Create Connections class
$conn = new CheckIP();
// Optional Output lists.

$conn->ArrayOutput($torblacklist_array);
$conn->ArrayOutput($vpnblacklist_array);
// Outputs IP Address
echo $conn->whatsMyip();
if($conn->_checkblacklist($torblacklist_array) || $conn->_checkblacklist($vpnblacklist_array)) {
    echo 'Using vpn or tor is prohibited!' . '<br>';
    header('Location: 404.php');
    die();
} else {

}

?>
