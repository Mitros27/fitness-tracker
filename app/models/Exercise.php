<?php
class Exercise extends Model
{
    protected $table = 'exercises';

    // Pronađi vežbe po tipu
    public function findByType($type)
    {
        return $this->findAll(['type' => $type], 'name ASC');
    }

    public function countByType()
    {
        $sql = "SELECT type, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY type";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    public function getPaginated($page = 1, $perPage = ITEMS_PER_PAGE)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * 
                FROM {$this->table}
                ORDER BY name ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->query($sql, [':limit' => $perPage, ':offset' => $offset]);
        return $stmt->fetchAll();
    }
    public function search($keyword)
    {
        $sql = "SELECT * 
                FROM {$this->table} 
                WHERE name LIKE :keyword
                ORDER BY name ASC";
        $stmt = $this->query($sql, [':keyword' => "%$keyword%"]);
        return $stmt->fetchAll();
    }
}
