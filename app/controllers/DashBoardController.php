<?php
class DashBoardController extends Controller
{
    public function index()
    {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        $workoutModel = $this->model('Workout');
        $measurementModel = $this->model('Measurement');
        $stats = $workoutModel->getUserStats($userId);
        $latestMeasurement = $measurementModel->getLatest($userId);
        $caloriesByMonth = $workoutModel->getCaloriesByMonth($userId);
        $workoutsByMonth = $workoutModel->getWorkoutsByMonth($userId);
        $workoutsByType = $workoutModel->getWorkoutsByType($userId);
        $weightHistory = $measurementModel->getWeightHistory($userId);
        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'latestMeasurement' => $latestMeasurement,
            'caloriesByMonth' => json_encode($caloriesByMonth),
            'workoutsByMonth' => json_encode($workoutsByMonth),
            'workoutsByType' => json_encode($workoutsByType),
            'weightHistory' => json_encode($weightHistory)
        ]);
    }
}
