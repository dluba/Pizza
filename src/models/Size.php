<?php
namespace App\models;
use App\config\Database;
use App\interfaces\ISize;
use PDO;
class Size implements ISize {
    protected $id;
    protected $size;
    protected $price;
    private $priceBYN;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->size = $data['size'];
        $this->price = $data['price'];
        $this->priceBYN = $this->convertToBYN($data['price']);
    }

    private function convertToBYN(float $priceUSD): float {
        $url = "https://api.nbrb.by/exrates/rates/431";
        $response = @file_get_contents($url);
        $data = json_decode($response, true);
        return $priceUSD * ($data['Cur_OfficialRate'] ?? 3.25);
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->size; }
    public function getPrice(): float { return $this->price; }
    public function getPriceBYN(): float { return $this->priceBYN; }

    public static function getAll(): array {
        //require_once __DIR__ . '/../../config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM pizza_sizes");
        return array_map(fn($data) => new Size($data), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function getById(int $id): ?Size {
        //require_once __DIR__ . '/../../config/Database.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM pizza_sizes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Size($data) : null;
    }
}