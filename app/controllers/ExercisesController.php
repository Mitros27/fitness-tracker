<?php
class ExercisesController extends Controller
{
    public function index()
    {
        $exerciseModel = $this->model('Exercise');
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $totalExercise = $exerciseModel->count();
        $totalPages = ceil($totalExercise / ITEMS_PER_PAGE);
        $exercises = $exerciseModel->getPaginated($page);
        $this->render('exercises/index', [
            'title' => 'Katalog vezbi',
            'exercises' => $exercises,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
    public function viewExercise($id)
    {
        $exerciseModel = $this->model('Exercise');
        $exercise = $exerciseModel->findById($id);
        if (!$exercise) {
            $this->notFound();
        }
        $this->render('exercises/view', [
            'title' => $exercise['name'],
            'exercise' => $exercise
        ]);
    }
    public function create()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = $_POST['type'] ?? '';
            $caloriesPerMinute = $_POST['calories_per_minute'] ?? 0;
            $description = trim($_POST['description'] ?? '');
            if (empty($name) || empty($type) || empty($caloriesPerMinute)) {
                $this->setFlash('Naziv, tip i kalorije su obavezni', 'danger');
                $this->redirect('/exercises/create');
            }
            $exerciseModel = $this->model('Exercise');
            $exerciseModel->create([
                'name' => $name,
                'type' => $type,
                'calories_per_minute' => $caloriesPerMinute,
                'description' => $description
            ]);
            $this->setFlash('Vezba uspesno dodata', 'success');
            $this->redirect('/exercises');
        }
        $this->render('exercises/create', [
            'title' => 'Dodaj vezbu'
        ]);
    }
    public function edit($id)
    {
        $this->requireAdmin();
        $exerciseModel = $this->model('Exercise');
        $exercise = $exerciseModel->findById($id);
        if (!$exercise) {
            $this->notFound();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = $_POST['type'] ?? '';
            $calories_per_minute = $_POST['calories_per_minute'] ?? 0;
            $description = trim($_POST['description'] ?? '');
            if (empty($name) || empty($type) || empty($calories_per_minute)) {
                $this->setFlash('Ime, tip i kalorije su obavezni', 'danger');
                $this->redirect('/exercises/edit/' . $id);
            }
            $exerciseModel->update($id, [
                'name' => $name,
                'type' => $type,
                'calories_per_minute' => $calories_per_minute,
                'description' => $description
            ]);
            $this->setFlash('Vezba uspesno promenjena', 'success');
            $this->redirect('/exercises');
        }
        $this->render('exercises/edit', [
            'title' => 'Izmeni Vezbu',
            'exercise' => $exercise
        ]);
    }
    public function delete($id)
    {
        $this->requireAdmin();
        $exerciseModel = $this->model('Exercise');
        $exercise = $exerciseModel->findById($id);
        if (!$exercise) {
            $this->notFound();
        }
        $exerciseModel->delete($id);
        $this->setFlash('Vezba uspesno izbrisana', 'success');
        $this->redirect('/exercises');
    }
}
