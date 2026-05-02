<?php
class Measurement extends Model
{
    protected $table = 'measurements';

    public function getByUser($user_id, $page = 1, $perPage = ITEMS_PER_PAGE)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id
                ORDER BY date DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->query($sql, [
            ':user_id' => $user_id,
            ':limit' => $perPage,
            ':offset' => $offset
        ]);
        return $stmt->fetchAll();
    }
    public function countByUser($userId)
    {
        return $this->count(['user_id' => $userId]);
    }
    public function getWeightHistory($userId)
    {
        $sql = "SELECT date, weight
                FROM {$this->table}
                WHERE user_id = :user_id
                AND weight IS NOT NULL
                ORDER BY date ASC";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetchAll();
    }
    public function getBodyFatHistory($userId)
    {
        $sql = "SELECT date, body_fat_percentage
                FROM {$this->table}
                WHERE user_id = :user_id
                AND body_fat_percentage IS NOT NULL
                ORDER BY date ASC";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByDateRange($userId, $dateFrom, $dateTo)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = :user_id 
                AND date BETWEEN :date_from AND :date_to 
                ORDER BY date ASC";
        $stmt = $this->query($sql, [
            ':user_id' => $userId,
            ':date_from' => $dateFrom,
            ':date_to' => $dateTo
        ]);
        return $stmt->fetchAll();
    }
    public function getLatest($userId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = :user_id 
                ORDER BY date DESC 
                LIMIT 1";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetch();
    }
}
