<?php
class WorkoutsController extends Controller
{
    public function index()
    {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        $workoutModel = $this->model('Workout');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $totalWorkouts = $workoutModel->countByUser($userId);
        $totalPages = ceil($totalWorkouts / ITEMS_PER_PAGE);
        $workouts = $workoutModel->getByUser($userId, $page);
        $this->render('workouts/index', [
            'title' => 'Moji treninzi',
            'workouts' => $workouts,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
    public function viewWorkout($id)
    {
        $this->requireLogin();
        $workoutModel = $this->model('Workout');
        $workout = $workoutModel->findById($id);
        if (!$workout || $workout['user_id'] != $_SESSION['user_id']) {
            $this->notFound();
        }
        $exercises = $workoutModel->getWithExercises($id);
        $totalCalories = $workoutModel->getTotalCalories($id);
        $this->render('workouts/view', [
            'title' => 'Trening - ' . $workout['date'],
            'workout' => $workout,
            'exercises' => $exercises,
            'totalCalories' => $totalCalories
        ]);
    }
    public function create()
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            $durationMinutes = (int) ($_POST['duration_minutes'] ?? 0);
            $notes = trim($_POST['notes'] ?? '');
            $exerciseIds = $_POST['exercise_id'] ?? [];
            $setsCounts = $_POST['sets_count'] ?? [];
            $reps = $_POST['reps'] ?? [];
            $durations = $_POST['duration'] ?? [];
            $calories = $_POST['calories_burned'] ?? [];

            if (empty($date) || $durationMinutes <= 0 || empty($exerciseIds)) {
                $this->setFlash('Unesite datum, trajanje i barem jednu vezbu', 'danger');
                $this->redirect('/workouts/create');
            }
            $exerciseData = [];
            for ($i = 0; $i < count($exerciseIds); $i++) {
                $exerciseData[] = [
                    'exercise_id' => $exerciseIds[$i],
                    'sets_count' => !empty($setsCounts[$i]) ? (int) $setsCounts[$i] : null,
                    'reps' => !empty($reps[$i]) ? (int) $reps[$i] : null,
                    'duration_minutes' => !empty($durations[$i]) ? (int) $durations[$i] : null,
                    'calories_burned' => !empty($calories[$i]) ? (float) $calories[$i] : null
                ];
            }
            $workoutModel = $this->model('Workout');
            $workoutId = $workoutModel->createWithExercises(
                [
                    'user_id' => $_SESSION['user_id'],
                    'date' => $date,
                    'duration_minutes' => $durationMinutes,
                    'notes' => $notes
                ],
                $exerciseData
            );
            if ($workoutId) {
                $this->setFlash('Trening uspesno dodat!', 'success');
                $this->redirect('/workouts/view/' . $workoutId);
            } else {
                $this->setFlash('Greska pri kreiranju treninga', 'danger');
                $this->redirect('/workouts/create');
            }
        }
        $exerciseModel = $this->model('Exercise');
        $exercises = $exerciseModel->findAll([], 'name ASC');
        $this->render('workouts/create', [
            'title' => 'Novi trening',
            'exercises' => $exercises
        ]);
    }
    public function delete($id)
    {
        $this->requireLogin();
        $workoutModel = $this->model('Workout');
        $workout = $workoutModel->findById($id);
        if (!$workout || $workout['user_id'] != $_SESSION['user_id']) {
            $this->notFound();
        }
        $workoutModel->delete($id);
        $this->setFlash('Trening obrisan.', 'success');
        $this->redirect('/workouts');
    }

    public function edit($id)
    {
        $this->requireLogin();
        $workoutModel = $this->model('Workout');
        $workout = $workoutModel->findById($id);
        if (!$workout || $workout['user_id'] != $_SESSION['user_id']) {
            $this->notFound();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            $durationMinutes = (int) ($_POST['duration_minutes'] ?? 0);
            $notes = trim($_POST['notes'] ?? '');
            if (empty($date) || $durationMinutes <= 0) {
                $this->setFlash('Unesite datum i trajanje', 'danger');
                $this->redirect('/workouts/edit/' . $id);
            }
            $workoutModel->update($id, [
                'date' => $date,
                'duration_minutes' => $durationMinutes,
                'notes' => $notes
            ]);
            $this->setFlash('Trening uspesno izmenjen!', 'success');
            $this->redirect('/workouts/view/' . $id);
        }
        $this->render('workouts/edit', [
            'title' => 'Izmeni trening',
            'workout' => $workout
        ]);
    }
}
