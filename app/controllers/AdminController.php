<?php
class AdminController extends Controller
{
    public function index()
    {
        $this->requireAdmin();
        $userModel    = $this->model('User');
        $workoutModel = $this->model('Workout');
        $exerciseModel = $this->model('Exercise');
        $measurementModel = $this->model('Measurement');

        $this->render('admin/index', [
            'title'          => 'Admin panel',
            'totalUsers'     => $userModel->getTotalUsers(),
            'totalWorkouts'  => $workoutModel->count(),
            'totalExercises' => $exerciseModel->count(),
            'totalMeasurements' => $measurementModel->count(),
            'globalStats'    => $workoutModel->getGlobalStats(),
            'exercisesByType'=> $exerciseModel->countByType(),
        ]);
    }

    public function users()
    {
        $this->requireAdmin();
        $userModel = $this->model('User');
        $this->render('admin/users', [
            'title' => 'Korisnici',
            'users' => $userModel->getAllWithStats(),
        ]);
    }

    public function stats()
    {
        $this->requireAdmin();
        $workoutModel  = $this->model('Workout');
        $exerciseModel = $this->model('Exercise');
        $this->render('admin/stats', [
            'title'          => 'Statistika',
            'globalStats'    => $workoutModel->getGlobalStats(),
            'exercisesByType'=> $exerciseModel->countByType(),
        ]);
    }
}
