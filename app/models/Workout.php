<?php
class Workout extends Model
{
    protected $table = 'workouts';

    public function getByUser($userId, $page = 1, $perPage = ITEMS_PER_PAGE)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id
                ORDER BY date DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->query($sql, [
            ':user_id' => $userId,
            ':limit' => $perPage,
            ':offset' => $offset
        ]);
        return $stmt->fetchAll();
    }

    public function countByUser($userId)
    {
        return $this->count(['user_id' => $userId]);
    }

    public function createWithExercises($workoutData, $exercises)
    {
        $this->beginTransaction();
        try {
            $workoutId = $this->create($workoutData);
            foreach ($exercises as $exercise) {
                $exercise['workout_id'] = $workoutId;
                $sql = "INSERT INTO workout_exercises
                (workout_id, exercise_id, sets_count, reps, duration_minutes, calories_burned) 
                VALUES(:workout_id, :exercise_id, :sets_count, :reps, :duration_minutes, :calories_burned)";
                $this->query($sql, [
                    ':workout_id' => $exercise['workout_id'],
                    ':exercise_id' => $exercise['exercise_id'],
                    ':sets_count' => $exercise['sets_count'] ?? null,
                    ':reps' => $exercise['reps'] ?? null,
                    ':duration_minutes' => $exercise['duration_minutes'] ?? null,
                    ':calories_burned' => $exercise['calories_burned'] ?? null
                ]);
            }
            $this->commit();
            return $workoutId;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function getWithExercises($workoutId)
    {
        $sql = "SELECT we.*, e.name, e.type, e.calories_per_minute
                FROM workout_exercises we
                JOIN exercises e ON we.exercise_id = e.id
                WHERE we.workout_id = :workout_id";
        $stmt = $this->query($sql, [':workout_id' => $workoutId]);
        return $stmt->fetchAll();
    }

    public function getTotalCalories($workoutId)
    {
        $sql = "SELECT SUM(calories_burned) as total
                FROM workout_exercises
                WHERE workout_id = :workout_id";
        $stmt = $this->query($sql, [':workout_id' => $workoutId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function getCaloriesByMonth($userId)
    {
        $sql = "SELECT DATE_FORMAT(w.date, '%Y-%m') as month,
                    SUM(we.calories_burned) as total_calories
                FROM {$this->table} w 
                JOIN workout_exercises we ON w.id = we.workout_id
                WHERE w.user_id = :user_id
                GROUP BY month
                ORDER BY month ASC";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getWorkoutsByMonth($userId)
    {
        $sql = "SELECT DATE_FORMAT(date, '%Y-%m') as month, COUNT(*) as total_workouts
                FROM {$this->table}
                WHERE user_id = :user_id
                GROUP BY month
                ORDER BY month ASC";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getWorkoutsByType($userId)
    {
        $sql = "SELECT e.type, COUNT(*) as total
                FROM {$this->table} w
                JOIN workout_exercises we ON w.id = we.workout_id
                JOIN exercises e ON we.exercise_id = e.id
                WHERE w.user_id = :user_id
                GROUP BY e.type";
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

    public function getCaloriesByDateRange($userId, $dateFrom, $dateTo)
    {
        $sql = "SELECT w.date, SUM(we.calories_burned) as total_calories
                FROM {$this->table} w
                JOIN workout_exercises we ON w.id = we.workout_id
                WHERE w.user_id = :user_id
                AND w.date BETWEEN :date_from AND :date_to
                GROUP BY w.date
                ORDER BY w.date ASC";
        $stmt = $this->query($sql, [
            ':user_id' => $userId,
            ':date_from' => $dateFrom,
            ':date_to' => $dateTo
        ]);
        return $stmt->fetchAll();
    }

    public function getGlobalStats()
    {
        $sql = "SELECT COUNT(*) as total_workouts,
                    SUM(duration_minutes) as total_minutes,
                    COALESCE(SUM(we.total_cal), 0) as total_calories
                FROM {$this->table} w
                LEFT JOIN (
                    SELECT workout_id, SUM(calories_burned) as total_cal
                    FROM workout_exercises GROUP BY workout_id
                ) we ON w.id = we.workout_id";
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }

    public function getUserStats($userId)
    {
        $sql = "SELECT COUNT(*) as total_workouts,
                SUM(duration_minutes) as total_minutes,
                AVG(duration_minutes) as avg_duration
                FROM {$this->table}
                WHERE user_id = :user_id";
        $stmt = $this->query($sql, [':user_id' => $userId]);
        return $stmt->fetch();
    }
}
